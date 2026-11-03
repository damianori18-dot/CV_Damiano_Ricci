<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class CloudinaryImageStorage
{
    public function upload(UploadedFile $image): string
    {
        $cloudName = config('services.cloudinary.cloud_name');
        $apiKey = config('services.cloudinary.api_key');
        $apiSecret = config('services.cloudinary.api_secret');

        if (! is_string($cloudName) || $cloudName === ''
            || ! is_string($apiKey) || $apiKey === ''
            || ! is_string($apiSecret) || $apiSecret === '') {
            throw new RuntimeException('Cloudinary image storage is not configured.');
        }

        $parameters = [
            'folder' => 'projects',
            'timestamp' => time(),
        ];
        ksort($parameters);

        $signatureString = implode('&', array_map(
            static fn (string $key): string => $key.'='.$parameters[$key],
            array_keys($parameters),
        ));

        $endpoint = 'https://api.cloudinary.com/v1_1/'.rawurlencode($cloudName).'/image/upload';

        try {
            $response = Http::timeout(30)
                ->attach('file', $image->get(), $image->getClientOriginalName())
                ->post($endpoint, [
                    ...$parameters,
                    'api_key' => $apiKey,
                    'signature' => sha1($signatureString.$apiSecret),
                ]);
        } catch (ConnectionException $exception) {
            Log::error('Cloudinary image upload could not connect.', [
                'exception' => $exception::class,
            ]);

            throw new RuntimeException('Image upload failed because Cloudinary is unavailable.', previous: $exception);
        }

        if (! $response->successful()) {
            Log::error('Cloudinary image upload failed.', [
                'status' => $response->status(),
            ]);

            throw new RuntimeException('Cloudinary rejected the image upload.');
        }

        $secureUrl = $response->json('secure_url');

        if (! is_string($secureUrl)
            || filter_var($secureUrl, FILTER_VALIDATE_URL) === false
            || parse_url($secureUrl, PHP_URL_SCHEME) !== 'https') {
            Log::error('Cloudinary returned an invalid image URL.');

            throw new RuntimeException('Cloudinary returned an invalid image URL.');
        }

        return $secureUrl;
    }
}

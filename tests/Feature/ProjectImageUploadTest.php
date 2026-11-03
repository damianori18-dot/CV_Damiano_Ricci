<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

beforeEach(function () {
    config([
        'services.cloudinary.cloud_name' => 'test-cloud',
        'services.cloudinary.api_key' => 'test-key',
        'services.cloudinary.api_secret' => 'test-secret',
    ]);

    Http::fake([
        'https://api.cloudinary.com/*' => Http::response([
            'secure_url' => 'https://res.cloudinary.com/test-cloud/image/upload/projects/test-image.png',
        ]),
    ]);

    $admin = User::query()->create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => 'password',
    ]);
    $admin->forceFill(['isAdmin' => true])->save();

    $this->actingAs($admin);
});

test('new project images are uploaded to Cloudinary and the returned URL is saved', function () {
    $response = $this->post(route('projects.store'), [
        'title' => 'Portfolio',
        'description' => 'A sample project',
        'github_url' => 'https://github.com/example/portfolio',
        'image' => UploadedFile::fake()->image('portfolio.png'),
    ]);

    $response->assertRedirect(route('projects.create'));
    $project = Project::query()->firstOrFail();

    expect($project->image)
        ->toBe('https://res.cloudinary.com/test-cloud/image/upload/projects/test-image.png');

    Http::assertSent(function (Request $request): bool {
        $body = $request->body();
        preg_match('/name="timestamp"\r\n\r\n(\d+)/', $body, $matches);
        $timestamp = $matches[1] ?? null;

        if (! is_string($timestamp)) {
            return false;
        }

        $signature = sha1('folder=projects&timestamp='.$timestamp.'test-secret');

        return str_ends_with($request->url(), '/image/upload')
            && str_contains($body, "name=\"folder\"\r\n\r\nprojects")
            && str_contains($body, "name=\"api_key\"\r\n\r\ntest-key")
            && str_contains($body, 'name="signature"')
            && str_contains($body, $signature);
    });

    $this->get(route('projects.index'))
        ->assertOk()
        ->assertSee('https://res.cloudinary.com/test-cloud/image/upload/projects/test-image.png');
});

test('an existing project can replace its missing image without creating a duplicate', function () {
    $project = Project::query()->create([
        'title' => 'Portfolio',
        'description' => 'A sample project',
        'image' => 'projects/missing-image.png',
        'github_url' => 'https://github.com/example/portfolio',
    ]);

    $this->get(route('projects.edit', $project))
        ->assertOk()
        ->assertSee('Modifica progetto')
        ->assertSee('Portfolio');

    $response = $this->put(route('projects.update', $project), [
        'title' => 'Updated portfolio',
        'description' => 'Updated description',
        'github_url' => 'https://github.com/example/portfolio',
        'image' => UploadedFile::fake()->image('portfolio.png'),
    ]);

    $response->assertRedirect(route('projects.index'));
    $project->refresh();

    expect(Project::query()->count())->toBe(1)
        ->and($project->title)->toBe('Updated portfolio')
        ->and($project->image)
        ->toBe('https://res.cloudinary.com/test-cloud/image/upload/projects/test-image.png');
});

test('updating project details without a replacement image keeps its current image', function () {
    $project = Project::query()->create([
        'title' => 'Portfolio',
        'description' => 'A sample project',
        'image' => 'https://res.cloudinary.com/test-cloud/image/upload/projects/current.png',
        'github_url' => 'https://github.com/example/portfolio',
    ]);

    $this->put(route('projects.update', $project), [
        'title' => 'Updated portfolio',
        'description' => 'Updated description',
        'github_url' => 'https://github.com/example/portfolio',
    ])->assertRedirect(route('projects.index'));

    expect($project->refresh()->image)
        ->toBe('https://res.cloudinary.com/test-cloud/image/upload/projects/current.png');
});

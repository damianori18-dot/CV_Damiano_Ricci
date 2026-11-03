<?php

use App\Http\Middleware\AdminMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

test('users marked as admin can pass the middleware', function () {
    $request = Request::create('/admin/progetti/nuovo');
    $user = new User(['email' => 'admin@example.com']);
    $user->isAdmin = true;
    $request->setUserResolver(fn () => $user);

    $response = (new AdminMiddleware)->handle($request, fn () => new Response('ok'));

    expect($response->getContent())->toBe('ok');
});

test('non-admin users are forbidden', function () {
    $request = Request::create('/admin/progetti/nuovo');
    $user = new User(['email' => 'user@example.com']);
    $user->isAdmin = false;
    $request->setUserResolver(fn () => $user);

    expect(fn () => (new AdminMiddleware)->handle($request, fn () => new Response))
        ->toThrow(HttpException::class);
});

test('a user without an admin flag is denied', function () {
    $request = Request::create('/admin/progetti/nuovo');
    $request->setUserResolver(fn () => new User(['email' => 'user@example.com']));

    expect(fn () => (new AdminMiddleware)->handle($request, fn () => new Response))
        ->toThrow(HttpException::class);
});

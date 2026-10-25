<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(
            at: ['127.0.0.1', '::1'],
            headers: Request::HEADER_X_FORWARDED_PROTO,
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (PostTooLargeException $exception, Request $request): ?Response {
            if (! $request->is('career/*/apply')) {
                return null;
            }

            $requestSize = (int) $request->server('CONTENT_LENGTH');
            $actualSize = $requestSize > 0 ? number_format($requestSize / 1048576, 2).' MB request; ' : '';
            $message = 'The upload is too large ('.$actualSize.'server request limit '.ini_get('post_max_size').'). The resume limit is 5 MB.';

            if ($request->expectsJson()) {
                return response()->json(['message' => $message, 'errors' => ['resume' => [$message]]], 413);
            }

            return redirect()->back()->withErrors(['resume' => $message]);
        });

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();

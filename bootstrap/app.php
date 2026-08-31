<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EnsureMemberIsActive;
use App\Http\Middleware\MemberMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'member' => MemberMiddleware::class,
            'member.active' => EnsureMemberIsActive::class,
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            $path = $request->path();

            if (str_starts_with($path, 'member/') || $path === 'member') {
                return route('member.login');
            }

            return route('admin.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

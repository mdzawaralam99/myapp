<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
       $middleware->alias([
      //  'jwt.auth'   => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
        'jwt.custom' => \App\Http\Middleware\JwtMiddleware::class,
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Always return JSON for API routes
        /* $exceptions->shouldRenderJsonWhen(function ($request, $e) {
            return $request->is('api/*') || $request->expectsJson();
        }); */

        $exceptions->shouldRenderJsonWhen(fn($request, $e) =>
        $request->is('api/*') || $request->expectsJson()
    );

        // Custom render for validation errors
       /*  $exceptions->render(function (ValidationException $e, $request) {
            return response()->json([
                'success'   => false,
                'data'      => null,
                'message'   => 'Validation failed',
                'errors'    => $e->errors(),
                'timestamp' => now()->toISOString(),
            ], 422);
        }); */

            $exceptions->render(function (ValidationException $e, $request) {
        return response()->json([
            'success' => false,
            'data'    => null,
            'message' => 'Validation failed',
            'errors'  => $e->errors(),
            'timestamp' => now()->toISOString(),
        ], 422);
    });

    // Authorization (role/permission denied)
$exceptions->render(function (AuthorizationException $e, $request) {
    if ($request->is('api/*')) {
        return response()->json([
            'success'   => false,
            'data'      => null,
            'message'   => 'You do not have permission to access this resource',
            'timestamp' => now()->toISOString(),
        ], 403);
    }
});
    // Authentication (not logged in)
    $exceptions->render(function (AuthenticationException $e, $request) {
        return response()->json([
            'success'   => false,
            'data'      => null,
            'message'   => 'You must be logged in to access this resource.',
            'timestamp' => now()->toISOString(),
        ], 401);
    });

        // Custom render for model not found (404)
        /* $exceptions->render(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success'   => false,
                    'data'      => null,
                    'message'   => 'Resource not found',
                    'timestamp' => now()->toISOString(),
                ], 404);
            }
        }); */

        $exceptions->render(function (NotFoundHttpException $e, $request) {
        return response()->json([
            'success'   => false,
            'data'      => null,
            'message'   => 'Resource not found',
            'timestamp' => now()->toISOString(),
        ], 404);
    });

        // Fallback for any other exception
        /* $exceptions->render(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success'   => false,
                    'data'      => null,
                    'message'   => $e->getMessage() ?: 'Unexpected error occurred',
                    'timestamp' => now()->toISOString(),
                ], 500);
            }
        }); */

        $exceptions->render(function (Throwable $e, $request) {
        return response()->json([
            'success'   => false,
            'data'      => null,
            'message'   => $e->getMessage() ?: 'Unexpected error occurred',
            'timestamp' => now()->toISOString(),
        ], 500);
    });

    $exceptions->render(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
    return response()->json([
        'success' => false,
        'data' => null,
        'message' => 'You do not have the required permission to access this resource.',
        'timestamp' => now()->toISOString(),
    ], 403);
});

    })
    ->create();

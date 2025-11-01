<?php

// ...

return Illuminate\Foundation\Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Illuminate\Foundation\Configuration\Middleware $middleware) {
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
        ]);
    })

    ->withExceptions(function ($exceptions) {
        // opcional: si querés forzar JSON lindo para 401
        // use Illuminate\Auth\AuthenticationException;
        // $exceptions->render(function (AuthenticationException $e) {
        //     return response()->json([
        //         'success' => false,
        //         'code' => 'UNAUTHORIZED',
        //         'message' => 'Token inválido o ausente',
        //     ], 401);
        // });
    })
    ->create();

<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
            'admin.permission' => \App\Http\Middleware\CheckAdminPermission::class,
        ]);
        $middleware->redirectUsersTo(function (\Illuminate\Http\Request $request) {
            if ($request->is('admin*')) {
                return route('admin.dashboard');
            }
            return '/';
        });
        
        // Pengecualian CSRF untuk rute signout agar tidak terjadi 419 expired jika sesi idle terlalu lama
        $middleware->validateCsrfTokens(except: [
            '/signout',
            '/midtrans/webhook',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

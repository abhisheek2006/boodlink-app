<?php

/*
|--------------------------------------------------------------------------
| Middleware registration (Laravel 12 / bootstrap/app.php)
|--------------------------------------------------------------------------
| Merge the ->withMiddleware() block below into your existing
| bootstrap/app.php. Laravel 12 no longer uses app/Http/Kernel.php,
| so aliases are registered here instead.
*/

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DonationEligibilityMiddleware;
use App\Http\Middleware\DonorMiddleware;
use App\Http\Middleware\EnsureAccountIsActive;
use App\Http\Middleware\PatientMiddleware;
use App\Http\Middleware\SessionActiveMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'donor' => DonorMiddleware::class,
            'patient' => PatientMiddleware::class,
            'active' => EnsureAccountIsActive::class,
            'session.active' => SessionActiveMiddleware::class,
            'donation.eligibility' => DonationEligibilityMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

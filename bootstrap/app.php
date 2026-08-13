<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DonationEligibilityMiddleware;
use App\Http\Middleware\DonorMiddleware;
use App\Http\Middleware\EnsureAccountIsActive;
use App\Http\Middleware\PatientMiddleware;
use App\Http\Middleware\SessionActiveMiddleware;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        channels: __DIR__.'/../routes/channels.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'donor' => DonorMiddleware::class,
            'patient' => PatientMiddleware::class,
            'active' => EnsureAccountIsActive::class,
            'session.active' => SessionActiveMiddleware::class,
            'donation.eligibility' => DonationEligibilityMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
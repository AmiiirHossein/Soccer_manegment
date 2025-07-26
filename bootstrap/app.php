<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Console\Scheduling\Schedule;
return Application::configure(basePath: dirname(__DIR__))
    ->withSchedule(function (Schedule $schedule) {

        $schedule->call(function () {
            \Log::info('Schedule is running...'); // برای تست
            \Illuminate\Support\Facades\Log::info('Schedule is running...'); // برای تست
            app(\App\Services\MatchResultService::class)->processScheduledMatches();
        })->everyFiveSeconds();


    })
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            \Illuminate\Support\Facades\RateLimiter::for('api', function (\Illuminate\Http\Request $request) {
                return \Illuminate\Cache\RateLimiting\Limit::perMinute(60)
                    ->by($request->user()?->id ?: $request->ip());
            });
        })
->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // \App\Http\Middleware\AdminMiddleware::class // فقط اگر همه روت‌ها نیاز به ادمین دارند
        ]);
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
             'role' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class
        ]);
    })->withExceptions(function (Exceptions $exceptions) {
//        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
//            return response()->json(['message' => 'Resource not found.'], 404);
//        });
            $exceptions->renderable(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
                return response()->json(['message' => 'Resource not found.'], 404);
            });

            $exceptions->renderable(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, $request) {
                return response()->json(['message' => 'Access denied.'], 403);
            });

            $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            });

//            $exceptions->renderable(function (Throwable $e, $request) {
//                return response()->json(['message' => 'Server error.'], 500);
//            });


    })->create();



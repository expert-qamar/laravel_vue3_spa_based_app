<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Response;

class DefaultResponses extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Response::macro('success', function ($data = '') {
            if (! empty($data)) {
                return response()->json([
                    'success' => true,
                    'data' => $data,
                ]);
            } else {
                return response()->json([
                    'success' => true,
                ]);
            }
        });

        Response::macro('error', fn ($error, $status_code) => response()->json(['error' => $error], $status_code));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

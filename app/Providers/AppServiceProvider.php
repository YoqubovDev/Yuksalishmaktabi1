<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Global listener to decode HTML entities when retrieving records from DB
        \Illuminate\Support\Facades\Event::listen('eloquent.retrieved: *', function ($eventName, array $data) {
            foreach ($data as $model) {
                if ($model instanceof \Illuminate\Database\Eloquent\Model) {
                    foreach ($model->getAttributes() as $key => $value) {
                        if (is_string($value) && \str_contains($value, '&')) {
                            $decoded = $value;
                            do {
                                $prev = $decoded;
                                $decoded = \html_entity_decode($prev, ENT_QUOTES, 'UTF-8');
                            } while ($decoded !== $prev);
                            
                            $model->setAttribute($key, $decoded);
                        }
                    }
                }
            }
        });

        // Global listener to decode HTML entities when saving records to DB
        \Illuminate\Support\Facades\Event::listen('eloquent.saving: *', function ($eventName, array $data) {
            foreach ($data as $model) {
                if ($model instanceof \Illuminate\Database\Eloquent\Model) {
                    foreach ($model->getAttributes() as $key => $value) {
                        if (is_string($value) && \str_contains($value, '&')) {
                            $decoded = $value;
                            do {
                                $prev = $decoded;
                                $decoded = \html_entity_decode($prev, ENT_QUOTES, 'UTF-8');
                            } while ($decoded !== $prev);
                            
                            $model->setAttribute($key, $decoded);
                        }
                    }
                }
            }
        });
    }
}

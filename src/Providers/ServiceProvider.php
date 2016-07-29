<?php

namespace Zenapply\Upload\Providers;

use Illuminate\Support\ServiceProvider as Provider;
use Zenapply\Upload\Upload;

class ServiceProvider extends Provider
{
    public function register() {
        $this->mergeConfigFrom(__DIR__ . '/../../config/upload.php', 'upload');

        $this->app->singleton('upload', function() {
            return new Upload;
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/upload.php' => base_path('config/upload.php'),
        ]);   
    }
}
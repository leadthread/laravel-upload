<?php

namespace Zenapply\Upload\Providers;

use Illuminate\Support\ServiceProvider;
use Zenapply\Upload\Upload as UploadMaster;

class Upload extends ServiceProvider
{
    public function register() {
        $this->mergeConfigFrom(__DIR__ . '/../../config/upload.php', 'upload');

        $this->app->singleton('upload', function() {
            return new UploadMaster;
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/upload.php' => base_path('config/upload.php'),
        ]);   
    }
}
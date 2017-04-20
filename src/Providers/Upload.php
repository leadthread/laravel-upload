<?php

namespace LeadThread\Upload\Providers;

use Illuminate\Support\ServiceProvider;
use LeadThread\Upload\Upload as UploadMaster;

class Upload extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/upload.php', 'upload');

        $this->app->singleton(
            'upload',
            function () {
                return new UploadMaster;
            }
        );
    }

    public function boot()
    {
        $this->publishes(
            [
            __DIR__ . '/../../config/upload.php' => base_path('config/upload.php'),
            __DIR__ . '/../../migrations/2016_01_01_000000_create_uploads_tables.php' => base_path('database/migrations/2016_01_01_000000_create_uploads_tables.php'),
            ]
        );
    }
}

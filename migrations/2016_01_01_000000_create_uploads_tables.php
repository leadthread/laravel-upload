<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUploadsTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('upload.table'), function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('mime');
            $table->string('path');
            $table->string('disk');
            $table->string('filename');
            $table->string('extension');
            $table->string('fingerprint');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(config('upload.table'));
    }
}

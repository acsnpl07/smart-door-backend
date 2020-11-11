<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppApiKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_api_keys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('door_id');
            $table->string('key');

            $table->timestamps();

            $table->foreign('door_id')->references('id')->on('doors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_api_keys');
    }
}

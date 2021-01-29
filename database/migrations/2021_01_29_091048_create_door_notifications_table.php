<?php

use App\Models\Door;
use App\Models\DoorLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoorNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('door_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Door::class)->default(1);
            $table->foreignIdFor(DoorLog::class)->nullable();
            $table->string('title')->nullable();
            $table->string('body')->nullable();
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
        Schema::dropIfExists('door_notifications');
    }
}

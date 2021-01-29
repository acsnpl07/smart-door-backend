<?php

use App\Models\Door;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDoorIdToDoorLogsTable extends Migration
{
    public function up()
    {
        Schema::table('door_logs', function (Blueprint $table) {
            $table->foreignIdFor(Door::class)->default(1);
        });
    }

    public function down()
    {
        Schema::table('door_logs', function (Blueprint $table) {
            $table->dropColumn(['door_id']);
        });
    }
}

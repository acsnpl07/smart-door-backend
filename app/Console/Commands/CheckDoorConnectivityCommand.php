<?php

namespace App\Console\Commands;

use App\Models\Door;
use App\Models\DoorNotification;
use Illuminate\Console\Command;

class CheckDoorConnectivityCommand extends Command
{
    protected $signature = 'check:door';

    protected $description = 'command to check if the door send a packed within 5 minutes of not';

    public function handle()
    {
        // check both doors
        $unConnected_doors = Door::select(['id', 'updated_at'])->where('updated_at' ,'<', now()->subMinutes(5))->get();
        foreach ($unConnected_doors as $unConnected_door){
            DoorNotification::create([
                'door_id' => $unConnected_door->id,
                'title' => 'door is unconnected',
                'body' => 'door ' . $unConnected_door->id . ' was disconnected ' . $unConnected_door->updated_at->diffForhumans()
            ]);
        }
    }
}
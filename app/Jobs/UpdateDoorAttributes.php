<?php

namespace App\Jobs;

use App\Models\Door;
use App\Models\DoorIp;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateDoorAttributes implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected Door $door;
	protected  string $ip;

    /**
     * UpdateDoorAttributes constructor.
     * @param Door $door
     * @param string $ip
     */
    public function __construct(Door $door, string $ip)
    {
        $this->door = $door;
        $this->ip = $ip;
    }

    public function handle()
	{
		$this->door->updated_at = now();
		$this->door->save();
        $doorIp = DoorIp::firstOrNew(
            ['id' =>  1],
            ['ip' => $this->ip, 'port' => "8540"]
        );
        $doorIp->save();
	}
}

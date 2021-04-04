<?php
/*
 * @binu
 * */

namespace App\Http\Controllers;

use App\Jobs\UpdateDoorAttributes;
use App\Models\Door;
use App\Models\DoorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoorController extends Controller
{
    public function index()
    {
        return [
            'is_closed' => Door::first()->is_closed,
        ];
    }

    public function open()
    {
        $authed_user = Auth::user();
        $door = Door::first();
        if ($door->is_closed == 1) {
            $door->is_closed = 0;
            $door->save();

            DoorLog::create([
                'name' => $authed_user->name,
                'entered' => true,
                'is_camera' => 0,
            ]);

            return [
                'message' => "Door is now open",
            ];
        }

        return ['message' => 'Door already Open'];
    }

    public function close()
    {
        $door = Door::first();
        if ($door->is_closed != 1) {
            $door->is_closed = 1;
            $door->save();
            return ['message' => "Door is now closed"];
        }

        return ['message' => 'Door already closed'];
    }

    public function ping()
    {
        UpdateDoorAttributes::dispatchAfterResponse(request()->door,$this->getIp());
        return response()->json([
            'message' => 'pong',
            'is_closed' => request()->door->is_closed,
        ]);
    }
    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }
}

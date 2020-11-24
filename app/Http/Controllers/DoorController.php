<?php
/*
 * @binu
 * */
namespace App\Http\Controllers;

use App\Models\Door;
use App\Models\DoorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoorController extends Controller
{
    public function index()
    {
        return [
            'is_closed' => Door::first()->is_closed
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
                'is_camera' => 0
            ]);

            return [
                'message' => "Door is now open"
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
        $doorState = Door::first()->is_closed;
        return response()->json([
            'message' => 'pong',
            'is_closed' => $doorState
        ]);
    }
}

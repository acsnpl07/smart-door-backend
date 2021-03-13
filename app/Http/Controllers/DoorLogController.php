<?php

namespace App\Http\Controllers;

use App\Models\Door;
use App\Models\DoorLog;
use App\Models\DoorNotification;
use App\Models\User;


class DoorLogController extends Controller
{
    /*
     * Asis +  Ram
     *  */
    public function index()
    {
        DoorLog::where('created_at', '<', now()->subHours(72))->delete();
        return DoorLog::orderBy('created_at', 'desc')->paginate(15);
    }

    public function show(DoorLog $doorLog)
    {

        return response()->json($doorLog);
    }

    /*
     * @BINU + ram
     * */
    public function storeFromPi()
    {
        request()->validate(
            [
                'image_url' => 'required',
                'entered' => ['required', 'boolean'],
                'door_id' => ['in:1,2']
            ]
        );

        $user = User::where('image_url', request()->image_url)->first();

        $data = [
            'image_url' => request()->image_url,
            'name' => optional($user)->name,
            'entered' => request()->entered,
            'is_camera' => 1
        ];
        $doorLog = DoorLog::create($data);
        // unauthorised user tried to enter and was blocked, then we should notify the admin
        if (!request()->entered)
        {
            DoorNotification::create([
                'door_id' => request()->door_id,
                'door_log_id' => $doorLog->id,
                'title' => 'unauthorised login',
                'body' => $doorLog->image_url
            ]);
        }
        return response([
            'message' => 'log has been saved',
            'data' => $doorLog
        ]);
    }
}

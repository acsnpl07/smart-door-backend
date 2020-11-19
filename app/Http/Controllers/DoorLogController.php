<?php

namespace App\Http\Controllers;

use App\Models\Door;
use App\Models\DoorLog;
use App\Models\User;


class DoorLogController extends Controller
{
    /*
     * Asis +  Ram
     *  */
    public function index()
    {

//        DoorLog::where('created_at', '<', now()->subHours(72))->delete();
        if (\Auth::user()->is_admin) {
            return DoorLog::orderBy('created_at', 'desc')->paginate(15);
        } else {
            // delete every thing else
            return DoorLog::
                    where('created_at', '>=', now()->subHours(72))->
                    orderBy('created_at', 'desc')->paginate();
        }
    }

    /*
     * @BINU + ram
     * */
    public function storeFromPi()
    {
        request()->validate(
            [
                'message' => 'log stored',
                'image_url' => 'required',
                'entered' => ['required', 'boolean'],

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

        return response([
            'message' => 'log has been saved',
            'data' => $doorLog
        ]);
    }
}

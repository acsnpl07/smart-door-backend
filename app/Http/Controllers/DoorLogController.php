<?php

namespace App\Http\Controllers;

use App\Models\DoorLog;
use App\Models\User;

class DoorLogController extends Controller
{

    public function index()
    {
        return DoorLog::all();
    }

    public function storeFromPi()
    {
        request()->validate(
            [
                'picture_url' => 'required',
                'entered' => ['required', 'boolean'],

            ]
        );

        $user = User::where('picture_url', request()->picture_url)->first();
        $data  = [
            'picture_url' => request()->picture_url,
            'name' => optional($user)->name,
            'entered'=> request()->entered,
            'is_camera'=> 1
        ];
        $doorLog = DoorLog::create($data);

        return response([
            'message' => 'log has been saved'
        ]);
    }
}

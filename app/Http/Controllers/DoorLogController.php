<?php

namespace App\Http\Controllers;

use App\Models\DoorLog;
use App\Models\User;

class DoorLogController extends Controller
{

    public function index()
    {
        return DoorLog::paginate(15);
    }

    public function storeFromPi()
    {
        request()->validate(
            [
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

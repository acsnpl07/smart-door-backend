<?php

namespace App\Http\Controllers;

use App\Models\DoorIp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoorIpController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $ip  = DoorIp::first();
        if (!$ip)
        {
            return response()->json(['message' => 'no camera found.. please check the door'] , 404);
        }
        return response()->json($ip);
    }
}

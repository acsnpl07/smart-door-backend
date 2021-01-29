<?php

namespace App\Http\Controllers;

use App\Models\DoorNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoorNotificationController extends Controller
{

    public function index()
    {
        abort_if(!Auth::user()->is_admin, 401, 'only admin can see  the notifications');

        return response()->json([
            'data' => DoorNotification::query()->paginate(15)
        ]);
    }



    public function show(DoorNotification $doorNotification)
    {
        abort_if(!Auth::user()->is_admin, 401, 'only admin can see  the notifications');
        return response()->json($doorNotification);
    }




    public function destroy(DoorNotification $doorNotification)
    {
        abort_if(!Auth::user()->is_admin, 401, 'only admin can see  the notifications');
        $doorNotification->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}

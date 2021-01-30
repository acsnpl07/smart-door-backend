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
            'data' =>
                DoorNotification::query()
                    ->when(!app()->environment('local'), fn($q) => $q->where('door_id', 1))
                    ->orderByDesc('created_at')
                    ->paginate(15)
        ]);
    }

    public function count()
    {
        abort_if(!Auth::user()->is_admin, 401, 'only admin can see  the notifications');

        return response()->json([
            'notification_count' => DoorNotification::
            when(!app()->environment('local'), fn($q) => $q->where('door_id', 1))
                ->count()
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

<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function index()
    {
        $this->validateAdmin();

        $users =  User::all();

        return $users;
    }

    public function login()
    {
        $user = User::where('email', request()->email)->first();

        if (!$user || !Hash::check(request()->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function store()
    {
        $this->validateAdmin();

        request()->validate([
            'name' => ['required', 'min:3', 'max:100'],
            'email' => ['required', 'email'],
            'password'         => ['required', 'string', 'min:8'],
            'password_confirm' => ['required', 'same:password'],
            'is_admin' => ['required', 'boolean']
        ]);


        $user = User::where('email', request()->email)->first();
        if ($user) {
            return response([
                'message' => ['user already exist.']
            ], 401);
        }
        $user = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password),
            'is_admin' => request()->id_admin,
        ]);
        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function showMe()
    {
        return request()->user();
    }


    public function update(Request $request, User $user)
    {
        //
    }


    public function destroy(User $user)
    {
        $this->validateAdmin();

        $user->delete();
    }

    protected function validateAdmin()
    {
        $authed_user = Auth::user();


        if ($authed_user['is_admin'] != 1) {
            abort(401, 'unauthorized');
        }
    }
}

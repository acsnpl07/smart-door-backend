<?php

// Asis
namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index()
    {
        $this->validateAdmin();

        $users = User::paginate(15);

        return $users;
    }

    public function login()
    {
        $user = User::where('email', request()->email)->first();

        if (!$user || !Hash::check(request()->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.'],
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function store()
    {
        $this->validateAdmin();

        request()->validate([
            'name' => ['required', 'min:3', 'max:100'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirm' => ['required', 'same:password'],
            'is_admin' => ['required', 'boolean'],
        ]);

        $user = User::where('email', request()->email)->first();
        if ($user) {
            return response([
                'message' => ['user already exist.'],
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
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function showMe()
    {
        return Auth::user();
    }

    public function show(User $user)
    {
        $this->validateAdmin();
        return $user;
    }

    public function updateMe(User $user)
    {
        return $this->updateUser($user);
    }

    public function update(User $user)
    {
        $this->validateAdmin();
        $this->updateUser($user);
    }

    public function destroy(User $user)
    {
        $this->validateAdmin();

        $user->delete();
        return response()->json([
            'message' => 'deleted',
        ]);
    }

    protected function validateAdmin()
    {
        $authed_user = Auth::user();

        if ($authed_user['is_admin'] != 1) {
            abort(401, 'unauthorized');
        }
    }

    protected function updateUser()
    {
        $user = Auth::user();
        request()->validate([
            'name' => ['min:3', 'required'],
            'email' => ['email', 'required'],
            'image_url' => ['url'],
            'new_password' => ['min:6', 'required'],
        ]);
        $name = request()->name;
        $email = request()->email;
        $image_url = request()->image_url;
        $new_password = request()->new_password;

        if ($name) {
            $user->name = $name;
        }

        if ($email && $email != $user->email) {
            abort_if(User::where('email', $email)->first(), 400, 'Email already found');
            $user->email = $email;
        }

        if ($image_url) {
            if ($user->image_url) {
                $urlSlpit = explode('/', $user->image_url);
                ray($urlSlpit);
                $path = $urlSlpit[3] . '/' . $urlSlpit[4];
                Storage::disk('s3')->delete($path);
            }
            $user->image_url = $image_url;
        }

        if ($new_password) {
            $user->password = Hash::make($new_password);
        }
        $user->save();

        return [
            'message' => 'user update successfully',
            'data' => $user,
        ];
    }
}

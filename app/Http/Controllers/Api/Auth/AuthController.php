<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Exceptions\AuthenticationException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->group = User::MEMBER;
        $user->password = bcrypt($request->password);
        $user->save();

        return response([
            'status' => 200,
            'data' => $user
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (!$token = auth()->attempt($credentials)) {
            throw new ValidationException([
                'username' => 'Неверный логин или пароль',
                'password' => 'Неверный логин или пароль'
            ]);
        }

        return response([
            'status' => 200,
            'data' => ['token' => $token]
        ])->header('Authorization', $token);
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response([
            'status' => 200,
            'data' => $user
        ]);
    }

    public function refresh()
    {
        return response([
            'status' => 200,
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json([
            'status' => 200,
            'data' => 'Logged out Successfully.'
        ], 200);
    }
}

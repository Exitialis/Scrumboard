<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller
{
    public function lists(Request $req)
    {
        if ($req->has('executors')) {
            $users = User::executors()->get();

            return response()->json([
                'status' => 200,
                'data' => $users
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => User::get()
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'balance' => 'required'
        ]);

        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'balance' => $request->get('balance'),
        ]);
    }

    public function login(Request $request) {


        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        if (!auth()->attempt($request->all())) {
            return response(['error_messages' => 'Incorrect credentials, try again']);
        }
        $user = auth()->user();

        $token = $user->createToken('Api Token')->accessToken;
        return response(['user' => auth()->user(),'token' => $token]);
    }
}

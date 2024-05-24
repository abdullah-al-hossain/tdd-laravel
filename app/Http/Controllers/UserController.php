<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::create($request->all());

        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]); 

        return response(['message' => 'authenticated']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->all());

        return response($user, Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {

        $user = User::whereEmail($request->email)->first();

        if($user && Hash::check($request->password, $user->password)) {
            
            $token = $user->createToken('token');

            return response([
                'token' => $token->plainTextToken,
            ]);

        }

        return response(['errors' => [
            'email' => 'The provided credentials are incorrect.'
        ]]);
    }
}

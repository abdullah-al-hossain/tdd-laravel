<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $user = User::create($request->all());

        return response($user, Response::HTTP_CREATED);
    }
}

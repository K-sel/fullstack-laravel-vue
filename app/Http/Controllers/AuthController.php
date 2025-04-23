<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthCreateUserValidation;
use App\Models\User;

class AuthController extends Controller
{
    public function findEmail($email)
    {
        User::findOrFail($email);
    }

    public function createAccount(AuthCreateUserValidation $request)
    {
        $user = User::create($request->validated());
        return response()->json($user, 201);
    }

    public function showRegister()
    {
        return view('auth.register');
    }
    public function showLogin()
    {
        return view('auth.login');
    }
}
    
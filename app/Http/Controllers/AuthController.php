<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthCreateUserValidation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

    public function register()
    {
        return view('index');
    }
}

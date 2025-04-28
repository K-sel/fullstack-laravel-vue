<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class PasswordController extends Controller
{
    /**
     * Show the form for editing the user's password.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('auth.edit-password');
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail(__('Le mot de passe actuel est incorrect.'));
                }
            }],
            'password' => ['required', 'string', Password::defaults(), 'confirmed', 'different:current_password'],
        ], [
            'password.different' => "Le nouveau mot de passe doit être différent de l'ancien."
        ]);

        $user = User::find(Auth::user()->id);
        $user->passorwd = Hash::make($request->password);

        return back()->with('status', 'Mot de passe modifié avec succès!');
    }
}

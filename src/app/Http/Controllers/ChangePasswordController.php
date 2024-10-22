<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('auth.password.change-password');
    }

    public function changePassword(ChangePasswordRequest $request) 
    {
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->is_password_changed = true;
        $user->save();

        return redirect()->route('login')->with('success', 'Password changed successfully.');
    }
}

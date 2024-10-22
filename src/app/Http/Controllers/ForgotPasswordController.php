<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.password.index');
    }

    public function store(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages(['error' => __('Email not found.')]);
        }

        $token = app('auth.password.broker')->createToken($user);
        $link = route('auth.password.resetForm', ['token' => $token, 'email' => $request->email]);
        Mail::to($request->email)->send(new PasswordReset($link));

        return back()->with(['success' => __('Password reset link sent.')]);
    }

    public function resetForm(Request $request, $token = null)
    {
        return view('auth.password.reset-password')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages(['error' => __('Email not found.')]);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();
                Auth::login($user);
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', __('Password changed successfully.'));
        }

        // Thêm thông báo cho trường hợp token hết hạn hoặc đã sử dụng
        if ($status === Password::INVALID_TOKEN || $status === Password::INVALID_USER) {
            return back()->withInput($request->only('email'))->withErrors(['error' => __('The link is expired or has been used.')]);
        }

        return back()->withInput($request->only('email'))->withErrors(['error' => __($status)]);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        if (!empty(Auth::check())) {
            if (Auth::user()->user_type == 1) {
                return redirect('admin/dashboard');
            } else if (Auth::user()->user_type == 2) {
                return redirect('teacher/dashboard');
            } else if (Auth::user()->user_type == 3) {
                return redirect('student/dashboard');
            } else if (Auth::user()->user_type == 4) {
                return redirect('parent/dashboard');
            }
        }
        return view("auth.login");
    }

    public function authLogin(Request $request)
    {
        $remember = !empty($request->remember);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            if (Auth::user()->user_type == 1) {
                return redirect('admin/dashboard');
            } else if (Auth::user()->user_type == 2) {
                return redirect('teacher/dashboard');
            } else if (Auth::user()->user_type == 3) {
                return redirect('student/dashboard');
            } else if (Auth::user()->user_type == 4) {
                return redirect('parent/dashboard');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid Email or Password.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url(''));
    }

    public function forgotPassword()
    {
        return view("auth.forgot");
    }

    public function postForgotPassword(Request $request)
    {
        $user = User::getEmailSingle($request->email);
        if (!empty($user)) {
            $user->remember_token = Str::random(30);
            $user->save();
            Mail::to($user->email)->send(new ForgotPasswordMail($user));
            return redirect()->back()->with('success', 'Please check your email to reset password.');
        } else {
            return redirect()->back()->with('error', 'Invalid Email.');
        }
    }

    public function reset(string $rememberToken)
    {
        $user = User::getRememberTokenSingle($rememberToken);
        if (!empty($user)) {
            return view("auth.reset", ['user' => $user]);
        } else {
            abort(404);
        }
    }

    public function resetPassword(Request $request, string $rememberToken)
    {
        if ($request->password == $request->confirm_password) {
            $user = User::getRememberTokenSingle($rememberToken);
            if (!empty($user)) {
                $user->password = Hash::make($request->password);
                $user->remember_token = Str::random(30);
                $user->save();
                return redirect(url(''))->with('success', 'Password has been changed.');
            } else {
                return redirect()->back()->with('error', 'User not found.');
            }
        } else {
            return redirect()->back()->with('error', 'Passwords does not match.');
        }
        
    }
}

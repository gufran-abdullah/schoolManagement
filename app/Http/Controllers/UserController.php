<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

class UserController extends Controller
{
    public function change_password()
    {
        $data['header_title'] = 'Change Password';
        return view('profile.change_password', $data);
    }

    public function update_change_password(Request $request)
    {
        try {
            $user = User::getSignleUserById(Auth::user()->id);
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return redirect()->back()->with('success', "Password saved successfully.");
            } else {
                throw new Exception('Invalid password provided for update password request.'); 
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

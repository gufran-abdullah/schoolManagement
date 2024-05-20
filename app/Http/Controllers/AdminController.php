<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Admin List';
        $data['admin_list'] = User::getAdmins();
        return view('admin.admin.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Add Admin';
        return view('admin.admin.add', $data);
    }

    public function insert(Request $request)
    {
        try {
            request()->validate([
                'email' => 'required|email|unique:users',
            ]);
            $data = $request->all();
            $user = new User();
            $user->name = trim($data['name']);            
            $user->email = trim($data['email']);
            $user->password = Hash::make($data['password']);
            $user->user_type = 1;
            $user->save();
            return redirect('admin/admin/list')->with('success', 'Admin added successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(int $id)
    {
        $data['header_title'] = 'Update Admin';
        try {
            $user = User::getSignleUserById($id);
            if (!empty($user)) {
                $data['user'] = $user;
                return view('admin.admin.edit', $data);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            request()->validate([
                'email' => 'required|email|unique:users,email,'.$id,
            ]);
            $data = $request->all();
            $user = User::getSignleUserById($id);
            if (!empty($user)) {
                $user->name = trim($data['name']);
                $user->email = trim($data['email']);
                if (!empty($data['password'])) {
                    $user->password = Hash::make($data['password']);
                }
                $user->save();
                return redirect('admin/admin/list')->with('success', 'Admin updated successfully');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $user = User::getSignleUserById($id);
            if (!empty($user)) {
                $user->is_deleted = 1;
                $user->save();
                return redirect('admin/admin/list')->with('success', 'Admin deleted successfully');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

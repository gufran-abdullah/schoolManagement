<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StudentController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Student List';
        $data['student_list'] = User::getStudents();
        return view('admin.student.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Add Student';
        return view('admin.student.add', $data);
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
            return redirect('admin/student/list')->with('success', 'Student added successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

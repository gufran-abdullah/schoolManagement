<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Class List';
        $data['class_list'] = ClassModel::getClasses();
        return view('admin.class.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Add Class';
        return view('admin.class.add', $data);
    }

    public function insert(Request $request)
    {
        try {
            $data = $request->all();
            $class = new ClassModel();
            $class->name = trim($data['name']);            
            $class->is_active = $data['status'];
            $class->created_by = Auth::user()->id;
            $class->save();
            return redirect('admin/class/list')->with('success', 'Class added successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(int $id)
    {
        $data['header_title'] = 'Update Class';
        try {
            $class = ClassModel::getSignleClassById($id);
            if (!empty($class)) {
                $data['class'] = $class;
                return view('admin.class.edit', $data);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $data = $request->all();
            $class = ClassModel::getSignleClassById($id);
            if (!empty($class)) {
                $class->name = trim($data['name']);
                $class->is_active = $data['status'];
                $class->save();
                return redirect('admin/class/list')->with('success', 'Class updated successfully');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $class = ClassModel::getSignleClassById($id);
            if (!empty($class)) {
                $class->is_deleted = 1;
                $class->save();
                return redirect('admin/class/list')->with('success', 'Class deleted successfully');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

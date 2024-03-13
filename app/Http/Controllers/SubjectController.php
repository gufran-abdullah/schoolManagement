<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Exception;

class SubjectController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Subject List';
        $data['subject_list'] = Subject::getSubjects();
        return view('admin.subject.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Add Subject';
        return view('admin.subject.add', $data);
    }

    public function insert(Request $request)
    {
        try {
            $data = $request->all();
            $subject = new Subject();
            $subject->name = trim($data['name']);            
            $subject->type = $data['type'];
            $subject->is_active = $data['status'];
            $subject->created_by = Auth::user()->id;
            $subject->save();
            return redirect('admin/subject/list')->with('success', 'Subject added successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(int $id)
    {
        $data['header_title'] = 'Update Subject';
        try {
            $subject = Subject::getSignleSubjectById($id);
            if (!empty($subject)) {
                $data['subject'] = $subject;
                return view('admin.subject.edit', $data);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $data = $request->all();
            $subject = Subject::getSignleSubjectById($id);
            if (!empty($subject)) {
                $subject->name = trim($data['name']);
                $subject->type = $data['type'];
                $subject->is_active = $data['status'];
                $subject->save();
                return redirect('admin/subject/list')->with('success', 'Subject updated successfully');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $subject = Subject::getSignleSubjectById($id);
            if (!empty($subject)) {
                $subject->is_deleted = 1;
                $subject->save();
                return redirect('admin/subject/list')->with('success', 'Subject deleted successfully');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

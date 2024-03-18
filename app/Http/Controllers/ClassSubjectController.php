<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSubject;
use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Exception;

class ClassSubjectController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Assign Subject List';
        $data['assign_subject_list'] = ClassSubject::getClassSubjects();
        return view('admin.assign_subject.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Assign Subject';
        $data['class_data'] = ClassModel::getActiveClasses();
        $data['subject_data'] = Subject::getActiveSubjects();
        return view('admin.assign_subject.add', $data);
    }

    public function insert(Request $request)
    {
        try {
            $data = $request->all();
            if (!empty($data['subject_id'])) {
                foreach ($data['subject_id'] as $subjectId) {
                    $assignSubject = new ClassSubject();
                    $alreadyAssigned = $assignSubject->getAlreadyAssignedSubjects($data['class_id'], $subjectId);
                    if (!empty($alreadyAssigned)) {
                        $alreadyAssigned->is_active = $data['status'];
                        $alreadyAssigned->save();
                    } else {
                        $assignSubject->class_id = $data['class_id'];
                        $assignSubject->subject_id = $subjectId;
                        $assignSubject->is_active = $data['status'];
                        $assignSubject->created_by = Auth::user()->id;
                        $assignSubject->save();
                    }
                }
            }
            return redirect('admin/assign-subject/list')->with('success', 'Subjects Assigned successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(int $id)
    {
        $data['header_title'] = 'Update Assigned Subject';
        try {
            $subject = ClassSubject::getSignleAssignedSubjectById($id);
            if (!empty($subject)) {
                $data['subject'] = $subject;
                $data['assigned_subjects'] = ClassSubject::getAssignedSubjectsByClassId($subject->class_id);
                $data['class_data'] = ClassModel::getActiveClasses();
                $data['subject_data'] = Subject::getActiveSubjects();
                return view('admin.assign_subject.edit', $data);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->all();
            ClassSubject::deleteSubjectsByClassId($data['class_id']);
            if (!empty($data['subject_id'])) {
                foreach ($data['subject_id'] as $subjectId) {
                    $assignSubject = new ClassSubject();
                    $alreadyAssigned = $assignSubject->getAlreadyAssignedSubjects($data['class_id'], $subjectId);
                    if (!empty($alreadyAssigned)) {
                        $alreadyAssigned->is_active = $data['status'];
                        $alreadyAssigned->save();
                    } else {
                        $assignSubject->class_id = $data['class_id'];
                        $assignSubject->subject_id = $subjectId;
                        $assignSubject->is_active = $data['status'];
                        $assignSubject->created_by = Auth::user()->id;
                        $assignSubject->save();
                    }
                }
            }
            return redirect('admin/assign-subject/list')->with('success', 'Subjects updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit_single(int $id)
    {
        $data['header_title'] = 'Update Assigned Subject';
        try {
            $subject = ClassSubject::getSignleAssignedSubjectById($id);
            if (!empty($subject)) {
                $data['subject'] = $subject;
                $data['class_data'] = ClassModel::getActiveClasses();
                $data['subject_data'] = Subject::getActiveSubjects();
                return view('admin.assign_subject.edit_single', $data);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update_single(int $id, Request $request)
    {
        try {
            $data = $request->all();
            $alreadyAssigned = ClassSubject::getAlreadyAssignedSubjects($data['class_id'], $data['subject_id']);
            $operation = $message = "";
            if (!empty($alreadyAssigned)) {
                $alreadyAssigned->is_active = $data['status'];
                $alreadyAssigned->save();
                $operation = 'success';
                $message = 'Status updated successfully!';
            } else {
                $assignSubject = ClassSubject::getSignleAssignedSubjectById($id);
                $assignSubject->class_id = $data['class_id'];
                $assignSubject->subject_id = $data['subject_id'];
                $assignSubject->is_active = $data['status'];
                $assignSubject->created_by = Auth::user()->id;
                $assignSubject->save();
                $operation = 'success';
                $message = 'Subject assigned to class successfully!';
            }
              
            return redirect('admin/assign-subject/list')->with($operation, $message);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $subject = ClassSubject::getSignleAssignedSubjectById($id);
            if (!empty($subject)) {
                $subject->is_deleted = 1;
                $subject->save();
                return redirect('admin/assign-subject/list')->with('success', 'Assigned subject deleted successfully');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

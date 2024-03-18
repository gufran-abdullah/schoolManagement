<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    use HasFactory;
    protected $table = 'class_subjects';

    static public function getClassSubjects()
    {
        return self::select(['class_subjects.*', 'c.name as class_name', 's.name as subject_name', 's.type as subject_type', 'u.name as user_name'])
                ->join('classes AS c', 'class_subjects.class_id', '=', 'c.id')
                ->join('subjects AS s', 'class_subjects.subject_id', '=', 's.id')
                ->join('users AS u', 'class_subjects.created_by', '=', 'u.id')
                ->where('class_subjects.is_deleted', 0)
                ->orderBy('class_subjects.id', 'desc')
                ->get();
    }

    static public function getAlreadyAssignedSubjects(int $classId, int $subjectId)
    {
        return self::where('class_id', $classId)->where('subject_id', $subjectId)->first();
    }

    static public function getSignleAssignedSubjectById(int $id)
    {
        return self::select(['*'])->where('id', $id)->where('is_deleted', 0)->first();
    }

    static public function getAssignedSubjectsByClassId(int $classId)
    {
        return self::where('class_id', $classId)->where('is_deleted', 0)->get();
    }

    static public function deleteSubjectsByClassId(int $classId)
    {
        return self::where('class_id', $classId)->delete();
    }
}

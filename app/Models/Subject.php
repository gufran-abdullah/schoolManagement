<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subjects';

    static public function getSubjects()
    {
        return self::select(['subjects.*', 'u.name as created_by_name'])
            ->join('users AS u', 'u.id', '=', 'subjects.created_by')
            ->where('subjects.is_deleted', 0)
            ->orderBy('subjects.id','desc')
            ->get();
    }

    static public function getSignleSubjectById(int $id)
    {
        return self::select(['*'])->where('id', $id)->where('is_deleted', 0)->first();
    }

    static public function getActiveSubjects()
    {
        return self::select(['subjects.*', 'u.name as created_by_name'])
            ->join('users AS u', 'u.id', '=', 'subjects.created_by')
            ->where('subjects.is_deleted', 0)
            ->where('subjects.is_active', 1)
            ->orderBy('subjects.name','asc')
            ->get();
    }
}

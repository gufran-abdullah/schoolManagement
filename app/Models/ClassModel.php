<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    protected $table = 'classes';

    static public function getClasses()
    {
        return self::select(['classes.*', 'u.name as created_by_name'])
            ->join('users AS u', 'u.id', '=', 'classes.created_by')
            ->where('classes.is_deleted', 0)
            ->orderBy('classes.id','desc')
            ->get();
    }

    static public function getSignleClassById(int $id)
    {
        return self::select(['*'])->where('id', $id)->where('is_deleted', 0)->first();
    }

    static public function getActiveClasses()
    {
        return self::select(['classes.*', 'u.name as created_by_name'])
            ->join('users AS u', 'u.id', '=', 'classes.created_by')
            ->where('classes.is_deleted', 0)
            ->where('classes.is_active', 1)
            ->orderBy('classes.name','asc')
            ->get();
    }
}

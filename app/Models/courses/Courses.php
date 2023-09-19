<?php

namespace App\Models\courses;

use App\Models\courses\chapters\CourseChapters;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    public function chapters()
    {
        return $this->hasMany(CourseChapters::class, 'course_id', 'id');
    }

    public function teachers()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
}

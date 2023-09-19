<?php

namespace App\Models\courses\chapters;

use App\Models\courses\Courses;
use App\Models\courses\lessons\CourseLessons;
use Illuminate\Database\Eloquent\Model;

class CourseChapters extends Model
{
    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id', 'id');
    }

    public function lessons()
    {
        return $this->hasMany(CourseLessons::class, 'chapter_id', 'id');
    }
}

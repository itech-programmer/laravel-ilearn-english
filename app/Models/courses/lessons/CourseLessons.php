<?php

namespace App\Models\courses\lessons;

use App\Models\courses\chapters\CourseChapters;
use Illuminate\Database\Eloquent\Model;

class CourseLessons extends Model
{
    public function chapter()
    {
        return $this->belongsTo(CourseChapters::class, 'chapter_id', 'id');
    }
}

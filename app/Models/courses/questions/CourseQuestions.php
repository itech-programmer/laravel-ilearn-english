<?php

namespace App\Models\courses\questions;

use App\Models\courses\chapters\CourseChapters;
use App\Models\courses\lessons\CourseLessons;
use Illuminate\Database\Eloquent\Model;

class CourseQuestions extends Model
{
    public function lesson()
    {
        return $this->belongsTo(CourseLessons::class, 'lesson_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(QuestionAnswers::class, 'question_id', 'id');
    }
}

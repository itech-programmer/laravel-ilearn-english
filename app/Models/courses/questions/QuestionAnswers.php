<?php

namespace App\Models\courses\questions;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswers extends Model
{
    public function question()
    {
        return $this->belongsTo(CourseQuestions::class, 'question_id', 'id');
    }
}

<?php

namespace App\Models\courses\exercises;

use App\Models\courses\lessons\CourseLessons;
use Illuminate\Database\Eloquent\Model;

class CourseExercises extends Model
{
    public function condition()
    {
        return $this->belongsTo(ExerciseConditions::class, 'condition_id', 'id');
    }

    public function lesson()
    {
        return $this->belongsTo(CourseLessons::class, 'lesson_id', 'id');
    }
    
        public function answers()
    {
        return $this->belongsTo(ExerciseAnswers::class, 'exercise_id', 'id');
    }
}

<?php

namespace App\Models;

use App\Models\courses\chapters\CourseChapters;
use App\Models\courses\exercises\CourseExercises;
use App\Models\courses\lessons\CourseLessons;
use App\Models\courses\questions\CourseQuestions;
use Illuminate\Database\Eloquent\Model;

class UserExerciseAnswers extends Model
{
    protected $fillable = ['user_id', 'lesson_id', 'exercise_id', 'is_correct', 'given_answer', 'point', 'active_status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lesson()
    {
        return $this->belongsTo(CourseLessons::class, 'lesson_id', 'id');
    }

    public function exercise()
    {
        return $this->belongsTo(CourseExercises::class, 'exercise_id', 'id');
    }
}

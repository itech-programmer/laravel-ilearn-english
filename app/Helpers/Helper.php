<?php

use App\Models\UserExerciseAnswers;
use App\Models\UserQuestionAnswers;

if (!function_exists('calculate_question_ranking')) {
    function calculate_question_ranking($user_id)
    {
        $ranking = 0;
        $question_scores = UserQuestionAnswers::select(
            DB::raw('user_id, SUM(point) as score'))
            ->groupBy('user_id')
            ->orderBy('score', 'DESC')
            ->get();
        $items = [];
        if(isset($question_scores)) {
            foreach ($question_scores as $score) {
                $items[] = [
                    'user_id' => $score->user_id,
                    'score' => $score->score
                ];
            }
            $ranking = array_search($user_id, array_column($items, 'user_id'));
            if($ranking === false) {
                $ranking= 0;
            } else {
                $ranking = $ranking+1;
            }
        } else {
            $ranking = 0;
        }

        return $ranking;
    }
}

if (!function_exists('calculate_question_score')) {
    function calculate_question_score($user_id)
    {
        $score = 0;
        $question_scores = UserQuestionAnswers::select(
            DB::raw('SUM(point) as score'))
            ->where('user_id',$user_id)
            ->first();
        if(isset($question_scores)) {
            if ($question_scores->score > 0) {
                $score = $question_scores->score;
            } else {
                $score = 0;
            }
        } else {
            $score = 0;
        }
        return $score;
    }
}

if (!function_exists('calculate_exercise_ranking')) {
    function calculate_exercise_ranking($user_id)
    {
        $ranking = 0;
        $exercise_scores = UserExerciseAnswers::select(
            DB::raw('user_id, SUM(point) as score'))
            ->groupBy('user_id')
            ->orderBy('score', 'DESC')
            ->get();
        $items = [];
        if(isset($exercise_scores)) {
            foreach ($exercise_scores as $score) {
                $items[] = [
                    'user_id' => $score->user_id,
                    'score' => $score->score
                ];
            }
            $ranking = array_search($user_id, array_column($items, 'user_id'));
            if($ranking === false) {
                $ranking= 0;
            } else {
                $ranking = $ranking+1;
            }
        } else {
            $ranking = 0;
        }

        return $ranking;
    }
}

if (!function_exists('calculate_exercise_score')) {
    function calculate_exercise_score($user_id)
    {
        $score = 0;
        $exercise_scores = UserExerciseAnswers::select(
            DB::raw('SUM(point) as score'))
            ->where('user_id',$user_id)
            ->first();
        if(isset($exercise_scores)) {
            if ($exercise_scores->score > 0) {
                $score = $exercise_scores->score;
            } else {
                $score = 0;
            }
        } else {
            $score = 0;
        }
        return $score;
    }
}

function language()
{
    $lang = [];
    $path = base_path('resources/lang');
    foreach (glob($path . '/*.json') as $file) {
        $lang_name = basename($file, '.json');
        $lang[$lang_name] = $lang_name;
    }
    return empty($lang) ? false : $lang;
}
function lang_name($input=null){
    $output = [
        'en' => 'English',
        'oz' => 'Uzbek',
        'qr' => 'Karakalpak',
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

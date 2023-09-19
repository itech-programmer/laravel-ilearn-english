<?php

namespace App\Http\Controllers\api\courses\chapters\exercises;

use App\Http\Controllers\Controller;
use App\Models\courses\exercises\CourseExercises;
use App\Models\courses\lessons\CourseLessons;
use App\Models\courses\questions\CourseQuestions;
use App\Models\courses\questions\QuestionAnswers;
use App\Models\UserExerciseAnswers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExercisesController extends Controller
{
    public function index($id)
    {
        $lesson = CourseLessons::where('id', $id)->first();

        $user_available_point = 0;
        $user_available_point = calculate_exercise_score(Auth::user()->id);
        $limit = $lesson->exercise_limit;

        $available_exercises = '';
        $available_exercises = CourseExercises::where('course_exercises.lesson_id', $id)
            ->where('course_exercises.active_status', 1)
            ->whereNotIn('course_exercises.id', UserExerciseAnswers::select('exercise_id')->where(['user_id' => Auth::id()]))
            ->select('course_exercises.*')
            ->inRandomOrder()
            ->limit($limit)
            ->get();

        if (!empty($available_exercises)) {
            $total_exercise = 0;
            $total_point = 0;
            foreach ($available_exercises as $exercise) {

                $lists[] = [
                    'id' => $exercise->id,
                    'title' => $exercise->condition->title,
                    'content' => $exercise->content,
                    'point' => $exercise->point,
                    'time_limit' => $exercise->time_limit,
                    'answer' => $exercise->answer,
                ];

                $total_exercise++;
                $total_point = $total_point + $exercise->point;


            }

            if (!empty($lists)) {
                $data['success'] = true;
                $data['message'] = __('Available Exercises List');
                $data['lesson_name'] = $lesson->title;
                $data['user_available_point'] = $user_available_point;
                $data['total_exercise'] = $total_exercise;
                $data['total_point'] = $total_point;
                $data['exercise_list'] = $lists;
            } else {
                $data = [
                    'success' => false,
                    'message' => __('No exercise found.')
                ];
            }

        } else {
            $data = [
                'success' => false,
                'message' => __('No exercise found.')
            ];
        }

        return response()->json($data);
    }

    public function answer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'answer' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $data['message'] = $errors;

            return response()->json($data);
        }

        try {
            $right_answer = CourseExercises::where(['id' => $request->id])->first();
            $exercise = CourseExercises::where(['id' => $request->id])->first();
            $user_answer = UserExerciseAnswers::where(['exercise_id' => $request->id, 'user_id' => Auth::user()->id])->first();

            $input =[
                'user_id' => Auth::user()->id,
                'lesson_id' => $exercise->lesson->id,
                'exercise_id' => $exercise->id,
                'given_answer' => $exercise->answer,
            ];
            if ($exercise) {
                if ($exercise->answer == $request->answer) {
                    $input['is_correct'] = 1;
                    $input['point'] = $exercise->point;
                    $data = [
                        'success' => true,
                        'message' => __('Right Answer'),
                    ];
                } else {
                    $data = [
                        'success' => false,
                        'message' => __('Wrong Answer'),
                        'right_answer' => $right_answer->answer
                    ];
                }
            } else {
                $data = [
                    'success' => false,
                    'message' => __('Wrong Answer'),
                    'right_answer' => $right_answer->answer
                ];
            }
            if ($user_answer) {
                $user_answer->update($input);
            } else {
                $insert = UserExerciseAnswers::create($input);
            }

            $data['total_point'] = calculate_exercise_score( Auth::user()->id);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json($data);
    }
}

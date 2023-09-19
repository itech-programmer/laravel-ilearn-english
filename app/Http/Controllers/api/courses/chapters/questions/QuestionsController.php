<?php

namespace App\Http\Controllers\api\courses\chapters\questions;

use App\Http\Controllers\Controller;
use App\Models\courses\lessons\CourseLessons;
use App\Models\courses\questions\CourseQuestions;
use App\Models\courses\questions\QuestionAnswers;
use App\Models\UserQuestionAnswers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuestionsController extends Controller
{
    public function index($id)
    {
        $lesson = CourseLessons::where('id', $id)->first();

        $user_available_point = 0;
        $user_available_point = calculate_question_score(Auth::user()->id);
        $limit = $lesson->question_limit;

        $available_questions = '';
        $available_questions = CourseQuestions::with('answers')
            ->where(['course_questions.lesson_id' => $id, 'course_questions.active_status' => 1])
            ->whereNotIn('course_questions.id', UserQuestionAnswers::select('question_id')->where(['user_id' => Auth::id()]))
            ->select('course_questions.*')
            ->inRandomOrder()
            ->limit($limit)
            ->get();

        if (isset($available_questions)) {
            $total_question = 0;
            $total_point = 0;
            foreach ($available_questions as $question) {
                $item_image = [];
                if (isset($question->answers[0])) {
                    $item_image [] = [
                        'id' => isset($question->answers[0]) ? $question->answers[0]->id : '',
                        'answer' => isset($question->answers[0]) && (!empty($question->answers[0]->image)) ? asset($question->answers[0]->image) : $question->answers[0]->answer_title,
                        'answer_type' => isset($question->answers[0]) && (!empty($question->answers[0]->image)) ? 1 : 0
                    ];
                }

                if (isset($question->answers[1])) {
                    $item_image [] = [
                        'id' => isset($question->answers[1]) ? $question->answers[1]->id : '',
                        'answer' => isset($question->answers[1]) && (!empty($question->answers[1]->image)) ? asset($question->answers[1]->image) : $question->answers[1]->answer_title,
                        'answer_type' => isset($question->answers[1]) && (!empty($question->answers[1]->image)) ? 1 : 0
                    ];
                }

                if (isset($question->answers[2])) {
                    $item_image [] = [
                        'id' => isset($question->answers[2]) ? $question->answers[2]->id : '',
                        'answer' => isset($question->answers[2]) && (!empty($question->answers[2]->image)) ? asset($question->answers[2]->image) : $question->answers[2]->answer_title,
                        'answer_type' => isset($question->answers[2]) && (!empty($question->answers[2]->image)) ? 1 : 0
                    ];
                }
                if (isset($question->answers[3])) {
                    $item_image [] = [
                        'id' => isset($question->answers[3]) ? $question->answers[3]->id : '',
                        'answer' => isset($question->answers[3]) && (!empty($question->answers[3]->image)) ? asset($question->answers[3]->image) : $question->answers[3]->answer_title,
                        'answer_type' => isset($question->answers[3]) && (!empty($question->answers[3]->image)) ? 1 : 0
                    ];
                }

                $lists[] = [
                    'id' => $question->id,
                    'title' => $question->question_title,
                    'has_image' => !empty($question->image) ? 1 : 0,
                    'image' => !empty($question->image) ? asset($question->image) : "",
                    'point' => $question->point,
                    'time_limit' => $question->time_limit,
                    'active_status' => $question->active_status,
                    'answers' => $item_image,
                ];

                $total_question++;
                $total_point = $total_point + $question->point;

            }

            if (!empty($lists)) {
                $data['success'] = true;
                $data['message'] = __('Available Question List');
                $data['lesson_name'] = $lesson->title;
                $data['user_available_point'] = $user_available_point;
                $data['total_question'] = $total_question;
                $data['total_point'] = $total_point;
                $data['question_list'] = $lists;
            } else {
                $data = [
                    'success' => false,
                    'message' => __('No question found.')
                ];
            }

        } else {
            $data = [
                'success' => false,
                'message' => __('No question found.')
            ];
        }

        return response()->json($data);
    }

    public function answer(Request $request, $id)
    {
        $data = ['success' => false, 'data' => [], 'message' => __('Something Went wrong !')];
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
            $right_answer = [];
            $correct_answer = QuestionAnswers::where(['question_id'=> $id, 'true_answer' => 1])->first();
            if(!empty($correct_answer)) {
                $right_answer = [
                    'answer_id' => $correct_answer->id,
                ];
            }
            $question = CourseQuestions::where(['id' => $id])->first();
            $answer = QuestionAnswers::where(['id'=> $request->answer, 'question_id'=> $id])->first();
            $user_answer = UserQuestionAnswers::where(['question_id' => $id, 'user_id' => Auth::user()->id])->first();

            $input =[
                'user_id' => Auth::user()->id,
                'lesson_id' => $question->lesson->id,
                'question_id' => $question->id,
                'given_answer' => $answer->answer_title,
            ];
            if ($answer) {
                if ($answer->true_answer == 1) {
                    $input['is_correct'] = 1;
                    $input['point'] = $question->point;
                    $data = [
                        'success' => true,
                        'message' => __('Right Answer'),
                    ];
                } else {
                    $data = [
                        'success' => false,
                        'message' => __('Wrong Answer'),
                        'right_answer' => $right_answer
                    ];
                }
            } else {
                $data = [
                    'success' => false,
                    'message' => __('Wrong Answer'),
                    'right_answer' => $right_answer
                ];
            }
            if ($user_answer) {
                $user_answer->update($input);
            } else {
                $insert = UserQuestionAnswers::create($input);
            }

            $data['total_point'] = calculate_question_score( Auth::user()->id);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json($data);
    }

}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserExerciseAnswers;
use App\Models\UserQuestionAnswers;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index()
    {
        $question_scores = UserQuestionAnswers::join('course_questions', 'course_questions.id', '=', 'user_question_answers.question_id')
            ->select(DB::raw('SUM(course_questions.point) as total_score'),DB::raw('SUM(user_question_answers.point) as score'), DB::raw('DATE_FORMAT(user_question_answers.created_at,\'%Y-%m-%d\') AS "date"'))
            ->where('user_question_answers.user_id', Auth::user()->id)
            ->where('user_question_answers.created_at', '>=', DB::raw('DATE(NOW()) - INTERVAL 7 DAY'))
            ->groupBy(DB::raw('DATE_FORMAT(user_question_answers.created_at,\'%Y-%m-%d\')'))
            ->get();

        $items = [];

        if(isset($question_scores)) {
            foreach ($question_scores as $score) {
                $items[] = [
                    'date' => date('d M y', strtotime($score->date)),
                    'score' => $score->score,
                    'total_score' => $score->total_score,
                    'score_percentage' => ($score->score * 100 )/$score->total_score
                ];
            }
            if (isset(Auth::user()->id)) {
                $user = User::select(
                    'id',
                    'full_name',
                    'username',
                    'avatar'
                )->findOrFail(Auth::user()->id);
                $participated_questions = 0;
                $user_questions = UserQuestionAnswers::where('user_id', Auth::user()->id)->count();
                if ($user_questions) {
                    $participated_questions = $user_questions;
                }
                $profile = [
                    'user_id' => $user->id,
                    'full_name' => $user->full_name,
                    'username' => $user->username,
                    'avatar' => asset($user->avatar),
                    'total_point' => calculate_question_score($user->id),
                    'ranking' => calculate_question_ranking($user->id),
                    'participated_questions' => $participated_questions,
                    'daily_score' => $items,
                ];

                return response()->json([
                    'success' => true,
                    'message' => __('User Profile'),
                    'profile' => $profile,
                ], 200);

            }else{

                return response()->json([
                    'success' => false,
                    'message' => __('No data found')
                ], 200);

            }
        }else{
            return response()->json([
                'success' => false,
                'message' => __('No data found')
            ], 200);
        }
    }

    public function update(Request $request){
       
       
        $rules = [
            'full_name' => 'required',
            'username' => 'required',
        ];
        $messages = [
            'full_name.required' => __('Full Name field can not be empty'),
            'username.required' => __('Username field can not be empty'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = [];
            $error_validation = $validator->errors()->all();
            foreach ($error_validation as $error) {
                $errors[] = $error;
            }

            return response()->json([
                'message' => $errors
            ]);
        }

        // try {
            DB::beginTransaction();
            $user = User::find(Auth::user()->id);
            $user->full_name = $request->full_name;
            $user->username = $request->username;
            $user->save();
            $user->toArray();
            DB::commit();
     
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return response()->json([
        //         'success' => false,
        //         'message' => __('Something went wrong')
        //     ], 201);
        // }
               return response()->json([
                'success' => true,
                'message' => __('Profile Updated'),
            ], 200);
    }

    public function update_avatar(Request $request){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::beginTransaction();
        try {
            //create a game score
            $user = User::find(Auth::user()->id);

            $file = $request->avatar;
            $file_path = 'public/uploads/' . "users" . '/';
            if (!empty($user->avatar)){
                $image = Image::make($file)
                    ->insert($file)
                    ->resize(512, 512, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                $name = md5(time() . $file->getClientOriginalName()) . '.' . $file->extension();
                if (file_exists($user->avatar)) {
                    File::delete($user->avatar);
                }
                $image->save($file_path . $name);
                $image_save = $file_path . $name;
                $user->avatar = $image_save;
            }else{
                $image = Image::make($file)
                    ->insert($file)
                    ->resize(512, 512, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                $name = md5(time() . $file->getClientOriginalName()) . '.' . $file->extension();
                $image->save($file_path . $name);
                $image_save = $file_path . $name;
                $user->avatar = $image_save;
            }

            $user->save();
            $user->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => __('Something went wrong')
            ], 201);
        }

        return response()->json([
            'success' => true,
            'message' => __('Avatar Updated'),
        ], 200);
    }
    
    public function settings()
    {
        if(!empty(language())) {
            foreach (language() as $val) {
                $item[] = [
                    'key' => $val,
                    'value' => lang_name($val)
                ];
            }
            if(!empty($item)) {
                if (isset(Auth::user()->id)) {
                    $user = User::select('language')->findOrFail(Auth::user()->id);
                    return response()->json([
                        'success' => true,
                        'message' => __('User Settings'),
                        'languages' => $item,
                        'profile' => $user,
                    ], 200);
                }
            }else {
                return response()->json([
                    'success' => false,
                    'message' => __('No data found')
                ], 200);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => __('No data found')
            ], 200);
        }
    }

    public function save_settings(Request $request){

        $rules = [
            'language' => 'required',
        ];
        $messages = [
            'language.required' => 'Must be select a Language'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $response = ['success' => false, 'message' => $errors];

            return response()->json($response);
        }
        $user = User::where('id',Auth::user()->id)->first();
        if (isset($user)){
            if (isset($request->language)) {

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::beginTransaction();
            try {
                //create a game score
                $language = User::find(Auth::user()->id);
                $language->language = $request->language;
                $language->save();
                $language->toArray();

                DB::commit();
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                return response()->json([
                    'success' => true,
                    'message' => __('Language Saved'),
                ], 200);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => __('Something went wrong')
                ]);
             }
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => __('No data found')
            ], 200);
        }
    }

    public function fives_game(Request $request){
        $game_score = 0;
        if (isset(Auth::user()->id)){

            $user = User::select(
                'fives_game_score'
            )->findOrFail(Auth::user()->id);
            return response()->json([
                'success' => true,
                'message' => __('Game Score'),
                'fives_game' => $user,
            ], 200);

        }else{
            return response()->json([
                 'fives_game' => $game_score,
                'success' => false,
                'message' => __('No data found')
            ], 200);
        }

    }

    public function store_score(Request $request){

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::beginTransaction();
        try {
            $game_name = $request->get('name');
            //create a game score
                $game_score = User::find(Auth::user()->id);
                $game_score->$game_name = $request->get('score');
                $game_score->save();
                $game_score->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $user = User::select(
                $game_name
            )->findOrFail(Auth::user()->id);
            return response()->json([
                    'success' => true,
                    'message' => __('Score Saved'),
                ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => __('Something went wrong')
            ]);
        }
    }
}

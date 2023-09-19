<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        $messages = [
            'username.required' => __('Username field can not be empty'),
            'password.required' => __('Password field can not be empty'),
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

        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            $token_result = $user->createToken('ilearn')->accessToken;
            $total_point = 0;
            $total_point = calculate_question_score($user->id) + calculate_exercise_score($user->id);

            if ($user->active_status == 1) {
                return response()->json([
                    'success' => true,
                    'message' => __('Successfully Logged in'),
                    'access_type' => "Bearer",
                    'access_token' => $token_result,
                    'total_point' => $total_point,
                    'user' => $user,
                ], 200);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => __("Your Account has been Pending for admin approval. please contact support team to active again")
                ], 200);
            }
        }else{
                 return response()->json([
                    'success' => false,
                    'message' => __("Login or Password entered incorrectly")
                ], 200); 
        }
    }
}

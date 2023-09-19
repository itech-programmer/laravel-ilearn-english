<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Models\general_settings\GeneralSettings;
use App\Models\UserProfiles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'full_name' => 'required|max:255',
            'username' => 'required|max:255',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];
        $messages = [
            'full_name.required' => __('Full_name field can not be empty'),
            'username.required' => __('Username field can not be empty'),
            'password.required' => __('Password field can not be empty'),
            'password.min' => __('Password length must be minimum 8 characters.'),
            'password.strong_pass' => __('Password must be consist of one Uppercase, one Lowercase and one Number!'),
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

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::beginTransaction();
        $default_role = GeneralSettings::first()->default_role_id;
        try {

            //create user
            $user = new User();
            $user->full_name = $request->get('full_name');
            $user->slug = Str::slug($request->get('full_name'));
            $user->username = $request->get('username');
            $user->username = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->language = 'uz';
            $user->syncRoles($default_role);
            $user->save();
            $user->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $token_result = $user->createToken('ilearn')->accessToken;
            $total_point = 0;
            $total_point = calculate_question_score($user->id) + calculate_exercise_score($user->id);
            
            return response()->json([
                'success' => true,
                'message' => __('Successfully Logged in'),
                'access_type' => "Bearer",
                'access_token' => $token_result,
                'total_point' => $total_point,
                'user' => $user,
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => __('Something went wrong')
            ], 201);
        }
    }
}

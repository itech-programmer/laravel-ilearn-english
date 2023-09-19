<?php

namespace App\Http\Controllers\backend\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\users\password\PasswordUpdateRequest;
use App\Models\general_settings\GeneralSettings;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public function index()
    {
        try {
            activity('Users')
                ->causedBy(auth()->user())
                ->log('Web Users Viewed');

            $users = User::whereHas("roles", function($query){
                $query->where("slug", "!=", "super-admin" && "slug", "!=", "student" && "slug", "!=", "teacher"); })->get();
            $students = User::whereHas("roles", function($query){
                $query->where("slug", "student"); })->get();
            $teachers = User::whereHas("roles", function($query){
                $query->where("slug", "teacher"); })->get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.users.index',
                compact( 'users', 'students', 'teachers', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function show(User $user)
    {
        try {
            activity('Users')
                ->causedBy(auth()->user())
                ->log('Web User Profile Viewed');

            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.users.show',
                compact( 'user', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function profile(User $user)
    {
        try {
            activity('Users')
                ->causedBy(auth()->user())
                ->log('Web User Profile Viewed');

            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.users.profile',
                compact( 'user', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function password(Request $request, User $user){

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if ($validator->fails()){
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withErrors($validator);
        }

        try {
            $hashed_password = auth()->user()->password;

            if(\Hash::check($request->old_password , $hashed_password )) {
                if (!\Hash::check($request->new_password , $hashed_password)) {

                    DB::beginTransaction();
                    $user = User::find($user->id);
                    $user->password = Hash::make($request->new_password);
                    $user->save();
                    $user->toArray();

                    DB::commit();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                }else{
                    Toastr::info('Новый пароль не может быть старым паролем!', 'Инфо');
                    return redirect()->route('user.profile', $user);
                }

            }else{
                Toastr::info('Cтарый пароль не соответствует', 'Инфо');
                return redirect()->route('user.profile', $user);
            }
            activity('User')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web User Password Updated');

            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('user.profile', $user);

        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->route('user.profile', $user)->withInput();
        }
    }

    public function block(Request $request, User $user)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            activity('Users')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web User blocked');

            DB::beginTransaction();
            $user = User::find($user->id);
            if ($user->active_status == 0){
                $user->active_status = 1;
            }else{
                $user->active_status = 0;
            }
            $user->save();
            $user->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function user_online_status()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id))
                echo $user->name . " is online. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
            else
                echo $user->name . " is offline. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
        }
    }
}

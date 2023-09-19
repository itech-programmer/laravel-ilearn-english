<?php

namespace App\Http\Controllers\backend\auth;

use App\Http\Controllers\Controller;
use App\Models\general_settings\GeneralSettings;
use App\Providers\RouteServiceProvider;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        try {
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('auth.default.login', compact('general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function auth(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $field_type = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if(auth()->attempt(array($field_type  => $input['username'], 'password' => $input['password'])))
        {
            $user_status = auth()->user()->active_status;
            if($user_status == 1) {
                return redirect()->route('backend.index');
            }else{
                auth()->logout();
                Toastr::info('Вы временно заблокированы. пожалуйста, свяжитесь с администратором\',\'Вы Заблокированы!');
                return redirect()->back();
            }
        }else{
            Toastr::error('Имя Пользователя И Пароль Неверны!!!','Ошибка');
            return redirect()->back()->withInput();
        }

    }

    public function logout(){

        activity('User')
            ->causedBy(auth()->user())
            ->log('Web User Logout');

        auth()->logout();
        return redirect()->route('auth.index');
    }
}

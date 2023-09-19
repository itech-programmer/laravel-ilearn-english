<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\general_settings\GeneralSettings;
use Brian2694\Toastr\Facades\Toastr;

class DashboardController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        try {
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.index', compact('general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }
}

<?php

namespace App\Http\Controllers\api\courses;

use App\Http\Controllers\Controller;
use App\Models\courses\chapters\CourseChapters;
use App\Models\general_settings\GeneralSettings;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = CourseChapters::where('active_status', 1)->get();
        $item = [];
        if (isset($courses)) {
            foreach ($courses as $course) {
                $item[] = [
                    'id' => $course->id,
                    'title' => $course->title,
                ];
            }
            if (!empty($item)) {
                return response()->json([
                    'success' => true,
                    'message' => __('Course List'),
                    'course_list' => $item,
                ], 200);
            }else{
                return response()->json([
                    'success' =>  false,
                    'message' => __('No data found'),
                ], 200);
            }
        } else {
            return response()->json([
                'success' =>  false,
                'message' => __('No data found'),
            ], 200);
        }
    }
    
    public function privacy_policy()
    {
        $settings = GeneralSettings::where('active_status', 1)->first();
        
        if (isset($settings)) {
                return response()->json([
                    'success' => true,
                    'message' => __('App Privacy Policy'),
                    'course_list' => $settings->app_privacy_policy,
                ], 200);
        }
    }
}

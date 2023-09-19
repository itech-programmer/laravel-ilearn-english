<?php

namespace App\Http\Controllers\api\courses\chapters\lessons;

use App\Http\Controllers\Controller;
use App\Models\courses\lessons\CourseLessons;

class LessonsController extends Controller
{
    public function index($id)
    {
        $lesson = CourseLessons::find($id);
        $item = [];
        if (!empty($lesson)) {
            return response()->json([
                'success' => true,
                'message' => __('Lesson'),
                'id' => $lesson->id,
                'title' => $lesson->title,
                'image' => asset($lesson->image),
                'teacher' => $lesson->chapter->course->teachers->full_name,
                'content' => $lesson->content,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => __('No data found'),
        ], 200);
    }
}

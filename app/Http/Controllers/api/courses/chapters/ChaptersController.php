<?php

namespace App\Http\Controllers\api\courses\chapters;

use App\Http\Controllers\Controller;
use App\Models\courses\chapters\CourseChapters;
use App\Models\courses\lessons\CourseLessons;
use Illuminate\Support\Facades\Auth;

class ChaptersController extends Controller
{
    public function vocabulary_index()
    {
        $chapters = CourseChapters::where('active_status', 1)->where('course_id', 1)->get();
        $item = [];
        if (isset($chapters)) {
            foreach ($chapters as $chapter) {
                $item[] = [
                    'id' => $chapter->id,
                    'title' => $chapter->title,
                    'image' =>  asset($chapter->image),
                ];
            }
            $user = Auth::user();
            $total_point = 0;
            $total_point = calculate_question_score($user->id);
            if (!empty($item)) {
                return response()->json([
                    'success' => true,
                    'message' => __('Chapter List'),
                    'total_point' => $total_point,
                    'vocabulary_chapter_list' => $item,
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

    public function grammar_index()
    {
        $chapters = CourseChapters::where('active_status', 1)->where('course_id', 2)->get();
        $item = [];
        if (isset($chapters)) {
            foreach ($chapters as $chapter) {
                $item[] = [
                    'id' => $chapter->id,
                    'title' => $chapter->title,
                    'image' =>  asset($chapter->image),
                ];
            }
            $user = Auth::user();
            $total_point = 0;
            $total_point = calculate_question_score($user->id);
            if (!empty($item)) {
                return response()->json([
                    'success' => true,
                    'message' => __('Chapter List'),
                    'total_point' => $total_point,
                    'grammar_chapter_list' => $item,
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

    public function show($id)
    {
        $lessons = CourseLessons::where('active_status', 1)->where('chapter_id', $id)->get();
        $item = [];
        if (!empty($lessons)) {
            foreach ($lessons as $lesson) {
                $item[] = [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'chapter_title' => $lesson->chapter->title,
                ];
            }
            if (!empty($item)) {
                return response()->json([
                    'success' => true,
                    'message' => __('Lessons List'),
                    'lessons_list' => $item,
                ], 200);
            }
        }
        return response()->json([
            'success' => false,
            'message' => __('No data found'),
        ], 200);
    }
}

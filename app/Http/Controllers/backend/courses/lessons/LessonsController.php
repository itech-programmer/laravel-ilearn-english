<?php

namespace App\Http\Controllers\backend\courses\lessons;

use App\Http\Controllers\Controller;
use App\Http\Requests\courses\lessons\LessonStoreRequest;
use App\Http\Requests\courses\LessonUpdateRequest;
use App\Models\courses\chapters\CourseChapters;
use App\Models\courses\lessons\CourseLessons;
use App\Models\general_settings\GeneralSettings;
use App\Services\FileUploadService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LessonsController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        try {
            activity('Lessons')
                ->causedBy(auth()->user())
                ->log('Web Lesson Viewed');

            $lessons = CourseLessons::get();
            $chapters = CourseChapters::get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.lessons.index', compact('lessons', 'chapters',  'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();

        }
    }

    public function show(CourseLessons $lesson)
    {
        try {
            activity('Lessons')
                ->causedBy(auth()->user())
                ->log('Web Lesson Info Viewed');

            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.lessons.show', compact( 'lesson', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            activity('Lessons')
                ->causedBy(auth()->user())
                ->log('Web Lesson Create Viewed');

            $lessons = CourseLessons::get();
            $chapters = CourseChapters::get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.lessons.create', compact('lessons', 'chapters',  'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();

        }
    }

    public function store(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $validator = Validator::make($request->all(),[
            'title' => 'required|max:255',
            'chapter' => 'required',
        ]);

        if ($validator->fails()){
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withErrors($validator);
        }

        try {

            DB::beginTransaction();
            $lesson = new CourseLessons();
            $lesson->title = $request->title;
            $lesson->slug = Str::slug($request->title);

            $lesson_image = 'image';
            $lesson_path = "courses/lessons";

            app(FileUploadService::class)->image_store($request, $lesson_image, $lesson, $lesson_path);

            $lesson->content = $request->lesson_content;
            $lesson->chapter_id = $request->chapter;
            $lesson->save();
            $lesson->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            activity('Lessons')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Lesson Stored');

            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('lessons.index');

        } catch (\Exception $e) {
//            Toastr::error($e->getMessage(), 'Ошибка');
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function edit(CourseLessons $lesson)
    {
        try {
            activity('Lessons')
                ->causedBy(auth()->user())
                ->log('Web Lesson Edit Viewed');

            $chapters = CourseChapters::get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.lessons.edit', compact('lesson', 'chapters', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function update(Request $request, CourseLessons $lesson)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'chapter' => 'required',
        ]);

        if ($validator->fails()){
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withErrors($validator);
        }

        try {

            DB::beginTransaction();
            $lesson = CourseLessons::find($lesson->id);
            $lesson->title = $request->title;
            $lesson->slug = Str::slug($request->title);

            $lesson_image = 'image';
            $lesson_path = "courses/lessons";

            app(FileUploadService::class)->image_update($request, $lesson_image, $lesson, $lesson_path);

            $lesson->content = $request->lesson_content;
            $lesson->chapter_id = $request->chapter;
            $lesson->save();
            $lesson->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            activity('Lessons')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Lesson Updated');

            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('lessons.index');

        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function block(Request $request, CourseLessons $lesson)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            activity('Lessons')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Lesson blocked');

            DB::beginTransaction();
            $lesson = CourseLessons::find($lesson->id);
            if ($lesson->active_status == 0){
                $lesson->active_status = 1;
            }else{
                $lesson->active_status = 0;
            }
            $lesson->save();
            $lesson->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('lessons.index');
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, CourseLessons $lesson)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            activity('Lessons')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Lesson destroyed');

            DB::beginTransaction();
            $lesson->delete();
            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('lessons.index');
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }
}

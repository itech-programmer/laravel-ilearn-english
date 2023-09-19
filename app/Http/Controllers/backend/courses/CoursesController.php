<?php

namespace App\Http\Controllers\backend\courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\courses\CourseStoreRequest;
use App\Http\Requests\courses\CourseUpdateRequest;
use App\Models\courses\Courses;
use App\Models\general_settings\GeneralSettings;
use App\Models\User;
use App\Services\FileUploadService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CoursesController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        try {

            activity('Courses')
                ->causedBy(auth()->user())
                ->log('Web Courses Viewed');

            $courses = Courses::get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.index', compact('courses', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function show(Courses $course)
    {
        try {
            activity('Courses')
                ->causedBy(auth()->user())
                ->log('Web Course Info Viewed');

            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.show',
                compact( 'course', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            activity('Courses')
                ->causedBy(auth()->user())
                ->log('Web Course Create Viewed');

            $teachers = User::role('teacher')->get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.create', compact('teachers', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'teacher' => 'required',
        ]);

        if ($validator->fails()){
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withErrors($validator);
        }

        try {

            DB::beginTransaction();
            $course = new Courses();
            $course->title = $request->title;
            $course->slug = Str::slug($request->title);
            if (auth()->user()->roles->implode("slug") == "teacher"){
                $course->teacher_id = auth()->user()->id;
            }else{
                $course->teacher_id = $request->teacher;
            }
            $course->description = $request->description;

            $course_image = 'image';
            $course_path = "courses";

            app(FileUploadService::class)->image_store($request, $course_image, $course, $course_path);

            $course->save();
            $course->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            activity('Courses')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Course Stored');

            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('courses.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Courses $course)
    {
        try {
            activity('Courses')
                ->causedBy(auth()->user())
                ->log('Web Course Edit Viewed');

            $teachers = User::role('teacher')->get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.edit', compact('course', 'teachers', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function update(Request $request, Courses $course)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'teacher' => 'required',
        ]);

        if ($validator->fails()){
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withErrors($validator);
        }

        try {

            DB::beginTransaction();
            $course = Courses::find($course->id);
            $course->title = $request->title;
            $course->slug = Str::slug($request->title);
            if (auth()->user()->roles->implode("slug") == "teacher"){
                $course->teacher_id = auth()->user()->id;
            }else{
                $course->teacher_id = $request->teacher;
            }
            $course->description = $request->description;

            $course_image = 'image';
            $course_path = "courses";

            app(FileUploadService::class)->image_update($request, $course_image, $course, $course_path);

            $course->save();
            $course->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            activity('Courses')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Course Updated');

            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('courses.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function block(Request $request, Courses $course)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            activity('Courses')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Course blocked');

            DB::beginTransaction();
            $course = Courses::find($course->id);
            if ($course->active_status == 0){
                $course->active_status = 1;
            }else{
                $course->active_status = 0;
            }
            $course->save();
            $course->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('courses.index');
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, Courses $course)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            activity('Courses')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Course destroyed');

            DB::beginTransaction();
            $course->delete();
            if (file_exists($course->image)) {
                File::delete($course->image);
            }
            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('courses.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }
}

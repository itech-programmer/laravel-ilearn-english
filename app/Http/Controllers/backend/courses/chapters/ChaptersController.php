<?php

namespace App\Http\Controllers\backend\courses\chapters;

use App\Http\Controllers\Controller;
use App\Models\courses\chapters\CourseChapters;
use App\Models\courses\Courses;
use App\Models\general_settings\GeneralSettings;
use App\Services\FileUploadService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ChaptersController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        try {

            activity('Chapters')
                ->causedBy(auth()->user())
                ->log('Web Chapters Viewed');

            $courses = Courses::get();
            $chapters = CourseChapters::get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.chapters.index', compact('courses', 'chapters', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function show(CourseChapters $chapter)
    {
        try {

            activity('Chapters')
                ->causedBy(auth()->user())
                ->log('Web Chapter Info Viewed');

            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.chapters.show', compact( 'chapter', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            activity('Chapters')
                ->causedBy(auth()->user())
                ->log('Web Chapter Create Viewed');

            $courses = Courses::get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.chapters.create', compact('courses', 'general_settings'));
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
            'image' => 'required|max:2048',
            'course' => 'required',
        ]);

        if ($validator->fails()){
        Toastr::error('Операция не удалась', 'Ошибка');
        return redirect()->back()->withErrors($validator);
        }

        try {

            DB::beginTransaction();
            $chapter = new CourseChapters();
            $chapter->title = $request->title;
            $chapter->slug = Str::slug($request->title);
            $chapter->course_id = $request->course;

            $chapter_image = 'image';
            $chapter_path = "courses/chapters";

            app(FileUploadService::class)->image_store($request, $chapter_image, $chapter, $chapter_path);

            $chapter->save();
            $chapter->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            activity('Chapters')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Chapter Stored');

            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('chapters.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function edit(CourseChapters $chapter)
    {
        try {
            activity('Chapters')
                ->causedBy(auth()->user())
                ->log('Web Chapter Edit Viewed');

            $courses = Courses::get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.chapters.edit', compact('chapter', 'courses', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function update(Request $request, CourseChapters $chapter)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'course' => 'required',
        ]);

        if ($validator->fails()){
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withErrors($validator);
        }

        try {

            DB::beginTransaction();
            $chapter = CourseChapters::find($chapter->id);
            $chapter->title = $request->title;
            $chapter->slug = Str::slug($request->title);
            $chapter->course_id = $request->course;

            $chapter_image = 'image';
            $chapter_path = "courses/chapters";

            app(FileUploadService::class)->image_update($request, $chapter_image, $chapter, $chapter_path);

            $chapter->save();
            $chapter->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            activity('Chapters')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Chapter Updated');

            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('chapters.index');

        } catch (\Exception $e) {
//            Toastr::error($e->getMessage(), 'Ошибка');
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function block(Request $request, CourseChapters $chapter)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            activity('Chapters')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Chapter blocked');

            DB::beginTransaction();
            $chapter = CourseChapters::find($chapter->id);
            if ($chapter->active_status == 0){
                $chapter->active_status = 1;
            }else{
                $chapter->active_status = 0;
            }
            $chapter->save();
            $chapter->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('chapters.index');
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, CourseChapters $chapter)
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            activity('Chapters')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Chapter destroyed');

            $chapter->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('chapters.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }
}

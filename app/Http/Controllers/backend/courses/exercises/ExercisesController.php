<?php

namespace App\Http\Controllers\backend\courses\exercises;

use App\Http\Controllers\Controller;
use App\Http\Requests\courses\exercises\ExerciseStoreRequest;
use App\Http\Requests\courses\exercises\ExerciseUpdateRequest;
use App\Models\courses\exercises\CourseExercises;
use App\Models\courses\exercises\ExerciseConditions;
use App\Models\courses\lessons\CourseLessons;
use App\Models\general_settings\GeneralSettings;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExercisesController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        try {
            activity('Exercises')
                ->causedBy(auth()->user())
                ->log('Web Exercise Viewed');

            $exercises = CourseExercises::get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.exercises.index', compact('exercises', 'general_settings'));
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

            $exercises = CourseExercises::get();
            $conditions = ExerciseConditions::get();
            $lessons = CourseLessons::get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.exercises.create', compact('exercises', 'conditions', 'lessons',  'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();

        }
    }

    public function store(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $validator = Validator::make($request->all(),[
            'condition' => 'required',
            'answer' => 'required',
            'lesson' => 'required',
            'exercise_content' => 'required',
        ]);

        if ($validator->fails()){
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withErrors($validator);
        }

        try {

            DB::beginTransaction();
            $exercise = new CourseExercises();
            $exercise->content = $request->exercise_content;
            $exercise->answer = $request->answer;
            $exercise->condition_id = $request->condition;
            $exercise->lesson_id = $request->lesson;
            $exercise->save();
            $exercise->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            activity('Exercises')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Exercise Stored');

            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('exercises.index');

        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Ошибка');
//            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function edit(CourseExercises $exercise)
    {
        try {
            activity('Exercises')
                ->causedBy(auth()->user())
                ->log('Web Exercise Edit Viewed');

            $conditions = ExerciseConditions::get();
            $lessons = CourseLessons::get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.exercises.edit', compact('exercise', 'conditions', 'lessons', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function update(Request $request, CourseExercises $exercise)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $validator = Validator::make($request->all(),[
            'condition' => 'required',
            'answer' => 'required',
            'lesson' => 'required',
            'exercise_content' => 'required',
        ]);

        if ($validator->fails()){
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withErrors($validator);
        }

        try {

            DB::beginTransaction();
            $exercise = CourseExercises::find($exercise->id);
            $exercise->content = $request->exercise_content;
            $exercise->answer = $request->answer;
            $exercise->condition_id = $request->condition;
            $exercise->lesson_id = $request->lesson;
            $exercise->save();
            $exercise->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            activity('Exercises')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Exercise Updated');

            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('exercises.index');

        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function block(Request $request, CourseExercises $exercise)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            activity('Exercises')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Exercise blocked');

            DB::beginTransaction();
            $exercise = CourseExercises::find($exercise->id);
            if ($exercise->active_status == 0){
                $exercise->active_status = 1;
            }else{
                $exercise->active_status = 0;
            }
            $exercise->save();
            $exercise->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('exercises.index');
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, CourseExercises $exercise)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            activity('Exercises')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Exercise destroyed');

            DB::beginTransaction();
            $exercise->delete();
            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('exercises.index');
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }
}

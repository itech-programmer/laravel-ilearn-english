<?php

namespace App\Http\Controllers\backend\courses\questions;

use App\Http\Controllers\Controller;
use App\Http\Requests\questions\QuestionStoreRequest;
use App\Models\courses\chapters\CourseChapters;
use App\Models\courses\lessons\CourseLessons;
use App\Models\courses\questions\CourseQuestions;
use App\Models\courses\questions\QuestionAnswers;
use App\Models\general_settings\base_setups\BaseSetups;
use App\Models\general_settings\GeneralSettings;
use App\Services\CommonServices;
use App\Services\FileUploadService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class QuestionsController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        try {
            activity('Questions')
                ->causedBy(auth()->user())
                ->log('Web Questions Viewed');

            $questions = CourseQuestions::orderBy('id', 'DESC')->get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.questions.index', compact('questions', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function show(CourseQuestions $question)
    {
        try {
            activity('Questions')
                ->causedBy(auth()->user())
                ->log('Web Question Info Viewed');

            $general_settings = GeneralSettings::where('active_status', 1)->first();
            return view('backend.default.courses.questions.show',
                compact( 'question', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            activity('Questions')
                ->causedBy(auth()->user())
                ->log('Web Question Create Viewed');

            $lessons = CourseLessons::orderBy('id', 'DESC')->get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();

            return view('backend.default.courses.questions.create', compact('lessons', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // $validator = Validator::make($request->all(),[
        //     'question_title' => 'required',
        //     'chapter' => 'required',

        //     'answer_title_1' => 'required',
        //     'type_1' => 'required',

        //     'answer_title_2' => 'required',
        //     'type_2' => 'required',

        //     'answer_title_3' => 'required',
        //     'type_3' => 'required',

        //     'answer_title_4' => 'required',
        //     'type_4' => 'required',
        // ]);

        // if ($validator->fails()){
        //     Toastr::error('Операция не удалась', 'Ошибка');
        //     return redirect()->back()->withInput()->withErrors($validator);
        // }

        // try {

            DB::beginTransaction();
            $question = new CourseQuestions();
            $question->question_title = $request->question_title;
            $question->slug = Str::slug($request->question_title);
            $question->lesson_id = $request->chapter;
            if (empty($request->time_limit)){
                $question->time_limit = 15;
            }else{
                $question->time_limit = $request->time_limit;
            }
            if (empty($request->point)){
                $question->point = 5;
            }else{
                $question->point = $request->point;
            }
            $question_image = 'question_image';
            $question_path = "courses/questions";

            app(FileUploadService::class)->image_store($request, $question_image, $question, $question_path);

            $question->save();
            $question->toArray();

            $answer_path = "courses/questions/answers";

            if (!empty($request->answer_title_1)) {
                $answer_1 = new QuestionAnswers();
                $answer_1->answer_title = $request->answer_title_1;
                $answer_1->slug = Str::slug($request->answer_title_1);

                $answer_image_1 = 'answer_image_1';

                app(FileUploadService::class)->image_store($request, $answer_image_1, $answer_1, $answer_path);

                $answer_1->true_answer = $request->type_1;
                $answer_1->question_id = $question->id;
                $answer_1->save();
                $answer_1->toArray();
            }

            if (!empty($request->answer_title_2)) {
                $answer_2 = new QuestionAnswers();
                $answer_2->answer_title = $request->answer_title_2;
                $answer_2->slug = Str::slug($request->answer_title_2);

                $answer_image_2 = 'answer_image_2';

                app(FileUploadService::class)->image_store($request, $answer_image_2, $answer_2, $answer_path);

                $answer_2->true_answer = $request->type_2;
                $answer_2->question_id = $question->id;
                $answer_2->save();
                $answer_2->toArray();
            }

            if (!empty($request->answer_title_3)) {
                $answer_3 = new QuestionAnswers();
                $answer_3->answer_title = $request->answer_title_3;
                $answer_3->slug = Str::slug($request->answer_title_3);

                $answer_image_3 = 'answer_image_3';

                app(FileUploadService::class)->image_store($request, $answer_image_3, $answer_3, $answer_path);

                $answer_3->true_answer = $request->type_3;
                $answer_3->question_id = $question->id;
                $answer_3->save();
                $answer_3->toArray();
            }

            if (!empty($request->answer_title_4)) {
                $answer_4 = new QuestionAnswers();
                $answer_4->answer_title = $request->answer_title_4;
                $answer_4->slug = Str::slug($request->answer_title_4);

                $answer_image_4 = 'answer_image_4';

                app(FileUploadService::class)->image_store($request, $answer_image_4, $answer_4, $answer_path);

                $answer_4->true_answer = $request->type_4;
                $answer_4->question_id = $question->id;
                $answer_4->save();
                $answer_4->toArray();
            }
            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            activity('Questions')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Question Stored');

            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('questions.index');

        // } catch (\Exception $e) {
        //     Toastr::error('Операция не удалась', 'Ошибка');
        //     return redirect()->back()->withInput();
        // }
    }

    public function edit(CourseQuestions $question)
    {
        try {
            activity('Questions')
                ->causedBy(auth()->user())
                ->log('Web Question Edit Viewed');

            $lessons = CourseLessons::orderBy('id', 'DESC')->get();
            $answers = QuestionAnswers::where('question_id', $question->id)->get();
            $general_settings = GeneralSettings::where('active_status', 1)->first();

            return view('backend.default.courses.questions.edit', compact('answers', 'question', 'lessons', 'general_settings'));
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back();
        }
    }

    public function update(Request $request, CourseQuestions $question)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // $validator = Validator::make($request->all(),[
        //     'question_title' => 'required',
        //     'chapter' => 'required',

        //     'answer_title_1' => 'required',
        //     'type_1' => 'required',

        //     'answer_title_2' => 'required',
        //     'type_2' => 'required',

        //     'answer_title_3' => 'required',
        //     'type_3' => 'required',

        //     'answer_title_4' => 'required',
        //     'type_4' => 'required',
        // ]);

        // if ($validator->fails()){
        //     Toastr::error('Операция не удалась', 'Ошибка');
        //     return redirect()->back()->withInput()->withErrors($validator);
        // }

        try {

            DB::beginTransaction();
            $questions = CourseQuestions::find($question->id);
            $questions->question_title = $request->question_title;
            $questions->slug = Str::slug($request->question_title);
            $questions->lesson_id = $request->chapter;
            if (empty($request->time_limit)){
                $questions->time_limit = 15;
            }else{
                $questions->time_limit = $request->time_limit;
            }
            if (empty($request->point)){
                $questions->point = 5;
            }else{
                $questions->point = $request->point;
            }

            $question_image = 'question_image';
            $question_path = "courses/questions";

            app(FileUploadService::class)->image_store($request, $question_image, $questions, $question_path);

            $questions->save();
            $questions->toArray();

            $answer_path = "courses/questions/answers";

            if (!empty($request->answer_title_1)) {
                $answer_1 = QuestionAnswers::where('id', $request->answer_id_1)->first();
                $answer_1->answer_title = $request->answer_title_1;
                $answer_1->slug = Str::slug($request->answer_title_1);

                $answer_image_1 = 'answer_image_1';

                app(FileUploadService::class)->image_store($request, $answer_image_1, $answer_1, $answer_path);

                $answer_1->true_answer = $request->type_1;
                $answer_1->question_id = $question->id;
                $answer_1->save();
                $answer_1->toArray();
            }

            if (!empty($request->answer_title_2)) {
                $answer_2 = QuestionAnswers::where('id', $request->answer_id_2)->first();
                $answer_2->answer_title = $request->answer_title_2;
                $answer_2->slug = Str::slug($request->answer_title_2);

                $answer_image_2 = 'answer_image_2';

                app(FileUploadService::class)->image_store($request, $answer_image_2, $answer_2, $answer_path);

                $answer_2->true_answer = $request->type_2;
                $answer_2->question_id = $question->id;
                $answer_2->save();
                $answer_2->toArray();
            }

            if (!empty($request->answer_title_3)) {
                $answer_3 = QuestionAnswers::where('id', $request->answer_id_3)->first();
                $answer_3->answer_title = $request->answer_title_3;
                $answer_3->slug = Str::slug($request->answer_title_3);

                $answer_image_3 = 'answer_image_3';

                app(FileUploadService::class)->image_store($request, $answer_image_3, $answer_3, $answer_path);

                $answer_3->true_answer = $request->type_3;
                $answer_3->question_id = $question->id;
                $answer_3->save();
                $answer_3->toArray();
            }

            if (!empty($request->answer_title_4)) {
                $answer_4 = QuestionAnswers::where('id', $request->answer_id_4)->first();
                $answer_4->answer_title = $request->answer_title_4;
                $answer_4->slug = Str::slug($request->answer_title_4);

                $answer_image_4 = 'answer_image_4';

                app(FileUploadService::class)->image_store($request, $answer_image_4, $answer_4, $answer_path);

                $answer_4->true_answer = $request->type_4;
                $answer_4->question_id = $question->id;
                $answer_4->save();
                $answer_4->toArray();
            }
            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            activity('Questions')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Question Updated');

            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('questions.index');

        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function block(Request $request, CourseQuestions $question)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            activity('Questions')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Question blocked');

            DB::beginTransaction();
            $question = CourseQuestions::find($question->id);
            if ($question->active_status == 0){
                $question->active_status = 1;
            }else{
                $question->active_status = 0;
            }
            $question->save();
            $question->toArray();

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('questions.index');
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, CourseQuestions $question)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            activity('Questions')
                ->causedBy(auth()->user())
                ->withProperties($request->all())
                ->log('Web Question destroyed');

            DB::beginTransaction();
            $question->delete();
            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Toastr::success('Операция прошла успешно', 'Успех');
            return redirect()->route('questions.index');
        } catch (\Exception $e) {
            Toastr::error('Операция не удалась', 'Ошибка');
            return redirect()->back()->withInput();
        }
    }
}

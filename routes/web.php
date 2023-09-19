<?php

use App\Http\Controllers\backend\auth\LoginController;
use App\Http\Controllers\backend\courses\chapters\ChaptersController;
use App\Http\Controllers\backend\courses\CoursesController;
use App\Http\Controllers\backend\courses\exercises\ExercisesController;
use App\Http\Controllers\backend\courses\lessons\LessonsController;
use App\Http\Controllers\backend\courses\questions\QuestionsController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\dictionaries\DictionariesController;
use App\Http\Controllers\backend\users\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('auth.index');
Route::post('/auth', [LoginController::class, 'auth'])->name('auth');

Route::group(['middleware' => ['auth']], function () {

    Route::get('status', [UsersController::class, 'user_online_status']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('backend.index');

/*
|--------------------------------------------------------------------------
| Start Users Routes
|--------------------------------------------------------------------------
*/
    //user profile
    Route::get('/user/{user:slug}/profile', [UsersController::class, 'profile'])->name('user.profile');
    //user profile update
    Route::put('user/{user:slug}/profile/update', [UsersController::class, 'password'])->name('user.profile.update');
    //user profile logout
    Route::post('user/profile/logout', [LoginController::class, 'logout'])->name('user.profile.logout');
    //users
    Route::get('/users/index', [UsersController::class,'index'])->name('users.index');
    //user show
    Route::get('/user/{user:slug}/show', [UsersController::class, 'show'])->name('user.show');
    //user block
    Route::put('/user/{user:slug}/block', [UsersController::class,'block'])->name('user.block');
/*
|--------------------------------------------------------------------------
| End Users Routes
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Start Courses Routes
|--------------------------------------------------------------------------
*/
    //courses
    Route::get('/courses/index', [CoursesController::class,'index'])->name('courses.index');
    //course show
    Route::get('/courses/{course:slug}/show', [CoursesController::class, 'show'])->name('course.show');
    //course create
    Route::get('/course/create', [CoursesController::class,'create'])->name('course.create');
    //course store
    Route::post('/course/store', [CoursesController::class,'store'])->name('course.store');
    //course edit
    Route::get('/course/{course:slug}/edit', [CoursesController::class,'edit'])->name('course.edit');
    //course update
    Route::put('/course/{course:slug}/update', [CoursesController::class,'update'])->name('course.update');
    //course block
    Route::put('/courses/{course:slug}/block', [CoursesController::class,'block'])->name('course.block');
    //course destroy
    Route::delete('/courses/{course:slug}/destroy', [CoursesController::class,'destroy'])->name('course.destroy');
/*
|--------------------------------------------------------------------------
| End Courses Routes
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Start Chapters Routes
|--------------------------------------------------------------------------
*/
    //chapters
    Route::get('/chapters/index', [ChaptersController::class,'index'])->name('chapters.index');
    //chapter show
    Route::get('/chapter/{chapter:slug}/show', [ChaptersController::class,'show'])->name('chapter.show');
    //chapter create
    Route::get('/chapter/create', [ChaptersController::class,'create'])->name('chapter.create');
    //chapter store
    Route::post('/chapter/store', [ChaptersController::class,'store'])->name('chapter.store');
    //chapter edit
    Route::get('/chapter/{chapter:slug}/edit', [ChaptersController::class,'edit'])->name('chapter.edit');
    //chapter update
    Route::put('/chapter/{chapter:slug}/update', [ChaptersController::class,'update'])->name('chapter.update');
    //chapter block
    Route::put('/chapter/{chapter:slug}/block', [ChaptersController::class,'block'])->name('chapter.block');
    //chapter destroy
    Route::delete('/chapter/{chapter:slug}/destroy', [ChaptersController::class,'destroy'])->name('chapter.destroy');
/*
|--------------------------------------------------------------------------
| End Chapters Routes
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Start Lessons Routes
|--------------------------------------------------------------------------
*/
    //lessons
    Route::get('/lessons/index', [LessonsController::class,'index'])->name('lessons.index');
    //lesson show
    Route::get('/lesson/{lesson:slug}/show', [LessonsController::class, 'show'])->name('lesson.show');
    //lesson create
    Route::get('/lesson/create', [LessonsController::class,'create'])->name('lesson.create');
    //lesson store
    Route::post('/lesson/store', [LessonsController::class,'store'])->name('lesson.store');
    //lesson edit
    Route::get('/lesson/{lesson:slug}/edit', [LessonsController::class,'edit'])->name('lesson.edit');
    //lesson update
    Route::put('/lesson/{lesson:slug}/update', [LessonsController::class,'update'])->name('lesson.update');
    //lesson block
    Route::put('/lesson/{lesson:slug}/block', [LessonsController::class,'block'])->name('lesson.block');
    //lesson destroy
    Route::delete('/lesson/{lesson:slug}/destroy', [LessonsController::class,'destroy'])->name('lesson.destroy');
/*
|--------------------------------------------------------------------------
| End Lessons Routes
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Start Exercises Routes
|--------------------------------------------------------------------------
*/
    //exercises
    Route::get('/exercises/index', [ExercisesController::class,'index'])->name('exercises.index');
    //exercise create
    Route::get('/exercise/create', [ExercisesController::class,'create'])->name('exercise.create');
    //exercise store
    Route::post('/exercise/store', [ExercisesController::class,'store'])->name('exercise.store');
    //exercise edit
    Route::get('/exercise/{exercise:id}/edit', [ExercisesController::class,'edit'])->name('exercise.edit');
    //exercise update
    Route::put('/exercise/{exercise:id}/update', [ExercisesController::class,'update'])->name('exercise.update');
    //exercise block
    Route::put('/exercise/{exercise:id}/block', [ExercisesController::class,'block'])->name('exercise.block');
    //exercise destroy
    Route::delete('/exercise/{exercise:id}/destroy', [ExercisesController::class,'destroy'])->name('exercise.destroy');
/*
|--------------------------------------------------------------------------
| End Exercises Routes
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Start Questions Routes
|--------------------------------------------------------------------------
*/
    //questions
    Route::get('/questions/index', [QuestionsController::class,'index'])->name('questions.index');
    //question show
    Route::get('/question/{question:slug}/show', [QuestionsController::class, 'show'])->name('question.show');
    //question create
    Route::get('/question/create', [QuestionsController::class,'create'])->name('question.create');
    //question store
    Route::post('/question/store', [QuestionsController::class,'store'])->name('question.store');
    //question edit
    Route::get('/question/{question:slug}/edit', [QuestionsController::class,'edit'])->name('question.edit');
    //question update
    Route::put('/question/{question:slug}/update', [QuestionsController::class,'update'])->name('question.update');
    //question block
    Route::put('/question/{question:slug}/block', [QuestionsController::class,'block'])->name('question.block');
    //question destroy
    Route::delete('/question/{question:slug}/destroy', [QuestionsController::class,'destroy'])->name('question.destroy');
/*
|--------------------------------------------------------------------------
| End Questions Routes
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Start Dictionary Routes
|--------------------------------------------------------------------------
*/
    //dictionaries
    Route::get('/dictionaries/index', [DictionariesController::class,'index'])->name('dictionaries.index');
    //dictionary show
    Route::get('/dictionary/{dictionary:id}/show', [DictionariesController::class, 'show'])->name('dictionary.show');
    //dictionary create
    Route::get('/dictionary/create', [DictionariesController::class,'create'])->name('dictionary.create');
    //dictionary store
    Route::post('/dictionary/store', [DictionariesController::class,'store'])->name('dictionary.store');
    //dictionary edit
    Route::get('/dictionary/{dictionary:id}/edit', [DictionariesController::class,'edit'])->name('dictionary.edit');
    //dictionary update
    Route::put('/dictionary/{dictionary:id}/update', [DictionariesController::class,'update'])->name('dictionary.update');
    //dictionary block
    Route::put('/dictionary/{dictionary:id}/block', [DictionariesController::class,'block'])->name('dictionary.block');
    //dictionary destroy
    Route::delete('/dictionary/{dictionary:id}/destroy', [DictionariesController::class,'destroy'])->name('dictionary.destroy');
/*
|--------------------------------------------------------------------------
| End Dictionary Routes
|--------------------------------------------------------------------------
*/
});

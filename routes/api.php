<?php

use App\Http\Controllers\api\auth\LoginController;
use App\Http\Controllers\api\auth\RegisterController;
use App\Http\Controllers\api\courses\chapters\ChaptersController;
use App\Http\Controllers\api\courses\chapters\exercises\ExercisesController;
use App\Http\Controllers\api\courses\chapters\lessons\LessonsController;
use App\Http\Controllers\api\courses\chapters\questions\QuestionsController;
use App\Http\Controllers\api\courses\CoursesController;
use App\Http\Controllers\api\DictionaryController;
use App\Http\Controllers\api\GameScoresController;
use App\Http\Controllers\api\LeaderBoardController;
use App\Http\Controllers\api\ProfileController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);

Route::get('privacy-policy', [CoursesController::class, 'privacy_policy']);

Route::middleware('auth:api')->namespace('api')->group( function () {
    
    //Profile
    Route::get('profile', [ProfileController::class, 'index']);
    Route::get('user-settings', [ProfileController::class, 'settings']);
    Route::post('save-user-settings', [ProfileController::class, 'save_settings']);
    Route::post('update-profile', [ProfileController::class, 'update']);
    Route::post('update-avatar', [ProfileController::class, 'update_avatar']);
    Route::post('change-password', [ProfileController::class, 'change_password']);

    //Dictionary
    Route::get('dictionaries', [DictionaryController::class, 'index']);

    //Leader Board
    Route::get('users/{type}/leader-board', [LeaderBoardController::class, 'index']);

    //Games
    Route::get('games/fives', [ProfileController::class, 'fives_game']);
    Route::post('games/scores', [ProfileController::class, 'store_score']);

    //Courses
    Route::get('courses', [CoursesController::class, 'index']);
    //Chapters
    Route::get('vocabulary/chapters', [ChaptersController::class, 'vocabulary_index']);
    Route::get('grammar/chapters', [ChaptersController::class, 'grammar_index']);

    Route::get('chapter/{id}', [ChaptersController::class, 'show']);
    //lessons
    Route::get('lesson/{id}', [LessonsController::class, 'index']);
    //exercises
    Route::get('lesson/{id}/exercises/', [ExercisesController::class, 'index']);
    //questions
    Route::get('lesson/{id}/questions/', [QuestionsController::class, 'index']);
    //answer
    Route::post('submit-question-answer/{id}', [QuestionsController::class, 'answer']);
    Route::post('submit-exercise-answer', [ExercisesController::class, 'answer']);
});

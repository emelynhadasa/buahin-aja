<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VotingController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubmissionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\QuizEventController;
use App\Models\SubmissionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/students', [StudentController::class, 'sync_students']);

Route::controller(UsersController::class)->group(function () {
    Route::get('/student/{student_id}', 'get')->name('admin.users.get');
    Route::get('/gpa/{student_id}', 'get_gpa')->name('admin.users.get_gpa');
    Route::get('/schedule/{student_id}', 'get_schedule')->name('admin.users.get_schedule');
    Route::get('/attendance/{student_id}', 'get_attendance')->name('admin.users.get_attendance');
    Route::put('/avatar/{student_id}', 'edit_avatar')->name('admin.users.edit_avatar');
    Route::get('/leaderboard/{student_id}', 'get_leaderboard')->name('admin.users.get_leaderboard');
    Route::get('/leaderboard/event/{event_id}/{student_id}', 'get_leaderboard_event')->name('admin.users.get_leaderboard_event');
});

Route::get('/token', function () {
    return response()->json(['token' => csrf_token()]);
});

Route::controller(EventController::class)->group(function () {
    Route::get('/events/new/{student_id}', 'get_new')->name('admin.events.get_new');
    Route::get('/events/progressed/{student_id}', 'get_progressed')->name('admin.events.get_progressed');
    Route::post('/events/join/{event_id}/{student_id}', 'join_event')->name('admin.events.join_event');
    Route::get('/events/{event_id}/{student_id}', 'get_event')->name('admin.events.get_event');
    Route::get('/attempt/{event_id}/{student_id}', 'get_attempt')->name('admin.events.get_attempt');
    Route::post('/attempt/{event_id}/{student_id}', 'post_attempt')->name('admin.events.post_attempt');
});

Route::controller(ProgressController::class)->group(function () {
    Route::get('/score/{student_id}', 'get_score')->name('user.progress.get_score');
});

Route::controller(NewsController::class)->group(function () {
    Route::get('/news', 'get')->name('admin.news.get');
    Route::get('/news/{page}', 'get_page')->name('admin.news.get_page');
});

Route::controller(QuizEventController::class)->group(function () {
    Route::post('/quiz/end/{event_id}/{student_id}', 'post_finish_attempt')->name('admin.quiz.post_finish_attempt');
    Route::post('/quiz/start/{event_id}/{student_id}', 'post_start_attempt')->name('admin.quiz.post_start_attempt');
});

Route::controller(SubmissionController::class)->group(function () {
    Route::post('/submission/{event_id}/{student_id}', 'create')->name('admin.submission_answer.create');
    Route::get('/submission/{event_id}/', 'get')->name('admin.submission_answer.get');
});

Route::controller(ProfessionController::class)->group(function () {
    Route::get('/profession/{category_id}', 'get')->name('admin.profession.get');
});

Route::controller(VotingController::class)->group(function () {
    Route::get("/votings", "get_votings")->name('admin.voting.get_votings');
    Route::get("/votings/{id}", "show_voting")->name('admin.voting.show');
    Route::get("/voting", "get_latest_voting")->name('admin.voting.get_latest_voting');
    Route::post("/voting", "user_vote_option")->name('admin.voting.user_vote_option');
});

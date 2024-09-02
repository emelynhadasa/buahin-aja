<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\Requirement\BatchController;
use App\Http\Controllers\BrowseController;
use App\Http\Controllers\Requirement\MajorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventResultController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\Requirement\CategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\VotingController;
use App\Http\Controllers\Admin\VotingOptionsController;
use App\Http\Controllers\QuizEventController;
use App\Http\Controllers\SubmissionEventController;
use App\Http\Controllers\Requirement\TypeController;
use App\Http\Controllers\WelcomePageController;
use App\Http\Middleware\EnsureAuthenticated;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User;
use App\Http\Controllers\User\NewsController as UserNewsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [NewsController::class, 'welcome_page'])->name('welcome');

Route::get('/dashboard', function () {
    $userRole = Auth::user()->role_id;
    if ($userRole == 1) {
        return redirect()->route('admin.dashboard');
    } elseif ($userRole == 0) {
        return redirect()->route('user.dashboard');
    }
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(["prefix" => "", "middleware" => EnsureAuthenticated::class], function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('admin/dashboard', 'dashboard')->name('admin.dashboard');
    });

Route::controller(UserController::class)->group(function () {
    Route::get('/user/dashboard', 'dashboard')->name('user.dashboard');
    Route::post('/user/dashboard/{event}/store-quiz', 'store_quiz')->name('user.dashboard.store-quiz');
    Route::get('/user/{event}/play-quiz', 'play_quiz')->name('user.play-quiz');
    Route::get('/user/{event}/event-details', 'event_details')->name('user.event-details');
    Route::get('/user/events', 'event')->name('user.events');
    Route::get('/user/events/{event}/show', 'show_event')->name('user.events.show');
    Route::get('/user/quiz-events/{event}', 'index')->name('user.quiz-events');
    Route::get('/user/news', 'news')->name('user.news');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(Admin\UsersController::class)->group(function () {
    Route::get('/admin/dashboard/users', 'index')->name('admin.users');
    Route::get('/admin/dashboard/users/{user}', 'edit')->name('admin.users.edit');
    Route::get('/admin/dashboard/users/{user}/show', 'show')->name('admin.users.show');
    Route::get('/admin/dashboard/users/{user}/show/{attempt}/details', 'details')->name('admin.users.show.details');
    Route::get('/token', 'get_token')->name('admin.users.get_token');
});

Route::controller(EventController::class)->group(function () {
    Route::get('/admin/events', 'index')->name('admin.events');
    Route::get('/admin/events/create', 'create')->name('admin.events.create');
    Route::post('/admin/events', 'store')->name('admin.events.store');
    Route::get('/admin/events/{event}/show', 'show')->name('admin.events.show');
    Route::get('/admin/events/{event}/edit', 'edit')->name('admin.events.edit');
    Route::get('/admin/events/{event}/delete', 'delete')->name('admin.events.delete');
    Route::post('/admin/events/{event}/update', 'update')->name('admin.events.update');
    // Add routes for different event types
    Route::get('/admin/events/{event}/type1', 'showType1')->name('admin.events.showType1');
    Route::get('/admin/events/{event}/type1/{user}', 'showAnswer')->name('admin.events.showType1.showAnswer');

    Route::get('/admin/events/{event}/type2', 'showType2')->name('admin.events.showType2');
    Route::post('admin/event/save-score/{submission}', [EventController::class, 'saveScore'])->name('admin.event.saveScore');
    Route::post('/admin/events/{event}/save-score/{submission}', 'saveScore')->name('admin.events.saveScore');
});

Route::controller(BatchController::class)->group(function () {
    Route::get('/admin/batches', 'index')->name('admin.batches');
    Route::get('/admin/batches/create', 'create')->name('admin.batches.create');
    Route::post('/admin/batches', 'store')->name('admin.batches.store');
    Route::get('/admin/batches/{batch}/edit', 'edit')->name('admin.batches.edit');
    Route::post('/admin/batches/{batch}/update', 'update')->name('admin.batches.update');
    Route::get('/admin/batches/{batch}/delete', 'delete')->name('admin.batches.delete');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/admin/categories', 'index')->name('admin.categories');
    Route::get('/admin/categories/create', 'create')->name('admin.categories.create');
    Route::post('/admin/categories', 'store')->name('admin.categories.store');
    Route::get('/admin/categories/{category}/edit', 'edit')->name('admin.categories.edit');
    Route::post('/admin/categories/{category}/update', 'update')->name('admin.categories.update');
    Route::get('/admin/categories/{category}/delete', 'delete')->name('admin.categories.delete');
});

Route::controller(AvatarController::class)->group(function () {
    Route::get('/admin/avatars', 'index')->name('admin.avatars');
    Route::get('/admin/avatars/create', 'create')->name('admin.avatars.create');
    Route::post('/admin/avatars/store', 'store')->name('admin.avatars.store');
    Route::get('/admin/avatars/{avatar}/edit', 'edit')->name('admin.avatars.edit');
    Route::post('/admin/avatars/{avatar}/update', 'update')->name('admin.avatars.update');
    Route::get('/admin/avatars/{avatar}/delete', 'destroy')->name('admin.avatars.destroy');
});

Route::controller(BrowseController::class)->group(function () {
    Route::get('/user/browse', 'index')->name('user.browse');
    Route::get('/user/browse/{event}/show', 'show')->name('user.browse.show');
    Route::post('/user/browse/{event}/join', 'join')->name('user.browse.join');
});

Route::controller(ProgressController::class)->group(function () {
    Route::get('/user/progress', 'index')->name('user.progress');
    Route::post('/user/dashboard', 'update')->name('user.progress.update');
});

Route::controller(MajorController::class)->group(function () {
    Route::get('/admin/majors', 'index')->name('admin.majors');
    Route::get('/admin/majors/create', 'create')->name('admin.majors.create');
    Route::post('/admin/majors/store', 'store')->name('admin.majors.store');
    Route::get('/admin/majors/{major}/edit', 'edit')->name('admin.majors.edit');
    Route::post('/admin/majors/{major}/update', 'update')->name('admin.majors.update');
    Route::get('/admin/majors/{major}/delete', 'delete')->name('admin.majors.delete');
});

Route::controller(NewsController::class)->group(function () {
    Route::get('/admin/news', 'index')->name('admin.news');
    Route::get('/admin/news/create', 'create')->name('admin.news.create');
    Route::post('/admin/news/store', 'store')->name('admin.news.store');
    Route::get('/admin/news/{news}/edit', 'edit')->name('admin.news.edit');
    Route::put('/admin/news/{news}/update', 'update')->name('admin.news.update');
    Route::get('/admin/news/{news}/delete', 'destroy')->name('admin.news.destroy');
});


Route::controller(PublisherController::class)->group(function () {
    Route::get('/admin/publishers', 'index')->name('admin.publishers');
    Route::get('/admin/publishers/create', 'create')->name('admin.publishers.create');
    Route::post('/admin/publishers/store', 'store')->name('admin.publishers.store');
    Route::get('/admin/publishers/{publisher}/edit', 'edit')->name('admin.publishers.edit');
    Route::put('/admin/publishers/{publisher}/update', 'update')->name('admin.publishers.update');
    Route::get('/admin/publishers/{publisher}/delete', 'destroy')->name('admin.publishers.destroy');
});

Route::controller(MessageController::class)->group(function () {
    Route::get('/admin/messages', 'index')->name('admin.messages');
    Route::get('/admin/messages/create', 'create')->name('admin.messages.create');
    Route::post('/admin/messages/store', 'store')->name('admin.messages.store');
});

Route::controller(TypeController::class)->group(function () {
    Route::get('/admin/types', 'index')->name('admin.types');
    Route::get('/admin/types/create', 'create')->name('admin.types.create');
    Route::post('/admin/types/store', 'store')->name('admin.types.store');
    Route::get('/admin/types/{type}/edit', 'edit')->name('admin.types.edit');
    Route::post('/admin/types/{type}/update', 'update')->name('admin.types.update');
    Route::get('/admin/types/{type}/delete', 'delete')->name('admin.types.delete');
});

Route::controller(QuizEventController::class)->group(function () {
    Route::get('/admin/quiz-events/{event}', 'index')->name('admin.quiz-events');
    Route::get('/admin/quiz-events/{event}/edit', 'edit')->name('admin.quiz-events.edit');
    Route::post('/admin/quiz-events/{event}/update', 'update')->name('admin.quiz-events.update');
    Route::get('/admin/quiz-events/{event}/delete', 'delete')->name('admin.quiz-events.delete');
    // questions
    Route::get('/admin/quiz-events/{event}/question', 'question')->name('admin.quiz-events.question');
    Route::post('/admin/quiz-events/{event}/question/store_questions', 'store_questions')->name('admin.quiz-events.store_questions');
    // options
    Route::get('/admin/quiz-events/{event}/option', 'option')->name('admin.quiz-events.option');
    Route::post('/admin/quiz-events/{event}/store_options', 'store_options')->name('admin.quiz-events.store_options');
});

    Route::controller(VotingController::class)->group(function () {
        Route::get("/admin/voting", "index")->name("admin.voting");
        Route::get("/admin/voting/create", "create")->name("admin.voting.create");
        Route::post("/admin/voting/create", "store")->name("admin.voting.store");
        Route::get("/admin/voting/{voting}", "show")->name("admin.voting.show");
        Route::patch("/admin/voting/{voting}", "update")->name("admin.voting.update");
        Route::delete("/admin/voting/{voting}", "delete")->name("admin.voting.delete");
        Route::controller(VotingOptionsController::class)->group(function () {
            Route::get('/admin/voting/{voting}/options/create', 'create')->name('admin.voting.options.create');
            Route::post('/admin/voting/{voting}/options/create', 'store')->name('admin.voting.options.store');
            Route::get('/admin/voting/{voting}/options/{option}', 'show')->name('admin.voting.options.show');
            Route::post('/admin/voting/{voting}/options/{option}', 'update')->name('admin.voting.options.update');
            Route::delete('/admin/voting/{voting}/options/{option}', 'delete')->name('admin.voting.options.delete');
            Route::post('/admin/voting/{voting}/options/{option}/vote', 'vote')->name('admin.voting.options.vote');
            Route::delete('/admin/voting/{voting}/options/{option}/vote', 'vote_delete')->name('admin.voting.options.vote.delete');
        });
    });
});

Route::controller(SubmissionEventController::class)->group(function () {
    Route::get('/admin/submission-events/{event}', 'index')->name('admin.submission-events');
    Route::get('/admin/submission-events/{event}/create', 'create')->name('admin.submission-events.create');
    Route::post('/admin/submission-events/{event}', 'store')->name('admin.submission-events.store');
    Route::get('/admin/submission-events/{event}/{submissionEvent}/edit', 'edit')->name('admin.submission-events.edit');
    Route::put('/admin/submission-events/{event}/{submissionEvent}', 'update')->name('admin.submission-events.update');
    Route::get('/admin/submission-events/{event}/{submissionEvent}/delete', 'delete')->name('admin.submission-events.delete');
});


Route::controller(UserNewsController::class)->group(function() {
    Route::get('/user/news/', 'index')->name('user.news');
    Route::get('/user/news/show/{news}', 'show')->name('user.news.show');
});

require __DIR__ . '/auth.php';

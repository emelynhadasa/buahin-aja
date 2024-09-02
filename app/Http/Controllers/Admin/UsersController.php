<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryProgress;
use App\Models\Event;
use App\Models\Quiz\QuizAnswer;
use App\Models\Quiz\QuizAttempt;
use App\Models\Quiz\QuizEvent;
use App\Models\Quiz\QuizOption;
use App\Models\Quiz\QuizQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    public function edit(User $user, Request $request)
    {
        $student_id = $user->student_id;

        $apiUrl = env('API_URL', '');

        $gpa = [
            "accumulative_gpa" => "0.00",
        ];
        if ($apiUrl != '') {
            $req = Http::get('http://103.118.82.98:3000/api/students/' . $student_id . '/gpa');
            $result = $req->json();
            $gpa = $result['data'];

            $currentGpa = $gpa['accumulative_gpa'];
            //make it rounded to x.xx
            $gpa['accumulative_gpa'] = number_format((float)$currentGpa, 2, '.', '');
        }
        return view('admin.users.edit', [
            'user' => $user,
            'gpa' => $gpa
        ]);
    }

    public function show(User $user)
    {
        $student_id = Auth::id();
        $user->load('batches');
        $user->load('majors');
        $user->load('avatar');

        $scores = CategoryProgress::where('user_id', $student_id)->get()->groupBy('category_id');
        $academic = 0;
        $science = 0;
        $art = 0;

        foreach ($scores as $score) {
            switch ($score[0]->category_id) {
                case 1:
                    $academic = $score[0]->score;
                    break;
                case 2:
                    $science = $score[0]->score;
                    break;
                case 3:
                    $art = $score[0]->score;
                    break;
            }
        }

        $quiz_attempts = QuizAttempt::where('user_id', $student_id)->get();
        $quiz_attempts->load('event');

        return view('admin.users.show', [
            'user' => $user,
            'academic' => $academic,
            'science' => $science,
            'art' => $art,
            'quiz_attempts' => $quiz_attempts,
        ]);
    }

    public function details(User $user, QuizAttempt $attempt)
    {
        $event = Event::find($attempt->event_id);

        // load view based on event type
        if ($event->type_id == 1) {
            $quiz_event = QuizEvent::findOrFail($event->id);
            $questions = QuizQuestion::where('event_id', $event->id)->get();

            // collect all answers using question_id
            $answers = QuizAnswer::whereIn('question_id', $questions->pluck('id'))->get();
            $answers->load('questions');
            $answers->load('options');

            $options = QuizOption::whereIn('question_id', $questions->pluck('id'))->get()->groupBy('question_id');

            return view('admin.users.event-quiz', compact('user', 'quiz_event', 'attempt', 'answers', 'options'));
        }
    }

    public function get($student_id)
    {
        $user = User::where('student_id', $student_id)
            ->select("users.*", "majors.name as major", "batches.name as batch", DB::raw("CASE WHEN avatars.id = 0 THEN NULL ELSE avatars.image END as avatar_image"))
            ->join("majors", "majors.id", "=", "users.major_id")
            ->join("batches", "batches.id", "=", "users.batch_id")
            ->leftJoin("avatars", "avatars.id", "=", "users.avatar_id")
            ->first();
        return response()->json(["success" => true, "message" => "User found", "data" => $user]);
    }

    public function get_gpa($student_id)
    {
        $user = User::where('student_id', $student_id)->first();
        return response()->json($user->GPA);
    }

    public function get_schedule($student_id)
    {
        $schedules = User::where('student_id', $student_id)
            ->join('student_schedule', 'users.id', '=', 'student_schedule.user_id')
            ->join('schedules', 'student_schedule.schedule_id', '=', 'schedules.id')
            ->select('schedules.*')
            ->get();

        return response()->json($schedules);
    }

    public function get_attendance($student_id)
    {
        $attendances = User::where('student_id', $student_id)
            ->join('student_schedule', 'users.id', '=', 'student_schedule.user_id')
            ->join('attendance', 'student_schedule.attendance_id', '=', 'attendance.id')
            ->join('schedules', 'student_schedule.schedule_id', '=', 'schedules.id')
            ->select('schedules.course_name', 'attendance.date', 'attendance.status')
            ->get();

        return response()->json($attendances);
    }

    public function edit_avatar($student_id, Request $request)
    {
        $user = User::where('student_id', $student_id)->first();
        $user->avatar_id = $request->avatar_id;
        if ($user->save()) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'Failed to save user']);
        }
    }

    public function get_token()
    {
        return response()->json(['token' => csrf_token()]);
    }

    public function get_leaderboard($student_id)
    {
        $curr_user = User::where('student_id', $student_id)->first();

        // Query params
        $categoryId = request()->query('category_id');
        $batchId = request()->query('batch_id');
        $majorId = request()->query('major_id');
        $limit = request()->query('limit') ?? 10;

        $users = User::join('category_progress', 'users.id', '=', 'category_progress.user_id')
            ->join('majors', 'users.major_id', '=', 'majors.id')
            ->join('batches', 'users.batch_id', '=', 'batches.id')
            ->join('categories', 'category_progress.category_id', '=', 'categories.id')
            ->join('avatars', 'users.avatar_id', '=', 'avatars.id')
            ->select(
                'users.student_id as id',
                'users.first_name',
                'users.last_name',
                'users.avatar_id',
                'users.major_id',
                'users.batch_id',
                'majors.name as major_name',
                'batches.name as batch_name',
                'avatars.image as avatar_image'
            )
            ->selectRaw('SUM(category_progress.score) as total_score');

        if ($categoryId) {
            $users->addSelect([
                'categories.id as category_id',
                'categories.name as category_name'
            ])
                ->where('categories.id', $categoryId)
                ->groupBy('categories.id', 'categories.name');
        }

        $users->groupBy(
            'id',
            'users.first_name',
            'users.last_name',
            'users.avatar_id',
            'users.major_id',
            'users.batch_id',
            'majors.name',
            'batches.name',
            'avatars.image'
        )
            ->orderBy('total_score', 'desc');
        if ($batchId) {
            $users->where('users.batch_id', $batchId);
        }

        if ($majorId) {
            $users->where('users.major_id', $majorId);
        }

        $users = $users->get();

        // Get current user position
        $currentUserPosition = $users->search(function ($user) use ($curr_user) {
            return $user->id == $curr_user->student_id;
        });

        $max_limit = min($limit, 100);

        $users = $users->take($max_limit);

        return response()->json([
            "success" => true,
            "message" => "Leaderboard fetched successfully",
            "data" => [
                'users' => $users,
                'current_user_position' => $currentUserPosition !== false ? $currentUserPosition + 1 : null
            ]
        ]);
    }

    public function get_leaderboard_event($event_id, $student_id)
    {
        $limit = request()->query('limit') ?? 10;

        $curr_user = User::where('student_id', $student_id)->first();

        $users = User::join('event_progress', 'users.id', '=', 'event_progress.user_id')
            ->select(
                'users.student_id as id',
                'users.first_name',
                'users.last_name',
                'users.avatar_id',
                'categories.name as category_name',
                'categories.id as category_id',
                'avatars.image as avatar_image',
                'majors.name as major_name',
                'batches.name as batch_name',
                'event_progress.score as total_score'
            )
            ->orderBy('total_score', 'desc')
            ->join('events', 'event_progress.event_id', '=', 'events.id')
            ->join('majors', 'users.major_id', '=', 'majors.id')
            ->join('batches', 'users.batch_id', '=', 'batches.id')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->join('avatars', 'users.avatar_id', '=', 'avatars.id')
            ->where('event_progress.event_id', $event_id)
            ->get();

        $currentUserPosition = $users->search(function ($user) use ($curr_user) {
            return $user->id == $curr_user->student_id;
        });

        $max_limit = min($limit, 100);

        $users = $users->take($max_limit);

        return response()->json([
            "success" => true,
            "message" => "Leaderboard fetched successfully",
            "data" => [
                'users' => $users,
                'current_user_position' => $currentUserPosition !== false ? $currentUserPosition + 1 : null
            ]
        ]);
    }
}

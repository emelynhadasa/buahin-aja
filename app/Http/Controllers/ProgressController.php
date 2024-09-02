<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\User;
use App\Models\Milestone;
use Carbon\Carbon;

class ProgressController extends Controller
{

     public function index(Request $request)
     {
        $user_id = $request->input('user_id');
        $event_id = $request->input('event_id');

        return view('user.progress.index', compact('user_id', 'event_id'));
     }


    public function update(Request $request)
    {
        $eventId = $request->input('event_id');
        $userId = $request->input('user_id');
        $currentTime = Carbon::now(); // get current date & time

        $event = Event::find($eventId);
        $type = $event->type;
        $eventProgress = $event->progress_num;

        $userProgress = $this->getUserprogress($type, $userId, $eventId);                                                                           // Check if the current date and time are before the submitted end_date
        if ($userProgress->progress != $eventProgress-1 && $userProgress->user_id == $userId && $userProgress->event_id == $eventId && $currentTime->lt($userProgress->end)){
            $this->updateProgress($type, $userId, $eventId, ++$userProgress->progress);
        } elseif ($userProgress->progress == $eventProgress-1 || $currentTime->gt($userProgress->end) ) {
            $this->createMilestone($eventId, $userId, $event->point);          // Check if the current date and time are after the submitted end_date
            $this->deleteProgress($type,$userId, $eventId);
        }
        return redirect()->route('user.dashboard')->with(['success' => 'Added a progress']);
    }

    

    public function get_score($student_id)
    {
        $scores = User::where('student_id', $student_id)
            ->join('category_progress', 'users.id', '=', 'category_progress.user_id')
            ->join('categories', 'category_progress.category_id', '=', 'categories.id')
            ->select('categories.name', 'category_progress.score')
            ->get();

        return response()->json($scores);
    }
}

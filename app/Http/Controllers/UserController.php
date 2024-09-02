<?php

namespace App\Http\Controllers;

use App\Models\CategoryProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\News;
use App\Models\EventProgress;
use App\Models\Quiz\QuizAnswer;
use App\Models\Quiz\QuizAttempt;
use App\Models\Quiz\QuizEvent;
use App\Models\Quiz\QuizOption;
use App\Models\Quiz\QuizQuestion;
use App\Models\User;

class UserController extends Controller
{
    public function event()
    {
        $events = Event::all();
        $events->load('type');
        $events->load('category');
        return view('user.events.index', ['events' => $events]);
    }

    public function show_event(Event $event)
    {
        $attempt = QuizAttempt::where('event_id', $event->id)->first();
        $event->load('batches');
        $event->load('category');
        $event->load('majors');
        $event->load('type');
        return view('user.events.show', compact('event', 'attempt'));
    }

    public function news()
    {
        $news = News::all();
        return view('user.news.index', ['news' => $news]);
    }

    public function dashboard()
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang sedang login
        $userId = $user->id;
    
        if (!$userId) {
            return redirect('/login');
        }
    
        // Fetch events
        $events = Event::with('type')->get();
        $attempt = QuizAttempt::where('user_id', $userId)->first();
    
        // Fetch news
        $news = News::all(); // Mengambil data berita
    
        // Mengirim data ke view
        return view('user.dashboard', [
            'events' => $events,
            'attempt' => $attempt,
            'user' => $user, // Mengirim data pengguna
            'news' => $news // Mengirim data berita
        ]);
    }
      

    public function event_details($id)
    {
        $event = Event::find($id);     
        $quiz_event = QuizEvent::where('event_id', $id)->first();
        return view('user.event-details', [
            'event' => $event, 
            'quiz_event' => $quiz_event,
        ]);
    }

    public function play_quiz(Request $request, $id)
    {
        $start_time = $request->query('start_time');

        $questions = QuizQuestion::where('event_id', $id)->get()->sortBy('order')->shuffle();
        
        $quiz_event = QuizEvent::where('event_id', $id)->first();
        
        $options = QuizOption::all();
        $options->load('questions'); 

        return view('user.play-quiz', [
            'questions' => $questions,
            'options' => $options,
            'quiz_event' => $quiz_event,
            'event' => $id,
            'start_time' => $start_time,
        ]);
    }

    public function store_quiz(Request $request, $id)
    {
        $inputs = $request->all();
        $user_id = Auth::id();  
        $answers = [];
        $event = Event::findOrFail($id);
        $attempts = QuizAttempt::where('event_id', $id)->get();

        // check if the max participants have been reached or not
        if ($attempts->count() <= $event->max_participants or $event->max_participants == 0) {
            foreach ($inputs as $key => $value) {
                if (strpos($key, 'question_') === 0) { 
                    $question_id = str_replace('question_', '', $key);
                    $option_id = str_replace('option_', '', $value);
    
                    $quiz_answers = new QuizAnswer();
                    $quiz_answers->question_id = $question_id;
                    $quiz_answers->option_id = $option_id;
                    $quiz_answers->user_id = $user_id;
                    $quiz_answers->save();
    
                    $answers[$question_id] = $option_id;
                }
            }
            
            $this->add_attempt($inputs, $answers, $id, $user_id);
           
            return redirect()->route('user.dashboard')->with('success', 'Quiz Submitted');
        } else {
            return redirect()->route('user.dasboard')->with('failed', 'Failed to store quiz, max participants have been reached');
        }

    }

    private function add_attempt($inputs, $answers, $event_id, $user_id)
    {
        $quiz_attempt = new QuizAttempt();
        $quiz_attempt->event_id = $event_id;
        $quiz_attempt->user_id = $user_id;
        $quiz_attempt->start = $inputs['start_time'];
        $quiz_attempt->end = $inputs['end_time'];

        $value = 0;
        foreach ($answers as $question => $option) {
            $row = QuizOption::findOrFail($option);
            $score = $row->score;
            $value += $score;
        }

        $event = Event::findOrFail($event_id);
        $point = $event->point;

        // Calculate the final score
        $correct_answer = count($answers) > 0 ? ($value / count($answers)) : 0;
        $final_score = $correct_answer * $point;
        $quiz_attempt->score = $final_score;
        $quiz_attempt->save();

        //save score to event progress and category progress        
        $event_progress = new EventProgress();
        $event_progress->user_id = $user_id;
        $event_progress->event_id = $event_id;
        $event_progress->progress = $value / count($answers);
        $event_progress->score = $final_score;
        $event_progress->save();

        $category_id = Event::find($event_id)->category_id;
        $category_progress = CategoryProgress::where('user_id', $user_id)->where('category_id', $category_id)->first();
        $category_progress->user_id = $user_id;
        $category_progress->category_id = $category_id;
        $category_progress->score = $category_progress->score + $final_score;
        $category_progress->save();
    }

}
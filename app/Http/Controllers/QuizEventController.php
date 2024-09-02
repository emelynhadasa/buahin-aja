<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryProgress;
use App\Models\Event;
use App\Models\EventProgress;
use App\Models\Progress;
use App\Models\User;
use App\Models\Quiz\QuizAttempt;
use App\Models\Quiz\QuizEvent;
use App\Models\Quiz\QuizOption;
use App\Models\Quiz\QuizQuestion;
use Illuminate\Http\Request;

class QuizEventController extends Controller
{
    //
    public function index($id)
    {
        $event = event::find($id);
        $event->load('questions');

        $quiz_questions = QuizQuestion::where('event_id', $id)->get();
        $quiz_questions->load('options');

        $quiz_event = QuizEvent::where('event_id', $id)->first();

        $all_options = collect();
        foreach ($quiz_questions as $question) {
            $quiz_options = QuizOption::where('question_id', $question->id)->get();
            $all_options = $all_options->merge($quiz_options);
        }

        return view('admin.quiz.index', [
            'event' => $event,
            'quiz_questions' => $quiz_questions,
            'all_options' => $all_options,
            'quiz_event' => $quiz_event,
        ]);
    }

    public function question($id)
    {
        $event = Event::findOrFail($id);
        $questions = QuizQuestion::all();
        return view('admin.quiz.question', ['event' => $event, 'questions' => $questions]);
    }

    public function option($id)
    {
        $event = event::find($id);
        $quiz_questions = QuizQuestion::where('event_id', $id)->get();
        return view('admin.quiz.option', [
            'event' => $event,
            'quiz_questions' => $quiz_questions,
        ]);
    }

    public function edit($id)
    {
        $event = event::find($id);
        $event->load('questions');

        $quiz_questions = QuizQuestion::where('event_id', $id)->get();
        $quiz_questions->load('options');

        $quiz_event = QuizEvent::where('event_id', $id)->first();

        $all_options = collect();
        foreach ($quiz_questions as $question) {
            $quiz_options = QuizOption::where('question_id', $question->id)->get();
            $all_options = $all_options->merge($quiz_options);
        }

        return view('admin.quiz.edit', [
            'event' => $event,
            'quiz_questions' => $quiz_questions,
            'all_options' => $all_options,
            'quiz_event' => $quiz_event,
        ]);
    }

    public function store_options(Request $request)
    {
        $questions = $request->input('questions');

        foreach ($questions as $question_id => $question_data) {
            foreach ($question_data['options'] as $option) {
                QuizOption::Create(
                    [
                        'option' => $option['text'],
                        'score' => $option['is_answer'],
                        'question_id' => $question_id,
                    ]
                );
            }
        }
        return redirect()->route('admin.events')->with('success', 'Quiz created successfully');
    }

    public function store_questions(Request $request)
    {
        $validatedData = $request->validate([
            'event_id' => 'required|integer',
            'quiz_name' => 'required|string',
            'duration' => 'required|integer',
        ]);

        $event = Event::findOrFail($validatedData['event_id']);

        $quizEvent = new QuizEvent();
        $quizEvent->event_id = $validatedData['event_id'];
        $quizEvent->quiz_name = $validatedData['quiz_name'];
        $quizEvent->duration = $validatedData['duration'];
        $quizEvent->save();

        $questions = $request->input('questions');

        foreach ($questions as $order => $question) {
            QuizQuestion::create([
                'event_id' => $validatedData['event_id'],
                'question' => $question['text'],
                'order' => $order,
            ]);
        }
        return redirect()->route('admin.quiz-events', $event)->with('success', 'Successfully added');
    }

    public function update(Request $request, $id)
    {

        $quiz_event = QuizEvent::where('event_id', $id)->first();
        $quiz_event->quiz_name = $request->input('quiz_name');
        $quiz_event->duration = $request->input('duration');
        $quiz_event->save();

        $questions = $request->input('questions');
        foreach ($questions as $questions_id => $question) {
            $question_row = QuizQuestion::find($questions_id);
            if ($question_row && $question_row->event_id == $id) {
                $question_row->question = $question['question'];
                $question_row->save();

                $option_row = QuizOption::where('question_id', $questions_id)->get();
                foreach ($option_row as $option_question_id => $option) {
                    $row = $question['options'][$option_question_id];
                    $option->option = $row['text'];
                    $option->score = (int)$row['is_answer'];
                    $option->save();
                }
            } else {
                return redirect()->route('admin.quiz-events', $id)->with('failed', 'Failed to recognize event id');
            }
        }
        return redirect()->route('admin.quiz-events', $id)->with('success', 'Questions and Options are updated');
    }

    public function delete($id)
    {
        $attempt = QuizAttempt::where('event_id', $id)->get();

        if ($attempt->count() > 0) {
            return redirect()->route('admin.quiz-events', $id)->with('failed', 'Cant delete event, already have participants joined');
        } else {
            $quiz = QuizEvent::where('event_id', $id)->first();
            $quiz->delete();
            $questions = QuizQuestion::where('event_id', $id)->get();
            foreach ($questions as $question) {
                $options = QuizOption::where('question_id', $question->id)->get();
                foreach ($options as $option) {
                    $option->delete();
                }
                $question->delete();
            }
            return redirect()->route('admin.quiz-events', $id)->with('success', 'Successfully deleted questions and options');
        }
    }

    public function post_start_attempt($event_id, $student_id)
    {
        $user = User::where('student_id', $student_id)->first();

        $quiz = QuizEvent::where('event_id', $event_id)->first();

        try {
            $quiz_attempt = new QuizAttempt();
            $quiz_attempt->user_id = $user->id;
            $quiz_attempt->event_id = $event_id;
            $quiz_attempt->score = 0;
            $quiz_attempt->start = now()->format('Y-m-d H:i:s');
            $quiz_attempt->end = now()->addMinutes($quiz->duration)->format('Y-m-d H:i:s');
            $quiz_attempt->save();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json(['error' => 'You have finished this quiz, no further attempts allowed'], 500);
            } else {
                return response()->json(['error' => 'An error occurred'], 500);
            }
        }

        $quiz_questions = QuizQuestion::where('event_id', $event_id)->get();

        foreach ($quiz_questions as $question) {
            $questionOptions = QuizOption::where('question_id', $question->id)
                ->select('id', 'option')
                ->get();
            $question->options = $questionOptions;
        }

        return response()->json([
            'questions' => $quiz_questions
        ]);
    }

    public function post_finish_attempt(Request $request, $event_id, $student_id)
    {
        // Calculate Score
        $answers = $request->json()->all();

        // Retrieve questions with their correct options
        $questions = QuizQuestion::where('event_id', $event_id)
            ->with(['options' => function ($query) {
                $query->where('score', 1);
            }])
            ->get();

        if ($questions->isEmpty()) {
            return response()->json([
                'message' => 'Questions not found.'
            ], 404);
        }

        // Extract the IDs of the quiz options with a score of 1
        $quiz_options = $questions->flatMap(function ($question) {
            return $question->options->pluck('id');
        })->toArray();

        // Calculate correct answers
        $correct_answers = array_intersect($quiz_options, $answers);
        $correct_count = count($correct_answers);
        $total_questions = $questions->count();

        // Calculate current score and progress
        $current_score = $correct_count * 100 / $total_questions;
        $current_progress = $correct_count * 100 / $total_questions;

        // Find user, event progress, and category progress
        $user = User::where('student_id', $student_id)->first();
        $event_progress = EventProgress::where('user_id', $user->id)->where('event_id', $event_id)->first();
        $category_id = Event::find($event_id)->category_id;
        $category_progress = CategoryProgress::where('user_id', $user->id)->where('category_id', $category_id)->first();

        // Update progress if current score is higher
        if ($event_progress->score < $current_score) {
            $category_progress->score = $category_progress->score + ($current_score - $event_progress->score);
            $event_progress->score = $current_score;
            $event_progress->progress = $current_progress;
            $category_progress->save();
            $event_progress->save();
        }

        // Update attempt in quiz_attempt
        $attempt = QuizAttempt::where('user_id', $user->id)->where('event_id', $event_id)->first();
        $attempt->score = $current_score;
        $attempt->save();

        return response()->json([
            'score' => $current_score,
        ]);
    }
}

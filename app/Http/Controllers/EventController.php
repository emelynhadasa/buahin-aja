<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\EventProgress;
use App\Models\EventRequirement;
use App\Models\Major;
use App\Models\Quiz\QuizAnswer;
use App\Models\Quiz\QuizAttempt;
use App\Models\Quiz\QuizEvent;
use App\Models\Quiz\QuizOption;
use App\Models\Quiz\QuizQuestion;
use App\Models\Type;
use App\Models\SubmissionAnswer;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $events->load('type');
        $events->load('category');
        return view('admin.event.index', ['events' => $events]);
    }

    public function create()
    {
        $types = Type::all();
        $categories = Category::all();
        $batches = Batch::all();
        $majors = Major::all();
        $types = Type::all();
        return view('admin.event.create', [
            'categories' => $categories,
            'batches' => $batches,
            'majors' => $majors,
            'types' => $types,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category' => 'required|integer', // Should be integer, not string
            'name' => 'required|string|max:255',
            'point' => 'required|integer',
            'target' => 'required|integer',
            'max_participants' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|integer',
            'requirements' => 'required|array',
            'requirements.batch' => 'required|array',
            'requirements.major' => 'required|array',
            'requirements.batch.*' => 'required|array',
            'requirements.major.*' => 'required|array',
            'requirements.batch.*.0' => 'required|exists:batches,id',
            'requirements.major.*.0' => 'required|exists:majors,id',
            'requirements.cat_req' => 'required|exists:categories,id',
            'cat_score' => 'required|integer',
            'description' => 'required|string',
            'image' => 'required|image|max:5120', // 5MB
        ]);

        $event = new Event();
        $event->category_id = (int)$validatedData['category'];
        $event->name = $validatedData['name'];
        $event->point = $validatedData['point'];
        $event->target = $validatedData['target'];
        $event->max_participants = $validatedData['max_participants'];
        $event->start = $validatedData['start_date'];
        $event->end = $validatedData['end_date'];
        $event->type_id = $validatedData['type'];
        $event->description = $validatedData['description'];

        // Store the image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('events', $fileName, 'public');
            $image_path = '/storage/' . $path;
            $validatedData['image'] = $image_path;
        }

        $event->image = $validatedData['image'];
        $event->save();

        $batches = $validatedData['requirements']['batch'];
        $majors = $validatedData['requirements']['major'];
        // Save event requirement
        foreach ($batches as $batch) {
            foreach ($majors as $major) {
                if ($batch !== null || $major !== null) {
                    $event->eventRequirements()->create([
                        'event_id' => $event->id,
                        'batch_id' => $batch[0],
                        'major_id' => $major[0],
                        'category_id' => $validatedData['requirements']['cat_req'],
                        'category_score' => $validatedData['cat_score'],
                    ]);
                }
            }
        }
        return redirect()->route('admin.events')->with('success', 'Event created successfully');
    }

    public function show(Event $event)
    {
        $attempt = QuizAttempt::where('event_id', $event->id)->first();
        $event->load('batches');
        $event->load('category');
        $event->load('majors');
        $event->load('type');
        return view('admin.event.show', compact('event', 'attempt'));
    }

    public function showType1(Event $event)
    {
        $quiz_attempts = QuizAttempt::where('event_id', $event->id)->get();
        $quiz_attempts->load('user');
        return view('admin.event.type1.showType1', compact('event', 'quiz_attempts'));
    }

    public function showAnswer(Event $event, User $user)
    {
        $attempt = QuizAttempt::where('event_id', $event->id)->where('user_id', $user->id)->first();
        $event->load('category');
        if ($event->type_id == 1) {
            $quiz_event = QuizEvent::findOrFail($event->id);
            $questions = QuizQuestion::where('event_id', $event->id)->get();
            
            // collect all answers using question_id
            $answers = QuizAnswer::whereIn('question_id', $questions->pluck('id'))->get();
            $answers->load('questions');
            $answers->load('options');

            $options = QuizOption::whereIn('question_id', $questions->pluck('id'))->get()->groupBy('question_id'); 

            return view('admin.event.type1.showAnswer', compact('user', 'quiz_event', 'attempt', 'answers', 'options', 'event'));
        }
    }

    public function showType2(Event $event)
    {
        $event->load(['submissionAnswers.student', 'category', 'majors', 'batches', 'type']);
    
        return view('admin.event.showType2', compact('event'));
    }    

    // for user/student's name data in showType2
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function saveScore(Request $request, $submissionId)
    {
        $submission = SubmissionAnswer::find($submissionId);
        $event = Event::find($submission->event_id);
    
        $request->validate([
            'score' => 'required|integer|max:' . $event->target,
        ]);
    
        if ($submission) {
            $submission->score = $request->score;
            $submission->last_updated = now();
            $submission->save();
            return back()->with('success', 'Score saved successfully.');
        }
    
        return back()->with('error', 'Submission not found.');
    }
    
    public function autoScore(Request $request, Event $event)
    {
        $maxScore = $event->target;

        foreach ($event->submissionAnswers as $submission) {
            $submission->score = $maxScore;
            $submission->last_updated = now();
            $submission->save();
        }

        return back()->with('success', 'All submissions scored successfully.');
    }

    public function edit(Event $event)
    {
        $batches = Batch::all();
        $categories = Category::all();
        $majors = Major::all();
        $types = Type::all();
        $score = EventRequirement::where('event_id', $event->id)->value('category_score');

        $event->load('batches');
        $event->load('majors');

        return view('admin.event.edit', [
            'event' => $event,
            'categories' => $categories,
            'types' => $types,
            'score' => $score,
            'batches' => $batches,
            'majors' => $majors,
        ]);
    }

    public function delete(Event $event)
    {
        $imagePath = str_replace('/storage/', 'public', $event->image);
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        if ($event->exists) {
            $event_requirements = EventRequirement::where('event_id', $event->id)->first();
            $event_requirements->delete();
            $event->delete();
            return redirect()->route('admin.events')->with('success', 'Event deleted successfully');
        } else {
            return redirect()->route('admin.events')->with('error', 'Event does not exist');
        }
    }

    public function update(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'category' => 'required|integer', 
            'name' => 'required|string|max:255',
            'point' => 'required|integer',
            'target' => 'required|integer',
            'max_participants' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|integer',
            'requirements' => 'required|array',
            'requirements.batch' => 'required|array',
            'requirements.major' => 'required|array',
            'requirements.batch.*' => 'required|array',
            'requirements.major.*' => 'required|array',
            'requirements.batch.*.0' => 'required|exists:batches,id',
            'requirements.major.*.0' => 'required|exists:majors,id',
            'requirements.cat_req' => 'required|exists:categories,id',
            'cat_score' => 'required|integer',
            'description' => 'required|string',
            'image' => 'image|max:5120', // 5MB
        ]);

        if ($request->hasFile('image')) {
            $currentImagePath = str_replace('/storage/', 'public/', $event->image);
            if (Storage::exists($currentImagePath)) {
                Storage::delete($currentImagePath);
            }

            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('events', $fileName, 'public');
            $image_path = '/storage/' . $path;
            $validatedData['image'] = $image_path;
        } else {
            $validatedData['image'] = $event->image;
        }

        $event->category_id = $validatedData['category'];
        $event->name = $validatedData['name'];
        $event->point = $validatedData['point'];
        $event->target = $validatedData['target'];
        $event->max_participants = $validatedData['max_participants'];
        $event->start = $validatedData['start_date'];
        $event->end = $validatedData['end_date'];
        $event->type_id = $validatedData['type'];
        $event->description = $validatedData['description'];
        $event->save();

        $eventRequirements = EventRequirement::where('event_id', $event->id)->get();
        $batches = $validatedData['requirements']['batch'];
        $majors = $validatedData['requirements']['major'];
        $category_id = $validatedData['requirements']['cat_req'];
        $category_score = $validatedData['cat_score'];

        foreach ($batches as $batch) {
            foreach ($majors as $major) {
                $eventRequirement = $eventRequirements->firstWhere('batch_id', $batch[0])->firstWhere('major_id', $major[0]);

                if ($eventRequirement) {
                    // Update existing requirement
                    $eventRequirement->category_id = $category_id;
                    $eventRequirement->category_score = $category_score;
                    $eventRequirement->save();
                } else {
                    // Create new requirement
                    EventRequirement::create([
                        'event_id' => $event->id,
                        'batch_id' => $batch[0],
                        'major_id' => $major[0],
                        'category_id' => $category_id,
                        'category_score' => $category_score,
                    ]);
                }
            }
        }

        return redirect()->route('admin.events.show', ['event' => $event])->with('success', 'Event updated successfully');
    }

    public function get_new($student_id)
    {
        $user = User::where('student_id', $student_id)->first();

        $events = Event::select('events.id', 'events.name', 'events.description', 'events.image', 'events.type_id', 'events.category_id', 'categories.name as category_name')
            ->join('event_requirements', 'events.id', '=', 'event_requirements.event_id')
            ->join('users', function ($join) use ($user) {
                $join->on('users.major_id', '=', 'event_requirements.major_id')
                    ->on('users.batch_id', '=', 'event_requirements.batch_id')
                    ->where('users.id', '=', $user->id);
            })
            ->join('category_progress', function ($join) {
                $join->on('users.id', '=', 'category_progress.user_id')
                    ->on('event_requirements.category_id', '=', 'category_progress.category_id');
            })
            ->join("categories", function ($join) {
                $join->on('categories.id', '=', 'events.category_id');
            })
            ->where('category_progress.score', '>=', 'event_requirements.category_score')
            ->whereNotIn('events.id', function ($query) use ($user) {
                $query->select('event_id')
                    ->from('event_progress')
                    ->where('user_id', '=', $user->id);
            })
            ->distinct()
            ->get();

        return response()->json($events);
    }

    public function join_event($event_id, $student_id) {
        $user = User::where('student_id', $student_id)->first();
        $event = Event::find($event_id)->first();

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        $eventRequirement = EventRequirement::where('event_id', $event_id)
            ->where('batch_id', $user->batch_id)
            ->where('major_id', $user->major_id)
            ->first();

        if (!$eventRequirement) {
            return response()->json(['error' => 'You are not eligible to join this event'], 403);
        }

        try {
            $eventProgress = EventProgress::create([
                'user_id' => $user->id,
                'event_id' => $event_id,
                'progress' => 0,
                'score' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            if ($e->getCode() === '23000') {
                return response()->json(['error' => 'Event has already been joined!'], 409);
            } else {
                return response()->json(['error' => 'An error occurred'], 500);
            }
        }

        return response()->json(
            [
                'message' => 'Event joined successfully',
                'success' => true
            ]
        );
    }

    public function get_progressed($student_id)
    {
        $user = User::where('student_id', $student_id)->first();

        $events = Event::select('events.id', 'events.name', 'events.description', 'events.image', 'events.type_id', 'event_progress.progress', 'events.target', 'events.category_id', 'categories.name as category_name')
            ->join('event_progress', 'events.id', '=', 'event_progress.event_id')
            ->join('categories', function ($join) {
                $join->on('categories.id', '=', 'events.category_id');
            })
            ->where('event_progress.user_id', $user->id)
            ->get();

        return response()->json($events);
    }

    public function get_event($event_id, $student_id)
    {
        $user = User::where('student_id', $student_id)->first();

        $event = Event::select('*')
            ->join('category_progress', 'events.category_id', '=', 'category_progress.category_id')
            ->join('event_requirements', 'events.id', '=', 'event_requirements.event_id')
            ->where('events.id', $event_id)
            ->where('category_progress.user_id', $user->id)
            ->first();

        return response()->json([
            'id' => $event->id,
            'category_id' => $event->category_id,
            'name' => $event->name,
            'point' => $event->point,
            'target' => $event->target,
            'max_participants' => $event->max_participants,
            'start' => $event->start,
            'end' => $event->end,
            'type_id' => $event->type_id,
            'description' => $event->description,
            'image' => $event->image,
            'created_at' => $event->created_at,
            'updated_at' => $event->updated_at,
            'is_eligible' => ($event->category_score <= $event->score),
        ]);
    }
}

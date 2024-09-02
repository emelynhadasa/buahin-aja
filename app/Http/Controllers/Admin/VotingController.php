<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Voting;
use App\Models\VotingVotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VotingController extends Controller
{
    public function index()
    {
        $votings = Voting::all();

        return view('admin.voting.index', ['votings' => $votings]);
    }

    public function create()
    {
        $events = Event::query()
            // ->where('type_id', '3')
            ->select(['id', 'name'])
            ->get();


        return view('admin.voting.create', ['events' => $events]);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = Validator::make($request->all(), [
            'event_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|max:5120', // 5MB
        ]);


        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $valid = $validatedData->validated();

        // Store the uploaded image if it exists
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('voting', $fileName, 'public');

            $image_path = '/storage/' . $path;

            // Append the storage path to the validated data
            $valid['image_url'] = $image_path;
        }

        if (is_null($valid['image_url'] ?? null)) {
            return redirect()->back()->withErrors(['image' => 'Image is required'])->withInput();
        }


        // Create a new voting record in the database
        $voting = new Voting();
        $voting->event_id = $valid['event_id'];
        $voting->title = $valid['title'];
        $voting->description = $valid['description'];
        $voting->image_url = $valid['image_url'];
        $voting->save();

        return redirect()->route('admin.voting');
    }

    public function update(int $voteId, Request $request)
    {
        $voting = Voting::find($voteId);

        if (!$voting) {
            return redirect()->route('admin.voting');
        }

        $validatedData = Validator::make($request->all(), [
            'event_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|max:5120', // 5MB
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $valid = $validatedData->validated();

        // Store the uploaded image if it exists
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('voting', $fileName, 'public');

            $image_path = '/storage/' . $path;

            // Append the storage path to the validated data
            $valid['image_url'] = $image_path;
        }

        $voting->event_id = $valid['event_id'];
        $voting->title = $valid['title'];
        $voting->description = $valid['description'];
        if (isset($valid['image_url']) && $valid['image_url'] != null) {
            $voting->image_url = $valid['image_url'];
        }
        $voting->save();

        return redirect()->route('admin.voting');
    }

    public function show(int $id, Request $request)
    {
        $voting = Voting::find($id);
        $events = Event::query()
            // ->where('type_id', '3')
            ->select(['id', 'name'])
            ->get();

        $options = $voting->options;

        $students = User::query()
            ->select(['id', 'first_name', 'last_name'])
            ->get();

        return view('admin.voting.show', ['voting' => $voting, 'events' => $events, 'options' => $options, 'students' => $students]);
    }


    public function delete(int $voteId)
    {
        $voting = Voting::find($voteId);

        if (!$voting) {
            return redirect()->route('admin.voting');
        }

        //if has image delete it
        if ($voting->image_url) {
            $currentImagePath = str_replace('/storage/', 'public/', $voting->image_url);
            if (!is_null($currentImagePath) && Storage::exists($currentImagePath)) {
                Storage::delete($currentImagePath);
            }
        }

        $votingOptions = $voting->options;

        foreach ($votingOptions as $option) {
            if ($option->image_url) {
                $currentImagePath = str_replace('/storage/', 'public/', $option->image_url);
                if (!is_null($currentImagePath) && Storage::exists($currentImagePath)) {
                    Storage::delete($currentImagePath);
                }
            }
        }

        $voting->delete();

        return redirect()->route('admin.voting');
    }

    public function get_latest_voting()
    {
        //query params
        $studentId = request()->query('student_id');
        $voting = Voting::latest()->first();
        if (!$voting) {
            return response()->json([]);
        }
        //also join voting options
        $voting->options;
        if ($studentId) {
            $user = User::query()->where('student_id', $studentId)->first();
            if (!$user) {
                return response()->json(['success' => false, "message" => 'Student not found']);
            }
            foreach ($voting->options as $option) {
                $userVote = VotingVotes::query()
                    ->where('student_id', $user->id)
                    ->where('voting_option_id', $option->id)
                    ->where('voting_id', $voting->id)
                    ->first();
                $option->voted = $userVote ? true : false;
            }
        }

        return response()->json($voting);
    }

    public function user_vote_option()
    {
        $validatedData = Validator::make(request()->all(), [
            'voting_id' => 'required',
            'option_id' => 'required',
            'student_id' => 'required',
        ]);


        if ($validatedData->fails()) {
            return response()->json(['success' => false, "message" => 'Validation failed']);
        }

        $votingId = request()->voting_id;
        $optionId = request()->option_id;
        $studentId = request()->student_id;

        $voting = Voting::find($votingId);
        if (!$voting) {
            return response()->json(['success' => false, "message" => 'Voting not found']);
        }

        $option = $voting->options->find($optionId);
        if (!$option) {
            return response()->json(['success' => false, "message" => 'Option not found']);
        }

        $student = User::query()->where('student_id', $studentId)->first();
        if (!$student) {
            return response()->json(['success' => false, "message" => 'Student not found']);
        }

        if ($voting->votes()->where('student_id', $student->id)->exists()) {
            return response()->json(['success' => false, "message" => 'You have already voted']);
        }

        $voting->votes()->create([
            'student_id' => $student->id,
            'voting_option_id' => $optionId,
            'voting_id' => $votingId,
        ]);

        return response()->json(['success' => true, "message" => 'Success voting']);
    }

    public function get_votings()
    {
        $votings = Voting::all();
        return response()->json(['success' => true, 'data' => $votings]);
    }

    public function show_voting(int $id)
    {
        $voting = Voting::query()->where('id', $id)->first();
        if (!$voting) {
            return response()->json(['success' => false, 'message' => 'Voting not found']);
        }
        $options = $voting->options;
        return response()->json(['success' => true, 'message' => 'Voting Found', 'data' => $voting]);
    }
}

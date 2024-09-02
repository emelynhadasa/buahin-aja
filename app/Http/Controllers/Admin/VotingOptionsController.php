<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voting;
use App\Models\VotingOptions;
use App\Models\VotingVotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VotingOptionsController extends Controller
{
    public function create(int $voteId, Request $request)
    {
        $voting = Voting::query()
            ->where('id', $voteId)
            ->select(['id'])
            ->first();

        if (!$voting) {
            return redirect()->route('admin.voting.index');
        }

        return view('admin.voting.options.create', ['voting' => $voting]);
    }

    public function store(int $voteId, Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'text' => 'required',
            'image' => 'nullable|image|max:5120', // 5MB
        ]);

        // Store the uploaded image if it exists
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('voting/options', $fileName, 'public');

            $image_path = '/storage/' . $path;

            // Append the storage path to the validated data
            $validatedData['image_url'] = $image_path;
        }

        $voting = Voting::query()
            ->where('id', $voteId)
            ->select(['id'])
            ->first();

        if (!$voting) {
            return redirect()->back()->withErrors(['voting' => 'Voting ID is required'])->withInput();
        }

        // Create a new voting option record in the database
        $votingOption = new VotingOptions();
        $votingOption->text = $validatedData['text']; // Accessing the 'text' key from $validatedData
        // Check if the 'image' key exists before assigning
        $votingOption->image_url = isset($validatedData['image_url']) ? $validatedData['image_url'] : null;
        $votingOption->voting_id = $voteId;
        $votingOption->save();

        return redirect()->route('admin.voting.show', $voteId);
    }

    public function show(int $voteId, int $optionId)
    {
        $voting = Voting::query()
            ->where('id', $voteId)
            ->select(['id'])
            ->first();

        if (!$voting) {
            return redirect()->route('admin.voting.index');
        }

        $votingOption = VotingOptions::query()
            ->where('id', $optionId)
            ->where('voting_id', $voteId)
            ->first();

        if (!$votingOption) {
            return redirect()->route('admin.voting.show', $voteId);
        }

        $votes = $votingOption->votes;

        return view('admin.voting.options.show', ['option' => $votingOption, "voting" => $voting, "votes" => $votes]);
    }

    public function update(int $voteId, int $optionId, Request $request)
    {
        $voting = Voting::query()
            ->where('id', $voteId)
            ->select(['id'])
            ->first();

        if (!$voting) {
            return redirect()->route('admin.voting.index');
        }

        $votingOption = VotingOptions::query()
            ->where('id', $optionId)
            ->where('voting_id', $voteId)
            ->select(['id', 'image_url'])
            ->first();

        if (!$votingOption) {
            return redirect()->route('admin.voting.show', $voteId);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'text' => 'required',
            'image' => 'nullable|image|max:5120', // 5MB
        ]);



        // Store the uploaded image if it exists
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $currentImagePath = str_replace('/storage/', 'public/', $votingOption->image_url);
            if (!is_null($currentImagePath) && Storage::exists($currentImagePath)) {
                Storage::delete($currentImagePath);
            }

            $fileName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('voting/options', $fileName, 'public');

            $image_path = '/storage/' . $path;

            // Append the storage path to the validated data
            $validatedData['image_url'] = $image_path;
        }

        // Update the voting option record in the database
        $votingOption->text = $validatedData['text']; // Accessing the 'text' key from $validatedData
        // Check if the 'image' key exists before assigning
        if (isset($validatedData['image_url'])) {
            $votingOption->image_url = $validatedData['image_url'];
        }
        $votingOption->save();

        return redirect()->route('admin.voting.show', $voteId);
    }


    public function delete(int $voteId, int $optionId)
    {
        $voting = Voting::query()
            ->where('id', $voteId)
            ->select(['id'])
            ->first();

        if (!$voting) {
            return redirect()->route('admin.voting.index');
        }

        $votingOption = VotingOptions::query()
            ->where('id', $optionId)
            ->where('voting_id', $voteId)
            ->select(['id', 'image_url'])
            ->first();

        if (!$votingOption) {
            return redirect()->route('admin.voting.show', $voteId);
        }

        if ($votingOption->image_url) {
            $currentImagePath = str_replace('/storage/', 'public/', $votingOption->image_url);
            if (!is_null($currentImagePath) && Storage::exists($currentImagePath)) {
                Storage::delete($currentImagePath);
            }
        }

        $votingOption->delete();

        return redirect()->route('admin.voting.show', $voteId);
    }


    public function vote(int $voteId, int $optionId, Request $request)
    {
        $validate = $request->validate([
            'student_id' => 'required',
        ]);

        $voting = Voting::query()
            ->where('id', $voteId)
            ->select(['id'])
            ->first();

        if (!$voting) {
            return redirect()->route('admin.voting.index');
        }

        $votingOption = VotingOptions::query()
            ->where('id', $optionId)
            ->where('voting_id', $voteId)
            ->select(['id'])
            ->first();

        if (!$votingOption) {
            return redirect()->route('admin.voting.show', $voteId);
        }

        $isUserVoted = VotingVotes::query()
            ->where('voting_id', $voteId)
            ->where('student_id', $validate['student_id'])
            ->exists();

        if ($isUserVoted) {
            return redirect()->route('admin.voting.show', $voteId)->withErrors(['voted' => 'User already voted']);
        }

        $vote = new VotingVotes();
        $vote->student_id = $validate['student_id'];
        $vote->voting_option_id = $optionId;
        $vote->voting_id = $voteId;
        $vote->save();

        return redirect()->route('admin.voting.show', $voteId);
    }

    public function vote_delete(int $voteId, int $optionId, Request $request)
    {

        $validate = $request->validate([
            'vote_id' => 'required',
        ]);

        $voting = Voting::query()
            ->where('id', $voteId)
            ->select(['id'])
            ->first();

        if (!$voting) {
            return redirect()->route('admin.voting.index');
        }

        $votingOption = VotingOptions::query()
            ->where('id', $optionId)
            ->where('voting_id', $voteId)
            ->select(['id'])
            ->first();

        if (!$votingOption) {
            return redirect()->route('admin.voting.show', $voteId);
        }

        $vote = VotingVotes::query()
            ->where('id', $validate['vote_id'])
            ->where('voting_id', $voteId)
            ->delete();

        return redirect()->route('admin.voting.options.show', [$voteId, $optionId]);
    }
}

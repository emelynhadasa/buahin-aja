<?php

namespace App\Http\Controllers;

use App\Models\SubmissionEvent;
use App\Models\Event;
use Illuminate\Http\Request;

class SubmissionEventController extends Controller
{
    public function index($eventId)
    {
        $event = Event::findOrFail($eventId);
        $submissionEvents = SubmissionEvent::where('event_id', $eventId)->get();

        return view('admin.submission.index', compact('event', 'submissionEvents'));
    }

    public function create($eventId)
    {
        $event = Event::findOrFail($eventId);

        return view('admin.submission.create', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        $request->validate([
            'submission_name' => 'required|string|max:255',
            'file_type' => 'required|string|max:255',
            'file_size' => 'required|integer',
            'desc' => 'required|string|max:255',
        ]);

        SubmissionEvent::create([
            'event_id' => $eventId,
            'submission_name' => $request->submission_name,
            'file_type' => $request->file_type,
            'file_size' => $request->file_size,
            'desc' => $request->desc,
        ]);

        return redirect()->route('admin.submission-events', $eventId);
    }

    public function edit($eventId, SubmissionEvent $submissionEvent)
    {
        $event = Event::findOrFail($eventId);

        return view('admin.submission.edit', compact('event', 'submissionEvent'));
    }

    public function update(Request $request, $eventId, SubmissionEvent $submissionEvent)
    {
        $request->validate([
            'submission_name' => 'required|string|max:255',
            'file_type' => 'required|string|max:255',
            'file_size' => 'required|integer',
            'desc' => 'required|string|max:255',
        ]);

        $submissionEvent->update([
            'submission_name' => $request->submission_name,
            'file_type' => $request->file_type,
            'file_size' => $request->file_size,
            'desc' => $request->desc,
        ]);

        return redirect()->route('admin.submission-events', $eventId);
    }

    public function delete($eventId, SubmissionEvent $submissionEvent)
    {
        $submissionEvent->delete();

        return redirect()->route('admin.submission-events', $eventId);
    }

    public function get_submission_event($submission_event_id, $student_id)
    {
        $user = User::where('student_id', $student_id)->first();

        $submission_event = SubmissionEvent::select('*')
            ->where('id', $submission_event_id)
            ->first();

        return response()->json([
            'id' => $submission_event->id,
            'event_id' => $submission_event->event_id,
            'submission_name' => $submission_event->submission_name,
            'file_type' => $submission_event->file_type,
            'file_size' => $submission_event->file_size,
            'desc' => $submission_event->desc,
            'created_at' => $submission_event->created_at,
            'updated_at' => $submission_event->updated_at,
        ]);
    }
}

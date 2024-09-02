<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SubmissionAnswer;
use App\Models\SubmissionEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubmissionController extends Controller
{

    public function create(String $event_id, String $student_id, Request $request)
    {
        $validate = Validator::make($request->all(), [
            'submission' => 'required|file',
        ]);

        if ($validate->fails()) {
            return response()->json(['success' => false, "message" => 'Validation failed']);
        }

        $student = User::where('student_id', $student_id)->first();
        if (!$student) {
            return response()->json(['success' => false, "message" => 'Student not found']);
        }

        $event = Event::find($event_id);

        if (!$event) {
            return response()->json(['success' => false, "message" => 'Event not found']);
        }

        $submissionAnswer = SubmissionAnswer::where('event_id', $event_id)
            ->where('student_id', $student->id)
            ->first();

        if ($submissionAnswer) {
            return response()->json(['success' => false, "message" => 'Submission already exists']);
        }

        if ($request->hasFile('submission')) {
            $submission = $request->file('submission');
            $fileName = time() . '_' . $submission->getClientOriginalName();
            $path = $submission->storeAs('submission', $fileName, 'public');

            $filePath = '/storage/' . $path;

            // Append the storage path to the validated data
            $validatedData['file_link'] = $filePath;
        }

        $submission = new SubmissionAnswer();
        $submission->student_id = $student->id;
        $submission->event_id = $event_id;
        $submission->notes = $request->notes;
        $submission->file_link = $validatedData['file_link'];
        $submission->score = 0;
        $submission->last_updated = now();

        $submission->save();

        return response()->json(['success' => true, "message" => 'Success submitting event']);
    }

    public function get(String $event_id)
    {
        $student_id = request()->query('student_id');





        $submission = SubmissionEvent::where('submission_events.event_id', $event_id)
            ->join('events', 'submission_events.event_id', '=', 'events.id')
            ->select(
                "events.image as event_image",
                "submission_events.submission_name",
                "submission_events.file_type",
                "submission_events.desc",
                "submission_events.file_size"
            )
            ->first();

        $response = [
            'submission' => $submission,
        ];

        if ($student_id != null) {
            $student = User::where('student_id', $student_id)->first();


            $user_submission = SubmissionAnswer::where('event_id', $event_id)
                ->where('student_id', $student->id)
                ->first();

            if ($user_submission) {
                $response['user_submission'] = $user_submission;
            }
        }



        return response()->json([
            "success" => true,
            "message" => "Submission fetched successfully",
            "data" => $response
        ]);
    }
}

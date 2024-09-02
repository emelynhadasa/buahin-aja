<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Batch;
use App\Models\User;
use App\Models\Major;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all();

        return view('admin.messages.index', compact('messages'));
    }

    public function create()
    {
        $users = User::all(); 
        $batches = Batch::all();
        $students = User::select('student_id')->distinct()->get(); 
        $majors = Major::all();
        $currentUser = auth()->user();
        $currentUserName = $currentUser->first_name . ' ' . $currentUser->last_name;
        return view('admin.messages.create', compact('users', 'batches', 'students', 'majors', 'currentUserName'));
    }     

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'sender' => 'required|string',
            'to_batch' => 'nullable|array',
            'to_batch.*' => 'string',
            'to_major' => 'nullable|array',
            'to_major.*' => 'string',
            'to_student' => 'nullable|array',  
            'to_student.*' => 'string',        
        ]);
    
        $batches = $request->to_batch ?? [];
        $majors = $request->to_major ?? [];
        $students = $request->to_student ?? [];
    
        // Iterate over each combination of batch, major, and student ID
        foreach ($batches as $batch) {
            foreach ($majors as $major) {
                foreach ($students as $student) {
                    $message = new Message();
                    $message->title = $request->title;
                    $message->content = $request->content;
                    $message->sender = $request->sender;
                    $message->to_batch = $batch;
                    $message->to_major = $major;
                    $message->to_student = $student;
                    $message->save();
                }
            }
        }
    
        return redirect()->route('admin.messages')->with('success', 'Message sent successfully!');
    }        
}
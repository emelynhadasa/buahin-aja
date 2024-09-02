<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{


    public function sync_students(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'studentId' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'batch' => 'required',
            'major' => 'required',
            'birth_date' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['success' => false, "message" => 'Validation failed']);
        }

        $findUser = User::query()->where('student_id', $request->studentId)->first();
        if ($findUser) {
            return response()->json(['success' => false, "message" => 'Student already exists']);
        }

        $user = new User();
        $user->student_id = $request->studentId;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->batch = $request->batch;
        $user->major = $request->major;
        $user->password = bcrypt($request->studentId);
        $user->date_of_birth = date('Y-m-d', strtotime($request->birth_date));
        $user->save();

        return response()->json(['success' => true, "message" => 'Success syncing students']);
    }
}

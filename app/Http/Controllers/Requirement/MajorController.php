<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    //
     public function index()
    {
        $majors = Major::all();
        return view('admin.major.index', ['majors' => $majors]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $major = new major();
        $major->name = $validatedData['name'];
        $major->save();

        return redirect()->route('admin.majors')->with('success', 'major added');
    }

    public function edit(major $major)
    {
        return view('admin.major.edit', ['major' => $major]);
    }

    public function delete(major $major)
    {
        if ($major->exists){
            $major->delete();
            return redirect()->route('admin.majors')->with('success', 'major deleted successfully');
        } else {
            return redirect()->route('admin.majors')->with('success', 'Failed to delete major');
        }
    }

    public function update (Request $request ,major $major)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $major->name = $validatedData['name'];
        $major->save();

        return redirect()->route('admin.majors')->with('success', 'major updated');
    }
}

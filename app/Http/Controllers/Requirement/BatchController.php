<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    //
     public function index()
    {
        $batches = Batch::all();
        return view('admin.batch.index', ['batches' => $batches]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $batch = new Batch();
        $batch->name = $validatedData['name'];
        $batch->save();

        return redirect()->route('admin.batches')->with('success', 'Batch added');
    }

    public function edit(Batch $batch)
    {
        return view('admin.batch.edit', ['batch' => $batch]);
    }

    public function delete(Batch $batch)
    {
        if ($batch->exists){
            $batch->delete();
            return redirect()->route('admin.batches')->with('success', 'Batch deleted successfully');
        } else {
            return redirect()->route('admin.batches')->with('success', 'Failed to delete Batch');
        }
    }

    public function update (Request $request ,Batch $batch)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $batch->name = $validatedData['name'];
        $batch->save();

        return redirect()->route('admin.batches')->with('success', 'Batch updated');
    }
}

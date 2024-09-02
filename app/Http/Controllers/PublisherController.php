<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::all();
        return view('admin.publishers.index', ['publishers' => $publishers]);
    }

    public function create()
    {
        return view('admin.publishers.create');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'short_name' => 'required',
            'long_name' => 'required',
        ]);

        // Create a new avatar record in the database
        $publisher = new Publisher();
        $publisher->short_name = $validatedData['short_name'];
        $publisher->long_name = $validatedData['long_name'];
        $publisher->save();

        // Redirect or return a response
        return redirect()->route('admin.publishers')->with('success', 'Publisher created successfully.');
    }

    public function edit(Publisher $publisher)
    {
        return view('admin.publishers.edit', ['publisher' => $publisher]);
    }

    public function update(Request $request, Publisher $publisher)
    {
        Log::info($request->all());
        Log::info($publisher);

        // Validate the form data
        $validatedData = $request->validate([
            'short_name' => 'required',
            'long_name' => 'required',
        ]);

        Log::info($validatedData);

        // Update the avatar record in the database
        $publisher->short_name = $validatedData['short_name'];
        $publisher->long_name = $validatedData['long_name'];
        $publisher->save();

        // Redirect or return a response
        return redirect()->route('admin.publishers')->with('success', 'Publisher updated successfully.');
    }

    public function destroy(Publisher $publisher)
    {
        Log::info($publisher);
        if ($publisher->exists) {
            $publisher->delete();
            return redirect()->route('admin.publishers')->with('success', 'Publisher deleted successfully.');
        } else {
            return redirect()->route('admin.publishers')->with('error', 'Publisher does not exist.');
        }
    }
}

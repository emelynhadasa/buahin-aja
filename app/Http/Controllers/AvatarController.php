<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avatars = Avatar::all();
        return view('admin.avatar.index', ['avatars' => $avatars]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.avatar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|max:255',
            'image' => 'required|image|max:5120', // 5MB
        ]);

        // Store the uploaded image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Ensuring the image has a unique name
            $fileName = time() . '_' . $image->getClientOriginalName();
            // Store the image at the 'avatars' directory
            $path = $image->storeAs('avatars', $fileName, 'public');

            $image_path = '/storage/' . $path;

            // Append the storage path to the validated data
            $validatedData['image'] = $image_path;
        }

        // Create a new avatar record in the database
        $avatar = new Avatar();
        $avatar->name = $validatedData['name'];
        $avatar->type = $validatedData['type'];
        $avatar->image = $validatedData['image'];
        $avatar->save();

        // Redirect or return a response
        return redirect()->route('admin.avatars')->with('success', 'Avatar created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Avatar $avatar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Avatar $avatar)
    {
        return view('admin.avatar.edit', ['avatar' => $avatar]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Avatar $avatar)
    {
        Log::info($request->all());
        Log::info($avatar);

        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|max:255',
            'image' => 'image|max:5120', // 5MB
        ]);

        Log::info($validatedData);

        // Store the uploaded image
        if ($request->hasFile('image')) {
            $currentImagePath = str_replace('/storage/', 'public/', $avatar->image);
            // Check if the file exists
            if (Storage::exists($currentImagePath)) {
                // Attempt to delete the file
                Storage::delete($currentImagePath);
            } 

            $image = $request->file('image');
            // Ensuring the image has a unique name
            $fileName = time() . '_' . $image->getClientOriginalName();
            // Store the image at the 'avatars' directory
            $path = $image->storeAs('avatars', $fileName, 'public');
            $image_path = '/storage/' . $path;
            // Append the storage path to the validated data
            $validatedData['image'] = $image_path;
        } else {
            $validatedData['image'] = $avatar->image;
        }

        // Update the avatar record in the database
        $avatar->name = $validatedData['name'];
        $avatar->type = $validatedData['type'];
        $avatar->image = $validatedData['image'];
        $avatar->save();

        // Redirect or return a response
        return redirect()->route('admin.avatars')->with('success', 'Avatar updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Avatar $avatar)
    {
        Log::info($avatar);
        $imagePath = str_replace('/storage/', 'public/', $avatar->image);
        // Check if the file exists
        if (Storage::exists($imagePath)) {
            // Attempt to delete the file
            Storage::delete($imagePath);
        }
    
        if ($avatar->exists) {
            $avatar->delete();
            return redirect()->route('admin.avatars')->with('success', 'Avatar deleted successfully.');
        } else {
            return redirect()->route('admin.avatars')->with('error', 'Avatar does not exist.');
        }
    }
}

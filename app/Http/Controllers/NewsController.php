<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('admin.news.index', ['news' => $news]);
    }

    public function create()
    {
        $publishers = Publisher::all(); // Assuming Publisher is your model for the publishers table
        return view('admin.news.create', ['publishers' => $publishers]);
    }

    public function store(Request $request) 
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
            'publisher' => 'required',
            'publish_date' => 'required|date',
            'image' => 'nullable|image|max:5120', // 5MB
            'order_number' => 'required|integer',
            'status' => 'required|in:active,expired',
        ]);
    
        // Store the uploaded image if it exists
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('news', $fileName, 'public');
    
            $image_path = '/storage/' . $path;
    
            // Append the storage path to the validated data
            $validatedData['image'] = $image_path;
        }
    
        // Create a new news record in the database
        $news = new News();
        $news->title = $validatedData['title'];
        $news->type = $validatedData['type'];
        $news->description = $validatedData['description'];
        $news->publisher = $validatedData['publisher'];
        $news->publish_date = $validatedData['publish_date'];
        $news->image = $validatedData['image'] ?? null;
        $news->order_number = $validatedData['order_number'];
        $news->status = $validatedData['status'];
        $news->save();
    
        return redirect()->route('admin.news')->with('success', 'News created successfully.');
    }        

    public function show(News $news)
    {
        //
    }

    public function edit(News $news)
    {
        $publishers = Publisher::all(); 
        return view('admin.news.edit', ['news' => $news, 'publishers' => $publishers]);
    }

    public function update(Request $request, News $news)
    {
        Log::info($request->all());
        Log::info($news);

        // Validate the form data
        $validatedData = $request->validate([
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
            'publisher' => 'required',
            'publish_date' => 'required|date',
            'image' => 'nullable|image|max:5120', // 5MB
            'order_number' => 'required|integer',
            'status' => 'required|in:active,expired',
        ]);

        Log::info($validatedData);

        // Store the uploaded image
        if ($request->hasFile('image')) {
            $currentImagePath = str_replace('/storage/', 'public/', $news->image);
            // Check if the file exists
            if (Storage::exists($currentImagePath)) {
                // Attempt to delete the file
                Storage::delete($currentImagePath);
            } 

            $image = $request->file('image');
            // Ensuring the image has a unique name
            $fileName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('news', $fileName, 'public');
            $image_path = '/storage/' . $path;
            // Append the storage path to the validated data
            $validatedData['image'] = $image_path;
        } else {
            $validatedData['image'] = $news->image;
        }

        $news->title = $validatedData['title'];
        $news->type = $validatedData['type'];
        $news->description = $validatedData['description'];
        $news->publisher = $validatedData['publisher'];
        $news->publish_date = $validatedData['publish_date'];
        $news->image = $validatedData['image'];
        $news->order_number = $validatedData['order_number'];
        $news->status = $validatedData['status'];
        $news->save();

        // Redirect or return a response
        return redirect()->route('admin.news')->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        Log::info($news);
        $imagePath = str_replace('/storage/', 'public/', $news->image);
        // Check if the file exists
        if (Storage::exists($imagePath)) {
            // Attempt to delete the file
            Storage::delete($imagePath);
        }
    
        if ($news->exists) {
            $news->delete();
            return redirect()->route('admin.news')->with('success', 'News deleted successfully.');
        } else {
            return redirect()->route('admin.news')->with('error', 'News does not exist.');
        }
    }

    public function get()
    {
        $news = News::orderBy('publish_date', 'desc')->take(5)->get();
        return response()->json($news);
    }

    public function get_page($page)
    {
        $news = News::orderBy('publish_date', 'desc')->paginate(5, ['*'], 'page', $page);
        return response()->json($news);
    }

    public function welcome_page()
    {
        $news = News::orderBy('publish_date')->get();
        return view('welcome', ['news' => $news]);
    }
}

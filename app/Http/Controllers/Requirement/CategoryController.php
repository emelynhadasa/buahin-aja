<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $category = new Category();
        $category->name = $validatedData['name'];
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'category added');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', ['category' => $category]);
    }

    public function delete(Category $category)
    {
        if ($category->exists){
            $category->delete();
            return redirect()->route('admin.categories')->with('success', 'category deleted successfully');
        } else {
            return redirect()->route('admin.categories')->with('success', 'Failed to delete category');
        }
    }

    public function update (Request $request ,Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $category->name = $validatedData['name'];
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'category updated');
    }
}

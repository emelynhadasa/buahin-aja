<?php
namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
    //
    public function index()
    {
        $types = Type::all();
        return view('admin.type.index', ['types' => $types]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $type = new Type();
        $type->name = $validatedData['name'];
        $type->save();

        return redirect()->route('admin.types')->with('success', 'type added');
    }

    public function edit(Type $type)
    {
        return view('admin.type.edit', ['type' => $type]);
    }

    public function delete(Type $type)
    {
        if ($type->exists){
            $type->delete();
            return redirect()->route('admin.types')->with('success', 'type deleted successfully');
        } else {
            return redirect()->route('admin.types')->with('success', 'Failed to delete type');
        }
    }

    public function update (Request $request ,type $type)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $type->name = $validatedData['name'];
        $type->save();

        return redirect()->route('admin.types')->with('success', 'type updated');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use App\Models\ProfessionRequirement;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profession $profession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profession $profession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profession $profession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profession $profession)
    {
        //
    }

    public function get(String $category_id)
    {
        $professions = Profession::with(['requirements.category'])
            ->whereHas('requirements', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            })
            ->get();

        $responseData = $professions->map(function ($profession) {
            return [
                'id' => $profession->id,
                'name' => $profession->name,
                'requirements' => $profession->requirements->map(function ($requirement) {
                    return [
                        'id' => $requirement->id,
                        'category_id' => $requirement->category_id,
                        'score' => $requirement->score,
                        'category_name' => $requirement->category->name,
                    ];
                }),
            ];
        });

        if ($professions->first()) {
            return response()->json([
                'professions' => $responseData
            ]);
        } else {
            return response()->json([
                'message' => 'Professions not found.'
            ], 404);
        }
    }
}

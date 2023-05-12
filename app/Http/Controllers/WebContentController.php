<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebContent;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Book;

class WebContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $webContent = WebContent::all();
        return view('webcontent',compact('webContent'));
    }

    public function getAllData(){

        $webContent = WebContent::all();
        $experiences = Experience::all();
        $projects = Project::all();
        $skills = Skill::all();
        $books = Book::all();

        return response()->json([
            'webContent' => $webContent,
            'experiences' => $experiences,
            'skills' => $skills,
            'projects' => $projects,
            'books' => $books
        ]);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $webContent = WebContent::findOrFail($id);
        $validatedData = $request->validate([
            'content_es'=> 'required|string',
            'content_en'=> 'required|string',
        ], [
            'content_es.required' => 'El contenido en español es requerido.',
            'content_en.required' => 'El contenido en ingles es requerido.',
        ]);

        try {
            $webContent->update($validatedData);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while updating the reasons Section. Please try again.']);
        }

        return redirect()->back()->with('success', 'Contenido actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

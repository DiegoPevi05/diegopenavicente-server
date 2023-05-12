<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills       = Skill::all();
        return view('skill', compact('skills'));
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
        $skill = new Skill;

        $validatedData = $request->validate([
            'title'=> 'required|string|max:255',
            'description_es' => 'required|string',
            'description_en'=> 'required|string',
            'description_it'=> 'required|string'
        ], [
            'title.required' => 'El nombre de la habilidad es requerido.',
            'description_es.required' => 'El contenido en español es requerido.',
            'description_en.required' => 'El contenido en ingles es requerido.',
            'description_it.required' => 'El contenido en italiano es requerido.'
        ]);


        $fileName = '';
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $extension = $file->extension();
            $fileName = 'skills_'.time().'.' .$extension;
            $destinationPath = public_path().'/images/skills';
            $file->move($destinationPath,$fileName);
        }

        $keywords = [];
        // validate if the field is not empty and is a string
        if (!empty($request->keywords) && is_string($request->keywords)) {

            $keywords_raw = explode('|', $request->keywords);

            foreach ($keywords_raw as $bullet) {
                $bullet = trim($bullet);
                if (!empty($bullet) && is_string($bullet)) {
                    $keywords[] = $bullet;
                }
            }
        }

        $skill->keywords                = json_encode($keywords);
        $skill->title                   = $request->title;
        $skill->description_es          = $request->description_es;
        $skill->description_en          = $request->description_en;
        $skill->description_it          = $request->description_it;


        if($fileName != ''){
           $skill->image = '/images/skills/'. $fileName;
        }


        try {
            $skill->save();
        } catch (\Exception $e) {
            error_log('Some message here.');
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while creating the news. Please try again.']);
        }

        return redirect()->back()->with('success', 'Skill is created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
        $skill = Skill::findOrFail($id);

        $validatedData = $request->validate([
            'title'=> 'required|string|max:255',
            'description_es' => 'required|string',
            'description_en'=> 'required|string',
            'description_it'=> 'required|string'
        ], [
            'title.required' => 'El nombre de la habilidad es requerido.',
            'description_es.required' => 'El contenido en español es requerido.',
            'description_en.required' => 'El contenido en ingles es requerido.',
            'description_it.required' => 'El contenido en italiano es requerido.'
        ]);


        $imagePath = public_path($skill->image);

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $fileName = '';
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $extension = $file->extension();
            $fileName = 'skills_'.time().'.' .$extension;
            $destinationPath = public_path().'/images/skills';
            $file->move($destinationPath,$fileName);
        }

        $keywords = [];
        // validate if the field is not empty and is a string
        if (!empty($request->keywords) && is_string($request->keywords)) {

            $keywords_raw = explode('|', $request->keywords);

            foreach ($keywords_raw as $bullet) {
                $bullet = trim($bullet);
                if (!empty($bullet) && is_string($bullet)) {
                    $keywords[] = $bullet;
                }
            }
        }

        $skill->keywords                = json_encode($keywords);
        $skill->title                   = $request->title;
        $skill->description_es          = $request->description_es;
        $skill->description_en          = $request->description_en;
        $skill->description_it          = $request->description_it;


        if($fileName != ''){
           $skill->image = '/images/skills/'. $fileName;
        }


        try {
            $skill->save();
        } catch (\Exception $e) {
            error_log('Some message here.');
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while creating the news. Please try again.']);
        }

        return redirect()->back()->with('success', 'Skill is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $skill=Skill::findorFail($id);
        $imagePath = public_path($skill->image);

        try {

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $skill->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while deleting the News Section. Please try again.']);
        }

        return redirect()->back()->with('success', 'Skill deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects       = Project::all();
        return view('project', compact('projects'));
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
        $project = new Project;

        $validatedData = $request->validate([
            'project'=> 'required|string|max:255',
            'description_es' => 'required|string',
            'description_en'=> 'required|string',
            'description_it'=> 'required|string',
            'link'=> 'required|string'
        ], [
            'project.required' => 'El nombre del proyecto es requerido.',
            'description_es.required' => 'El contenido en español es requerido.',
            'description_en.required' => 'El contenido en ingles es requerido.',
            'description_it.required' => 'El contenido en italiano es requerido.',
            'link.required' => 'El enlace es necesario.'
        ]);


        $fileName = '';
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $file = $request->file('logo');
            $extension = $file->extension();
            $fileName = 'projects_'.time().'.' .$extension;
            $destinationPath = public_path().'/images/projects';
            $file->move($destinationPath,$fileName);
        }

        $languages = [];
        // validate if the field is not empty and is a string
        if (!empty($request->languages) && is_string($request->languages)) {

            $languages_raw = explode('|', $request->languages);

            foreach ($languages_raw as $bullet) {
                $bullet = trim($bullet);
                if (!empty($bullet) && is_string($bullet)) {
                    $languages[] = $bullet;
                }
            }
        }

        $project->languages               = json_encode($languages);
        $project->project                 = $request->project;
        $project->description_es          = $request->description_es;
        $project->description_en          = $request->description_en;
        $project->description_it          = $request->description_it;
        $project->link                    = $request->link;


        if($fileName != ''){
           $project->logo = '/images/projects/'. $fileName;
        }


        try {
            $project->save();
        } catch (\Exception $e) {
            error_log('Some message here.');
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while creating the news. Please try again.']);
        }

        return redirect()->back()->with('success', 'Project is created successfully.');
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

        $project = Project::findOrFail($id);

        $validatedData = $request->validate([
            'project'=> 'required|string|max:255',
            'description_es' => 'required|string',
            'description_en'=> 'required|string',
            'description_it'=> 'required|string',
            'link'=> 'required|string'
        ], [
            'project.required' => 'El nombre del proyecto es requerido.',
            'description_es.required' => 'El contenido en español es requerido.',
            'description_en.required' => 'El contenido en ingles es requerido.',
            'description_it.required' => 'El contenido en italiano es requerido.',
            'link.required' => 'El enlace es necesario.'
        ]);

        $imagePath = public_path($project->logo);

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }


        $fileName = '';
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $file = $request->file('logo');
            $extension = $file->extension();
            $fileName = 'projects_'.time().'.' .$extension;
            $destinationPath = public_path().'/images/projects';
            $file->move($destinationPath,$fileName);
        }

        $languages = [];
        // validate if the field is not empty and is a string
        if (!empty($request->languages) && is_string($request->languages)) {

            $languages_raw = explode('|', $request->languages);

            foreach ($languages_raw as $bullet) {
                $bullet = trim($bullet);
                if (!empty($bullet) && is_string($bullet)) {
                    $languages[] = $bullet;
                }
            }
        }

        $project->languages               = json_encode($languages);
        $project->project                 = $request->project;
        $project->description_es          = $request->description_es;
        $project->description_en          = $request->description_en;
        $project->description_it          = $request->description_it;
        $project->link                    = $request->link;


        if($fileName != ''){
           $project->logo = '/images/projects/'. $fileName;
        }


        try {
            $project->save();
        } catch (\Exception $e) {
            error_log('Some message here.');
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while creating the news. Please try again.']);
        }

        return redirect()->back()->with('success', 'Project is created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project=Project::findorFail($id);
        $imagePath = public_path($project->logo);

        try {

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $project->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while deleting the News Section. Please try again.']);
        }

        return redirect()->back()->with('success', 'Project deleted successfully.');
    }
}

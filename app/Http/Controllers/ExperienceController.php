<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experience;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $experiences       = Experience::all();
        return view('experience', compact('experiences'));
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
        $experience = new Experience;


        $validatedData = $request->validate([
            'job_es'=> 'required|string|max:255',
            'job_en' => 'required|string|max:255',
            'job_it' => 'required|string|max:255',
            'company'=> 'required|string|max:255',
            'details_es' => 'required|string',
            'details_en'=> 'required|string',
            'details_it' => 'required|string'
        ], [

            'job_es.required' => 'La Trabajo en español es requerido.',
            'job_en.required' => 'El Trabajo en ingles es requerido.',
            'job_it.required' => 'El Trabajo en italiano es requerido.',
            'company.required' => 'La compañia contenido es requerido.',
            'details_es.required' => 'El contenido en español es requerido.',
            'details_en.required' => 'El contenido en ingles es requerido.',
            'details_it.required' => 'El contenido en italiano  es requerido.',

            'title_es.max' => 'El numero de caracteres no debe ser superior  :max characters.',
            'title_en.max' => 'El numero de caracteres no debe ser superior a  :max characters.'
        ]);


        $destinationPath = public_path().'/images/experiences' ;

        $fileName1 = '';
        if ($request->hasFile('image1') && $request->file('image1')->isValid()) {
            $file1 = $request->file('image1');
            $extension1 = $file1->extension();
            $fileName1 = 'experience_'.strtotime('+1 second').'.' .$extension1;
            $file1->move($destinationPath,$fileName1);
        }

        $fileName2 = '';
        if ($request->hasFile('image2') && $request->file('image2')->isValid()) {
            $file2 = $request->file('image2');
            $extension2 = $file2->extension();
            $fileName2 = 'experience_'.strtotime('+2 second').'.' .$extension2;
            $file2->move($destinationPath,$fileName2);
        }

        $fileName3 = '';
        if ($request->hasFile('image3') && $request->file('image3')->isValid()) {
            $file3 = $request->file('image3');
            $extension3 = $file3->extension();
            $fileName3 = 'experience_'.strtotime('+3 second').'.' .$extension3;
            $file3->move($destinationPath,$fileName3);
        }

        $fileName4 = '';
        if ($request->hasFile('image4') && $request->file('image4')->isValid()) {
            $file4 = $request->file('image4');
            $extension4 = $file4->extension();
            $fileName4 = 'experience_'.strtotime('+4 second').'.' .$extension4;
            $file4->move($destinationPath,$fileName4);
        }


        $experience->job_es               = $request->job_es;
        $experience->job_en               = $request->job_en;
        $experience->job_it               = $request->job_it;
        $experience->company              = $request->company;
        $experience->details_es           = $request->details_es;
        $experience->details_en           = $request->details_en;
        $experience->details_it           = $request->details_it;
        $experience->startDate            = $request->startDate;
        $experience->endDate              = $request->endDate;

        if($fileName1 != ''){
            $experience->image1                  = '/images/experiences/'. $fileName1;
        }

        if($fileName2 != ''){
            $experience->image2                  = '/images/experiences/'. $fileName2;
        }

        if($fileName3 != ''){
            $experience->image3                  = '/images/experiences/'. $fileName3;
        }

        if($fileName4 != ''){
            $experience->image4                  = '/images/experiences/'. $fileName4;
        }


        try {
            $experience->save();
        } catch (\Exception $e) {
            error_log('Some message here.');
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while creating the experience. Please try again.']);
        }

        return redirect()->back()->with('success', 'Experience is created successfully.');
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
        $experience = Experience::findOrFail($id);


        $validatedData = $request->validate([
            'job_es'=> 'required|string|max:255',
            'job_en' => 'required|string|max:255',
            'job_it' => 'required|string|max:255',
            'company'=> 'required|string|max:255',
            'details_es' => 'required|string',
            'details_en'=> 'required|string',
            'details_it' => 'required|string'
        ], [

            'job_es.required' => 'La Trabajo en español es requerido.',
            'job_en.required' => 'El Trabajo en ingles es requerido.',
            'job_it.required' => 'El Trabajo en italiano es requerido.',
            'company.required' => 'La compañia contenido es requerido.',
            'details_es.required' => 'El contenido en español es requerido.',
            'details_en.required' => 'El contenido en ingles es requerido.',
            'details_it.required' => 'El contenido en italiano  es requerido.',

            'title_es.max' => 'El numero de caracteres no debe ser superior  :max characters.',
            'title_en.max' => 'El numero de caracteres no debe ser superior a  :max characters.'
        ]);

        $imagePath1 = public_path($experience->image1);
        $imagePath2 = public_path($experience->image2);
        $imagePath3 = public_path($experience->image3);
        $imagePath4 = public_path($experience->image4);

        if (file_exists($imagePath1)) {
            unlink($imagePath1);
        }

        if (file_exists($imagePath2)) {
            unlink($imagePath2);
        }

        if (file_exists($imagePath3)) {
            unlink($imagePath4);
        }

        if (file_exists($imagePath4)) {
            unlink($imagePath4);
        }


        $destinationPath = public_path().'/images/experiences' ;

        $fileName1 = '';
        if ($request->hasFile('image1') && $request->file('image1')->isValid()) {
            $file1 = $request->file('image1');
            $extension1 = $file1->extension();
            $fileName1 = 'experience_'.strtotime('+1 second').'.' .$extension1;
            $file1->move($destinationPath,$fileName1);
        }

        $fileName2 = '';
        if ($request->hasFile('image2') && $request->file('image2')->isValid()) {
            $file2 = $request->file('image2');
            $extension2 = $file2->extension();
            $fileName2 = 'experience_'.strtotime('+2 second').'.' .$extension2;
            $file2->move($destinationPath,$fileName2);
        }

        $fileName3 = '';
        if ($request->hasFile('image3') && $request->file('image3')->isValid()) {
            $file3 = $request->file('image3');
            $extension3 = $file3->extension();
            $fileName3 = 'experience_'.strtotime('+3 second').'.' .$extension3;
            $file3->move($destinationPath,$fileName3);
        }

        $fileName4 = '';
        if ($request->hasFile('image4') && $request->file('image4')->isValid()) {
            $file4 = $request->file('image4');
            $extension4 = $file4->extension();
            $fileName4 = 'experience_'.strtotime('+4 second').'.' .$extension4;
            $file4->move($destinationPath,$fileName4);
        }


        $experience->job_es               = $request->job_es;
        $experience->job_en               = $request->job_en;
        $experience->job_it               = $request->job_it;
        $experience->company              = $request->company;
        $experience->details_es           = $request->details_es;
        $experience->details_en           = $request->details_en;
        $experience->details_it           = $request->details_it;
        $experience->startDate            = $request->startDate;
        $experience->endDate              = $request->endDate;

        if($fileName1 != ''){
            $experience->image1                  = '/images/experiences/'. $fileName1;
        }

        if($fileName2 != ''){
            $experience->image2                  = '/images/experiences/'. $fileName2;
        }

        if($fileName3 != ''){
            $experience->image3                  = '/images/experiences/'. $fileName3;
        }

        if($fileName4 != ''){
            $experience->image4                  = '/images/experiences/'. $fileName4;
        }

        try {
            $experience->save();
        } catch (\Exception $e) {
            error_log('Some message here.');
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while creating the experiences. Please try again.']);
        }

        return redirect()->back()->with('success', 'Experience is created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $experience=Experience::findorFail($id);
        $imagePath1 = public_path($experience->image1);
        $imagePath2 = public_path($experience->image2);
        $imagePath3 = public_path($experience->image3);
        $imagePath4 = public_path($experience->image4);

        try {

            if (file_exists($imagePath1)) {
                unlink($imagePath1);
            }

            if (file_exists($imagePath2)) {
                unlink($imagePath2);
            }

            if (file_exists($imagePath3)) {
                unlink($imagePath4);
            }

            if (file_exists($imagePath4)) {
                unlink($imagePath4);
            }
            $experience->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while deleting the News Section. Please try again.']);
        }

        return redirect()->back()->with('success', 'Experience deleted successfully.');
    }
}

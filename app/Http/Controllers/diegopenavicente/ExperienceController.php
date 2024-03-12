<?php

namespace App\Http\Controllers\diegopenavicente;

use App\Http\Controllers\Controller;
use App\Services\LogService;
use Illuminate\Http\Request;
use App\Models\diegopenavicente\Experience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ExperienceController extends Controller
{
    public $routeName = 'experiences';
    public $label = 'Experiencias';
    public $icon;
    protected $package;
    protected $imageRepository;
    protected $logService;

    
    public function __construct()
    {
        $this->icon = Storage::get('images/experience.svg');

        $this->middleware(function ($request, $next) {
            $this->logService = app(LogService::class);
            $this->package = auth()->user()->package;
            $this->imageRepository = '/images/' . $this->package . '/experiences/';
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve only verified users with pagination
        $experiencesQuery = Experience::query();

        // Check if the name search parameter is provided
        $company = $request->query('company');
        if ($company) {
            // Apply the name filter to the query
            $experiencesQuery->where('company', 'like', '%' . $company . '%');
        }

        // Paginate the categories
        $experiences = $experiencesQuery->paginate(10);

        // Decode the details
        $experiences->map(function ($experience) {
            $experience->details_es = explode('|', $experience->details_es);
            $experience->details_en = explode('|', $experience->details_en);
            $experience->details_it = explode('|', $experience->details_it);
            $experience->startDate  = date('Y-m-d', strtotime($experience->startDate));
            $experience->endDate  = date('Y-m-d', strtotime($experience->endDate));
            return $experience;
        });

        Log::info($experiences);

        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $experiences->lastPage())) {
            return redirect()->route('experiences.index');
        }

        $searchParam = $company ? $company : '';

        // Return a view or JSON response as desired
        return view($this->package . '.experiences.index', compact('experiences', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view($this->package . '.experiences.create')->with('editMode', false);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'job_es'=> 'required|string|max:255',
            'job_en' => 'required|string|max:255',
            'job_it' => 'required|string|max:255',
            'company'=> 'required|string|max:255',
            'details_es' => 'required|array|min:1',
            'details_es.*'=> 'required|string|max:255',
            'details_en'=> 'required|array|min:1',
            'details_en.*'=> 'required|string|max:255',
            'details_it'=> 'required|array|min:1',
            'details_it.*'=> 'required|string|max:255',
            'startDate'=> 'required|date',
            'endDate'=> 'required|date',
            'is_active' => 'nullable',
            'image1' => 'required|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'image4' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
        ], [
            'job_es.required' => 'El Trabajo en español es requerido.',
            'job_en.required' => 'El Trabajo en ingles es requerido.',
            'job_it.required' => 'El Trabajo en italiano es requerido.',
            'company.required' => 'La compañia contenido es requerido.',
            'details_es.required' => 'El contenido en español es requerido.',
            'details_es.min' => 'El contenido en español es requerido.',
            'details_es.*.required' => 'El contenido en español es requerido.',
            'details_es.*.max' => 'El contenido en español es requerido.',
            'details_en.required' => 'El contenido en ingles es requerido.',
            'details_en.min' => 'El contenido en ingles es requerido.',
            'details_en.*.required' => 'El contenido en ingles es requerido.',
            'details_en.*.max' => 'El contenido en ingles es requerido.',
            'details_it.required' => 'El contenido en italiano es requerido.',
            'details_it.min' => 'El contenido en italiano es requerido.',
            'details_it.*.required' => 'El contenido en italiano es requerido.',
            'details_it.*.max' => 'El contenido en italiano es requerido.',
            'startDate.required' => 'La fecha de inicio es requerida.',
            'endDate.required' => 'La fecha de finalización es requerida.',
            'image1.required' => 'La imagen 1 es requerida.',
            'image1.image' => 'El archivo 1 debe ser una imagen.',
            'image2.image' => 'El archivo 2 debe ser una imagen.',
            'image3.image' => 'El archivo 3 debe ser una imagen.',
            'image4.image' => 'El archivo 4 debe ser una imagen.',
            'image1.mimes' => 'El archivo 1 debe ser de tipo: jpeg, jpg, png, webp, avif.',
            'image2.mimes' => 'El archivo 2 debe ser de tipo: jpeg, jpg, png, webp, avif.',
            'image3.mimes' => 'El archivo 3 debe ser de tipo: jpeg, jpg, png, webp, avif.',
            'image4.mimes' => 'El archivo 4 debe ser de tipo: jpeg, jpg, png, webp, avif.',
            'image1.max' => 'El tamaño máximo del archivo 1 es 2MB.',
            'image2.max' => 'El tamaño máximo del archivo 2 es 2MB.',
            'image3.max' => 'El tamaño máximo del archivo 3 es 2MB.',
            'image4.max' => 'El tamaño máximo del archivo 4 es 2MB.'
        ]);

        $destinationPath = public_path() . $this->imageRepository;
        $imageFileName = [];
        //make a fourlop to upload the four images
        for ($i=1; $i <= 4; $i++) {
            $imageFileName[$i] = null;
            if ($request->hasFile('image'.$i) && $request->file('image'.$i)->isValid()) {
                $file = $request->file('image'.$i);
                $extension = $file->extension();
                $fileName = 'experience_'.$i . '_' . time() .'.' .$extension;
                $file->move($destinationPath,$fileName);
                $imageFileName[$i] = $fileName;
            }
        }

        $is_active = isset($validatedData['is_active']) && $validatedData['is_active'] ? true : false;

        $experience = Experience::create([
            'job_es' => $validatedData['job_es'],
            'job_en' => $validatedData['job_en'],
            'job_it' => $validatedData['job_it'],
            'company' => $validatedData['company'],
            'details_es' => implode('|', $validatedData['details_es']),
            'details_en' => implode('|', $validatedData['details_en']),
            'details_it' => implode('|', $validatedData['details_it']),
            'startDate' => $validatedData['startDate'],
            'endDate' => $validatedData['endDate'],
            'is_active' => $is_active,
            'image1' => $imageFileName[1] ? $this->imageRepository . $imageFileName[1] : null,
            'image2' => $imageFileName[2] ? $this->imageRepository . $imageFileName[2] : null,
            'image3' => $imageFileName[3] ? $this->imageRepository . $imageFileName[3] : null,
            'image4' => $imageFileName[4] ? $this->imageRepository . $imageFileName[4] : null,
        ]);

        $return_message = 'Experiencia creada exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route('experiences.index')->with('logSuccess', $return_message);
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
    public function edit(Experience $experience)
    {
        $experience->startDate  = date('Y-m-d', strtotime($experience->startDate));
        $experience->endDate  = date('Y-m-d', strtotime($experience->endDate));

        return view($this->package . '.experiences.edit', compact('experience'))->with('editMode', true);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Experience $experience)
    {
        $validatedData = $request->validate([
            'job_es'=> 'required|string|max:255',
            'job_en' => 'required|string|max:255',
            'job_it' => 'required|string|max:255',
            'company'=> 'required|string|max:255',
            'details_es' => 'required|array|min:1',
            'details_es.*'=> 'required|string|max:255',
            'details_en'=> 'required|array|min:1',
            'details_en.*'=> 'required|string|max:255',
            'details_it'=> 'required|array|min:1',
            'details_it.*'=> 'required|string|max:255',
            'startDate'=> 'required|date',
            'endDate'=> 'required|date',
            'is_active' => 'nullable',
            'image1' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'image4' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
        ], [
            'job_es.required' => 'El Trabajo en español es requerido.',
            'job_en.required' => 'El Trabajo en ingles es requerido.',
            'job_it.required' => 'El Trabajo en italiano es requerido.',
            'company.required' => 'La compañia contenido es requerido.',
            'details_es.required' => 'El contenido en español es requerido.',
            'details_es.min' => 'El contenido en español es requerido.',
            'details_es.*.required' => 'El contenido en español es requerido.',
            'details_es.*.max' => 'El contenido en español es requerido.',
            'details_en.required' => 'El contenido en ingles es requerido.',
            'details_en.min' => 'El contenido en ingles es requerido.',
            'details_en.*.required' => 'El contenido en ingles es requerido.',
            'details_en.*.max' => 'El contenido en ingles es requerido.',
            'details_it.required' => 'El contenido en italiano es requerido.',
            'details_it.min' => 'El contenido en italiano es requerido.',
            'details_it.*.required' => 'El contenido en italiano es requerido.',
            'details_it.*.max' => 'El contenido en italiano es requerido.',
            'startDate.required' => 'La fecha de inicio es requerida.',
            'endDate.required' => 'La fecha de finalización es requerida.',
            'image1.image' => 'El archivo 1 debe ser una imagen.',
            'image2.image' => 'El archivo 2 debe ser una imagen.',
            'image3.image' => 'El archivo 3 debe ser una imagen.',
            'image4.image' => 'El archivo 4 debe ser una imagen.',
            'image1.mimes' => 'El archivo 1 debe ser de tipo: jpeg, jpg, png, webp, avif.',
            'image2.mimes' => 'El archivo 2 debe ser de tipo: jpeg, jpg, png, webp, avif.',
            'image3.mimes' => 'El archivo 3 debe ser de tipo: jpeg, jpg, png, webp, avif.',
            'image4.mimes' => 'El archivo 4 debe ser de tipo: jpeg, jpg, png, webp, avif.',
            'image1.max' => 'El tamaño máximo del archivo 1 es 2MB.',
            'image2.max' => 'El tamaño máximo del archivo 2 es 2MB.',
            'image3.max' => 'El tamaño máximo del archivo 3 es 2MB.',
            'image4.max' => 'El tamaño máximo del archivo 4 es 2MB.'
        ]);

        $destinationPath = public_path() . $this->imageRepository;
        $imageFileName = [];
        for($i=1; $i <= 4; $i++){
            $imageOldFilename = $experience->{'image'.$i};
            if ($request->hasFile('image'.$i) && $request->file('image'.$i)->isValid()) {
                $file = $request->file('image'.$i);
                $extension = $file->extension();
                $fileName = 'experience_'.$i . '_' . time() .'.' .$extension;
                $file->move($destinationPath,$fileName);
                $imageFileName[$i] = $fileName;

                if ($imageOldFilename !== null) {
                    $oldImagePath = public_path($imageOldFilename);
                    if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }else{
                if($experience->{'image'.$i} !== null){
                    $imageFileName[$i] = basename($experience->{'image'.$i});
                }else{
                    $imageFileName[$i] = null;
                }
            }
        }

        $is_active = isset($validatedData['is_active']) && $validatedData['is_active'] ? true : false;

        $experience->update([
            'job_es' => $validatedData['job_es'],
            'job_en' => $validatedData['job_en'],
            'job_it' => $validatedData['job_it'],
            'company' => $validatedData['company'],
            'details_es' => implode('|', $validatedData['details_es']),
            'details_en' => implode('|', $validatedData['details_en']),
            'details_it' => implode('|', $validatedData['details_it']),
            'startDate' => $validatedData['startDate'],
            'endDate' => $validatedData['endDate'],
            'is_active' => $is_active,
            'image1' => $imageFileName[1] ? $this->imageRepository . $imageFileName[1] : null,
            'image2' => $imageFileName[2] ? $this->imageRepository . $imageFileName[2] : null,
            'image3' => $imageFileName[3] ? $this->imageRepository . $imageFileName[3] : null,
            'image4' => $imageFileName[4] ? $this->imageRepository . $imageFileName[4] : null,
        ]);

        $return_message = 'Experiencia actualizada exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route('experiences.index')->with('logSuccess', $return_message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Experience $experience)
    {
        for($i=1; $i <= 4; $i++){
            $imageProfile = $experience->{'image'.$i};
            if ($imageProfile !== null) {
                $ImagePath = public_path($imageProfile);
                if (file_exists($ImagePath) && is_file($ImagePath)) {
                    unlink($ImagePath);
                }
            }
        }

        $experience->delete();

        $return_message = 'Experiencia borrado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route('experiences.index')->with('logSuccess', $return_message);
    }
}

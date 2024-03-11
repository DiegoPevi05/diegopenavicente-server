<?php

namespace App\Http\Controllers\diegopenavicente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LogService;
use App\Models\diegopenavicente\Skill;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    public $routeName = 'skills';
    public $label = 'Habilidades';
    public $icon;
    protected $package;
    protected $imageRepository;

    protected $logService;

    
    public function __construct()
    {
        $this->icon = Storage::get('images/skill.svg');

        $this->middleware(function ($request, $next) {
            $this->logService = app(LogService::class);
            $this->package = auth()->user()->package;
            $this->imageRepository = '/images/' . $this->package . '/skills/';
            return $next($request);
        });
    }
    //create a method to fetch skills
    public function SearchByTitle(Request $request)
    {
        $title = $request->query('title');
        $skills = Skill::whereRaw('title like ?', ["%$title"])
            ->select('id', 'title')
            ->limit(5)
            ->get();
        return response()->json($skills);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve only verified users with pagination
        $skillsQuery = Skill::query();

        // Check if the name search parameter is provided
        $title = $request->query('title');
        if ($title) {
            // Apply the name filter to the query
            $skillsQuery->where('title', 'like', '%' . $title . '%');
        }

        // Paginate the categories
        $skills = $skillsQuery->paginate(10);

        $skills->map(function ($skill) {
            $skill->keywords = explode('|', $skill->keywords);
            return $skill;
        });

        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $skills->lastPage())) {
            return redirect()->route('skills.index');
        }

        $searchParam = $title ? $title : '';

        // Return a view or JSON response as desired
        return view($this->package . '.skills.index', compact('skills', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view($this->package . '.skills.create')->with('editMode', false);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title'=> 'required|string|max:255',
            'image'=> 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description_es' => 'required|string',
            'description_en'=> 'required|string',
            'description_it'=> 'required|string',
            'keywords' => 'required|array',
            'keywords.*' => 'string|max:25',
        ], [
            'title.required' => 'El nombre de la habilidad es requerido.',
            'title.string' => 'El nombre de la habilidad debe ser un texto.',
            'title.max' => 'El nombre de la habilidad no debe exceder los 255 caracteres.',
            'image.required' => 'La imagen es requerida.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'El archivo debe ser una imagen con formato jpeg, png, jpg, webp.',
            'image.max' => 'El tamaño de la imagen no debe exceder los 2048 kilobytes.',
            'description_es.required' => 'El contenido en español es requerido.',
            'description_en.required' => 'El contenido en ingles es requerido.',
            'description_it.required' => 'El contenido en italiano es requerido.',
            'keywords.required' => 'Las palabras clave son requeridas.',
            'keywords.array' => 'Las palabras clave deben ser un arreglo.',
            'keywords.*.string' => 'Las palabras clave deben ser texto.',
            'keywords.*.max' => 'Las palabras clave no deben exceder los 25 caracteres.'
        ]);

        $destinationPath = public_path() . $this->imageRepository;
        $imageFileName = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $extension = $file->extension();
            $fileName = 'img_' . time() . '.' . $extension;
            $file->move($destinationPath, $fileName);
            $imageFileName = $fileName;
        }

        $skill = Skill::create([
            'title' => $validatedData['title'],
            'image' => $imageFileName ? $this->imageRepository . $imageFileName : null,
            'description_es' => $validatedData['description_es'], 
            'description_en' => $validatedData['description_en'],
            'description_it' => $validatedData['description_it'],
            'keywords' => implode('|', $validatedData['keywords'])
        ]);

        $return_message = 'Skill creada exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route('skills.index')->with('logSuccess', $return_message);
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
    public function edit(Skill $skill)
    {
        return view($this->package . '.skills.edit', compact('skill'))->with('editMode', true);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $validatedData = $request->validate([
            'title'=> 'required|string|max:255',
            'image'=> 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description_es' => 'required|string',
            'description_en'=> 'required|string',
            'description_it'=> 'required|string',
            'keywords' => 'required|array',
            'keywords.*' => 'string|max:25',
        ], [
            'title.required' => 'El nombre de la habilidad es requerido.',
            'title.string' => 'El nombre de la habilidad debe ser un texto.',
            'title.max' => 'El nombre de la habilidad no debe exceder los 255 caracteres.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'El archivo debe ser una imagen con formato jpeg, png, jpg, webp.',
            'image.max' => 'El tamaño de la imagen no debe exceder los 2048 kilobytes.',
            'description_es.required' => 'El contenido en español es requerido.',
            'description_en.required' => 'El contenido en ingles es requerido.',
            'description_it.required' => 'El contenido en italiano es requerido.',
            'keywords.required' => 'Las palabras clave son requeridas.',
            'keywords.array' => 'Las palabras clave deben ser un arreglo.',
            'keywords.*.string' => 'Las palabras clave deben ser texto.',
            'keywords.*.max' => 'Las palabras clave no deben exceder los 25 caracteres.'
        ]);

        $destinationPath = public_path() . $this->imageRepository;
        $imageOldFilename = $skill->image;
        $imageFileName = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $extension = $file->extension();
            $fileName = 'img_' . time() . '.' . $extension;
            $file->move($destinationPath, $fileName);
            $imageFileName = $fileName;

            if ($imageOldFilename !== null) {
                $oldImagePath = public_path($imageOldFilename);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }else{
            if($skill->image !== null){
                $imageFileName = basename($skill->image);
            }
        }

        $skill->update([
            'title' => $validatedData['title'],
            'image' => $imageFileName ? $this->imageRepository . $imageFileName : null,
            'description_es' => $validatedData['description_es'], 
            'description_en' => $validatedData['description_en'],
            'description_it' => $validatedData['description_it'],
            'keywords' => implode('|', $validatedData['keywords'])
        ]);

        $return_message = 'Skill actualizado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route('skills.index')->with('logSuccess', $return_message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $imageProfile = $skill->image;

        if ($imageProfile !== null) {
            $ImagePath = public_path($imageProfile);
            if (file_exists($ImagePath) && is_file($ImagePath)) {
                unlink($ImagePath);
            }
        }

        $skill->delete();

        $return_message = 'Skill borrado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route('skills.index')->with('logSuccess', $return_message);
    }
}

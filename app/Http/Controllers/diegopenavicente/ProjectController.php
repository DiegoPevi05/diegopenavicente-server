<?php

namespace App\Http\Controllers\diegopenavicente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LogService;
use App\Models\diegopenavicente\Project;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public $routeName = 'projects';
    public $label = 'Proyectos';
    public $icon;
    protected $package;
    protected $imageRepository;

    protected $logService;

    
    public function __construct()
    {
        $this->icon = Storage::get('images/project.svg');

        $this->middleware(function ($request, $next) {
            $this->logService = app(LogService::class);
            $this->package = auth()->user()->package;
            $this->imageRepository = '/images/' . $this->package . '/projects/';
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve only verified users with pagination
        $projectsQuery = Project::query();

        // Check if the name search parameter is provided
        $project = $request->query('project');
        if ($project) {
            // Apply the name filter to the query
            $projectsQuery->where('project', 'like', '%' . $project . '%');
        }

        // Paginate the categories
        $projects = $projectsQuery->paginate(10);

        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $projects->lastPage())) {
            return redirect()->route('projects.index');
        }

        $searchParam = $project ? $project : '';

        // Return a view or JSON response as desired
        return view($this->package . '.projects.index', compact('projects', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view($this->package . '.projects.create')->with('editMode', false);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project'=> 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'description_es' => 'required|string',
            'description_en'=> 'required|string',
            'description_it'=> 'required|string',
            'link'=> 'required|string',
            'github'=> 'nullable|string',
            'skills' => 'required|array|min:1',
            'skills.*' => 'required|integer|exists:skills,id',
        ], [
            'project.required' => 'El nombre del proyecto es requerido.',
            'logo.required' => 'La imagen es requerida.',
            'logo.image' => 'El archivo debe ser una imagen.',
            'logo.mimes' => 'El archivo debe ser una imagen con formato jpeg, jpg, png, webp, avif.',
            'logo.max' => 'El tamaño de la imagen no debe exceder los 2048 kilobytes.',
            'description_es.required' => 'El contenido en español es requerido.',
            'description_en.required' => 'El contenido en ingles es requerido.',
            'description_it.required' => 'El contenido en italiano es requerido.',
            'link.required' => 'El enlace es necesario.',
            'github.string' => 'El enlace de github debe ser una cadena de texto.',
            'skills.required' => 'Las habilidades son requeridas.',
            'skills.array' => 'Las habilidades deben ser un arreglo.',
            'skills.min' => 'Se requiere al menos una habilidad.',
            'skills.*.required' => 'La habilidad es requerida.',
            'skills.*.integer' => 'La habilidad debe ser un número entero.',
            'skills.*.exists' => 'La habilidad seleccionada no existe.'
        ]);

        $destinationPath = public_path() . $this->imageRepository;
        $imageFileName = null;

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $file = $request->file('logo');
            $extension = $file->extension();
            $fileName = 'img_' . time() . '.' . $extension;
            $file->move($destinationPath, $fileName);
            $imageFileName = $fileName;
        }

        $project = Project::create([
            'project' => $validatedData['project'],
            'logo' => $imageFileName ? $this->imageRepository . $imageFileName : null,
            'description_es' => $validatedData['description_es'],
            'description_en' => $validatedData['description_en'],
            'description_it' => $validatedData['description_it'],
            'link' => $validatedData['link'],
            'github' => $validatedData['github'] ? $validatedData['github'] : null
        ]);
        
        // Attach skills to the project
        $project->skills()->attach($validatedData['skills']);

        $return_message = 'Proyecto creado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route('projects.index')->with('logSuccess', $return_message);
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
    public function edit(Project $project)
    {
        return view($this->package . '.projects.edit', compact('project'))->with('editMode', true);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {

        $validatedData = $request->validate([
            'project'=> 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'description_es' => 'required|string',
            'description_en'=> 'required|string',
            'description_it'=> 'required|string',
            'link'=> 'required|string',
            'github'=> 'nullable|string',
            'skills' => 'required|array|min:1',
            'skills.*' => 'required|integer|exists:skills,id',
        ], [
            'project.required' => 'El nombre del proyecto es requerido.',
            'logo.image' => 'El archivo debe ser una imagen.',
            'logo.mimes' => 'El archivo debe ser una imagen con formato jpeg, jpg, png, webp, avif.',
            'logo.max' => 'El tamaño de la imagen no debe exceder los 2048 kilobytes.',
            'description_es.required' => 'El contenido en español es requerido.',
            'description_en.required' => 'El contenido en ingles es requerido.',
            'description_it.required' => 'El contenido en italiano es requerido.',
            'link.required' => 'El enlace es necesario.',
            'github.string' => 'El enlace de github debe ser una cadena de texto.',
            'skills.required' => 'Las habilidades son requeridas.',
            'skills.array' => 'Las habilidades deben ser un arreglo.',
            'skills.min' => 'Se requiere al menos una habilidad.',
            'skills.*.required' => 'La habilidad es requerida.',
            'skills.*.integer' => 'La habilidad debe ser un número entero.',
            'skills.*.exists' => 'La habilidad seleccionada no existe.'
        ]);

        $destinationPath = public_path() . $this->imageRepository;
        $imageOldFilename = $project->logo;
        $imageFileName = null;

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $file = $request->file('logo');
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
            if($project->logo !== null){
                $imageFileName = basename($project->logo);
            }
        }

        $project->update([
            'project' => $validatedData['project'],
            'logo' => $imageFileName ? $this->imageRepository . $imageFileName : null,
            'description_es' => $validatedData['description_es'],
            'description_en' => $validatedData['description_en'],
            'description_it' => $validatedData['description_it'],
            'link' => $validatedData['link'],
            'github' => $validatedData['github'] ? $validatedData['github'] : null
        ]);

        // Detach existing skills
        $project->skills()->detach();
        // Attach skills to the project
        $project->skills()->attach($validatedData['skills']);

        $return_message = 'Proyecto creado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route('projects.index')->with('logSuccess', $return_message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $imageProfile = $project->logo;

        if ($imageProfile !== null) {
            $ImagePath = public_path($imageProfile);
            if (file_exists($ImagePath) && is_file($ImagePath)) {
                unlink($ImagePath);
            }
        }

        $project->delete();

        $return_message = 'Proyecto borrado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route('projects.index')->with('logSuccess', $return_message);
    }
}

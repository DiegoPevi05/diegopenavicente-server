<?php

namespace App\Http\Controllers\diegopenavicente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LogService;
use App\Models\diegopenavicente\WebContent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WebContentController extends Controller
{
    public $routeName = 'webcontents';
    public $label = 'Contenido Web';
    public $icon;
    protected $package;
    protected $imageRepository;
    protected $logService;

    
    public function __construct()
    {
        $this->icon = Storage::get('images/webcontent.svg');

        $this->middleware(function ($request, $next) {
            $this->logService = app(LogService::class);
            $this->package = auth()->user()->package;
            $this->imageRepository = '/images/' . $this->package . '/webcontents/';
            return $next($request);
        });
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve only verified users with pagination
        $webContentsQuery = WebContent::query();

        // Check if the name search parameter is provided
        $name = $request->query('name');
        if ($name) {
            // Apply the name filter to the query
            $webContentsQuery->where('name', 'like', '%' . $name . '%');
        }

        // Paginate the categories
        $webcontents = $webContentsQuery->paginate(10);

        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $webcontents->lastPage())) {
            return redirect()->route($this->package . '.webcontents.index');
        }

        $searchParam = $name ? $name : '';

        // Return a view or JSON response as desired
        return view($this->package . '.webcontents.index', compact('webcontents', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view($this->package . '.webcontents.create')->with('editMode', false);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name'=> 'required|string|max:255',
            'content_es' => 'required|string',
            'content_en'=> 'required|string',
            'content_it'=> 'required|string',
        ], [
            'name.required' => 'El nombre de la habilidad es requerido.',
            'content_es.required' => 'El contenido en español es requerido.',
            'content_en.required' => 'El contenido en ingles es requerido.',
            'content_it.required' => 'El contenido en italiano es requerido.',
        ]);

        $webcontent = WebContent::create([
            'name' => $validatedData['name'],
            'content_es' => $validatedData['content_es'], 
            'content_en' => $validatedData['content_en'],
            'content_it' => $validatedData['content_it'],
        ]);

        $return_message = 'Contenido creado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route($this->package . '.webcontents.index')->with('logSuccess', $return_message);
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
    public function edit(WebContent $webcontentsdp)
    {
        $webcontent = $webcontentsdp;

        return view($this->package . '.webcontents.edit', compact('webcontent'))->with('editMode', true);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WebContent $webcontentsdp)
    {
        $webcontent = $webcontentsdp;

        $validatedData = $request->validate([
            'name'=> 'required|string|max:255',
            'content_es' => 'required|string',
            'content_en'=> 'required|string',
            'content_it'=> 'required|string',
        ], [
            'name.required' => 'El nombre de la habilidad es requerido.',
            'content_es.required' => 'El contenido en español es requerido.',
            'content_en.required' => 'El contenido en ingles es requerido.',
            'content_it.required' => 'El contenido en italiano es requerido.',
        ]);

        $webcontent->update([
            'name' => $validatedData['name'],
            'content_es' => $validatedData['content_es'],
            'content_en' => $validatedData['content_en'],
            'content_it' => $validatedData['content_it'],
        ]);

        $return_message = 'Contenido actualizado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route($this->package . '.webcontents.index')->with('logSuccess', $return_message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebContent $webcontentsdp)
    {
        $webcontent = $webcontentsdp;

        $webcontent->delete();

        $return_message = 'Coontenido borrado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route($this->package . '.webcontents.index')->with('logSuccess', $return_message);
    }
}

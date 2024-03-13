<?php

namespace App\Http\Controllers\lanonnarose;

use App\Http\Controllers\Controller;
use App\Services\LogService;
use Illuminate\Http\Request;
use App\Models\lanonnarose\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public $routeName = 'blogs';
    public $label = 'Blogs';
    public $icon;
    protected $package;
    protected $imageRepository;
    protected $logService;

    
    public function __construct()
    {
        $this->icon = Storage::get('images/blog.svg');

        $this->middleware(function ($request, $next) {
            $this->logService = app(LogService::class);
            $this->package = auth()->user()->package;
            $this->imageRepository = '/images/' . $this->package . '/blogs/';
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve only verified users with pagination
        $blogsQuery = Blog::query();

        // Check if the name search parameter is provided
        $title_es = $request->query('title_es');
        if ($title_es) {
            // Apply the name filter to the query
            $blogsQuery->where('title_es', 'like', '%' . $title_es . '%');
        }

        // Paginate the categories
        $blogs = $blogsQuery->paginate(10);

        // Decode the details
        $blogs->map(function ($blog) {
            $blog->bulletpoints_en = explode('|', $blog->bulletpoints_en);
            $blog->bulletpoints_es = explode('|', $blog->bulletpoints_es);
            return $blog;
        });

        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $blogs->lastPage())) {
            return redirect()->route($this->package . '.blogs.index');
        }

        $searchParam = $title_es ? $title_es : '';

        // Return a view or JSON response as desired
        return view($this->package . '.blogs.index', compact('blogs', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view($this->package . '.blogs.create')->with('editMode', false);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title_es'=> 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'subTitle_es'=> 'required|string|max:255',
            'subTitle_en' => 'required|string|max:255',
            'description_es' => 'required|string',
            'description_en'=> 'required|string',
            'image1' => 'required|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'image4' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'bulletpoints_es' => 'required|array|min:1',
            'bulletpoints_es.*'=> 'required|string|max:255',
            'bulletpoints_en'=> 'required|array|min:1',
            'bulletpoints_en.*'=> 'required|string|max:255',
            'isImportant' => 'nullable',

        ], [
            'title_es.required' => 'El titulo en español es requerido.',
            'title_en.required' => 'El titulo en ingles es requerido.',
            'subTitle_es.required' => 'El subtitulo en español es requerido.',
            'subTitle_en.required' => 'El subtitulo en ingles es requerido.',
            'description_es.required' => 'La descripción en español es requerida.',
            'description_en.required' => 'La descripción en ingles es requerida.',
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
            'image4.max' => 'El tamaño máximo del archivo 4 es 2MB.',
            'bulletpoints_es.required' => 'El contenido en español es requerido.',
            'bulletpoints_es.min' => 'El contenido en español es requerido.',
            'bulletpoints_es.*.required' => 'El contenido en español es requerido.',
            'bulletpoints_es.*.max' => 'El contenido en español es requerido.',
            'bulletpoints_en.required' => 'El contenido en ingles es requerido.',
            'bulletpoints_en.min' => 'El contenido en ingles es requerido.',
            'bulletpoints_en.*.required' => 'El contenido en ingles es requerido.',
            'bulletpoints_en.*.max' => 'El contenido en ingles es requerido.',
            
        ]);

        $destinationPath = public_path() . $this->imageRepository;
        $imageFileName = [];
        //make a fourlop to upload the four images
        for ($i=1; $i <= 4; $i++) {
            $imageFileName[$i] = null;
            if ($request->hasFile('image'.$i) && $request->file('image'.$i)->isValid()) {
                $file = $request->file('image'.$i);
                $extension = $file->extension();
                $fileName = 'blog_'.$i . '_' . time() .'.' .$extension;
                $file->move($destinationPath,$fileName);
                $imageFileName[$i] = $fileName;
            }
        }

        $is_important = isset($validatedData['isImportant']) && $validatedData['isImportant'] ? true : false;

        $blog = Blog::create([
            'title_es' => $validatedData['title_es'],
            'title_en' => $validatedData['title_en'],
            'subTitle_es' => $validatedData['subTitle_es'],
            'subTitle_en' => $validatedData['subTitle_en'],
            'description_es' => $validatedData['description_es'],
            'description_en' => $validatedData['description_en'],
            'image1' => $imageFileName[1] ? $this->imageRepository . $imageFileName[1] : null,
            'image2' => $imageFileName[2] ? $this->imageRepository . $imageFileName[2] : null,
            'image3' => $imageFileName[3] ? $this->imageRepository . $imageFileName[3] : null,
            'image4' => $imageFileName[4] ? $this->imageRepository . $imageFileName[4] : null,
            'bulletpoints_es' => implode('|', $validatedData['bulletpoints_es']),
            'bulletpoints_en' => implode('|', $validatedData['bulletpoints_en']),
        ]);

        $return_message = 'Blog creado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route($this->package . '.blogs.index')->with('logSuccess', $return_message);
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
    public function edit(Blog $blog)
    {

        return view($this->package . '.blogs.edit', compact('blog'))->with('editMode', true);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validatedData = $request->validate([
            'title_es'=> 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'subTitle_es'=> 'required|string|max:255',
            'subTitle_en' => 'required|string|max:255',
            'description_es' => 'required|string',
            'description_en'=> 'required|string',
            'image1' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'image4' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'bulletpoints_es' => 'required|array|min:1',
            'bulletpoints_es.*'=> 'required|string|max:255',
            'bulletpoints_en'=> 'required|array|min:1',
            'bulletpoints_en.*'=> 'required|string|max:255',
            'isImportant' => 'nullable',

        ], [
            'title_es.required' => 'El titulo en español es requerido.',
            'title_en.required' => 'El titulo en ingles es requerido.',
            'subTitle_es.required' => 'El subtitulo en español es requerido.',
            'subTitle_en.required' => 'El subtitulo en ingles es requerido.',
            'description_es.required' => 'La descripción en español es requerida.',
            'description_en.required' => 'La descripción en ingles es requerida.',
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
            'image4.max' => 'El tamaño máximo del archivo 4 es 2MB.',
            'bulletpoints_es.required' => 'El contenido en español es requerido.',
            'bulletpoints_es.min' => 'El contenido en español es requerido.',
            'bulletpoints_es.*.required' => 'El contenido en español es requerido.',
            'bulletpoints_es.*.max' => 'El contenido en español es requerido.',
            'bulletpoints_en.required' => 'El contenido en ingles es requerido.',
            'bulletpoints_en.min' => 'El contenido en ingles es requerido.',
            'bulletpoints_en.*.required' => 'El contenido en ingles es requerido.',
            'bulletpoints_en.*.max' => 'El contenido en ingles es requerido.',
            
        ]);

        $destinationPath = public_path() . $this->imageRepository;
        $imageFileName = [];
        for($i=1; $i <= 4; $i++){
            $imageOldFilename = $blog->{'image'.$i};
            if ($request->hasFile('image'.$i) && $request->file('image'.$i)->isValid()) {
                $file = $request->file('image'.$i);
                $extension = $file->extension();
                $fileName = 'blog_'.$i . '_' . time() .'.' .$extension;
                $file->move($destinationPath,$fileName);
                $imageFileName[$i] = $fileName;

                if ($imageOldFilename !== null) {
                    $oldImagePath = public_path($imageOldFilename);
                    if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }else{
                if($blog->{'image'.$i} !== null){
                    $imageFileName[$i] = basename($blog->{'image'.$i});
                }else{
                    $imageFileName[$i] = null;
                }
            }
        }

        $is_important = isset($validatedData['isImportant']) && $validatedData['isImportant'] ? true : false;

        $blog->update([
            'title_es' => $validatedData['title_es'],
            'title_en' => $validatedData['title_en'],
            'subTitle_es' => $validatedData['subTitle_es'],
            'subTitle_en' => $validatedData['subTitle_en'],
            'description_es' => $validatedData['description_es'],
            'description_en' => $validatedData['description_en'],
            'image1' => $imageFileName[1] ? $this->imageRepository . $imageFileName[1] : null,
            'image2' => $imageFileName[2] ? $this->imageRepository . $imageFileName[2] : null,
            'image3' => $imageFileName[3] ? $this->imageRepository . $imageFileName[3] : null,
            'image4' => $imageFileName[4] ? $this->imageRepository . $imageFileName[4] : null,
            'bulletpoints_es' => implode('|', $validatedData['bulletpoints_es']),
            'bulletpoints_en' => implode('|', $validatedData['bulletpoints_en']),
        ]);

        $return_message = 'Blog actualizado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route($this->package . '.blogs.index')->with('logSuccess', $return_message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Blog $blog)
    {
        for($i=1; $i <= 4; $i++){
            $imageProfile = $blog->{'image'.$i};
            if ($imageProfile !== null) {
                $ImagePath = public_path($imageProfile);
                if (file_exists($ImagePath) && is_file($ImagePath)) {
                    unlink($ImagePath);
                }
            }
        }

        $blog->delete();

        $return_message = 'Blog borrado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route($this->package . '.blogs.index')->with('logSuccess', $return_message);
    }
}

<?php

namespace App\Http\Controllers\lanonnarose;

use App\Http\Controllers\Controller;
use App\Services\LogService;
use Illuminate\Http\Request;
use App\Models\lanonnarose\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public $routeName = 'products';
    public $label = 'Productos';
    public $icon;
    protected $package;
    protected $imageRepository;
    protected $logService;

    
    public function __construct()
    {
        $this->icon = Storage::get('images/product.svg');

        $this->middleware(function ($request, $next) {
            $this->logService = app(LogService::class);
            $this->package = auth()->user()->package;
            $this->imageRepository = '/images/' . $this->package . '/products/';
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve only verified users with pagination
        $productQuery = Product::query();

        // Check if the name search parameter is provided
        $name = $request->query('name');
        if ($name) {
            // Apply the name filter to the query
            $productQuery->where('name', 'like', '%' . $name . '%');
        }

        // Paginate the categories
        $products = $productQuery->paginate(10);

        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $products->lastPage())) {
            return redirect()->route('products.index');
        }

        $searchParam = $name ? $name : '';

        // Return a view or JSON response as desired
        return view($this->package . '.products.index', compact('products', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view($this->package . '.products.create')->with('editMode', false);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'section_es'=> 'required|string|max:255',
            'section_en' => 'required|string|max:255',
            'title_es'=> 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'name'=> 'required|string|max:255',
            'shortDescription_es' => 'required|string',
            'shortDescription_en' => 'required|string',
            'description_es' => 'required|string',
            'description_en' => 'required|string',
            'imageUrl' => 'required|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'isImportant' => 'nullable',
        ], [
            'section_es.required' => 'La sección en español es requerida.',
            'section_en.required' => 'La sección en ingles es requerida.',
            'section_es.max' => 'La sección en español no debe exceder los 255 caracteres.',
            'section_en.max' => 'La sección en ingles no debe exceder los 255 caracteres.',
            'title_es.required' => 'El título en español es requerido.',
            'title_en.required' => 'El título en ingles es requerido.',
            'title_es.max' => 'El título en español no debe exceder los 255 caracteres.',
            'title_en.max' => 'El título en ingles no debe exceder los 255 caracteres.',
            'name.required' => 'El nombre del producto es requerido.',
            'shortDescription_es.required' => 'La descripción corta en español es requerida.',
            'shortDescription_en.required' => 'La descripción corta en ingles es requerida.',
            'description_es.required' => 'La descripción en español es requerida.',
            'description_en.required' => 'La descripción en ingles es requerida.',
            'imageUrl.required' => 'La imagen es requerida.',
            'imageUrl.image' => 'La imagen debe ser una imagen.',
            'imageUrl.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png, webp, avif.',
            'imageUrl.max' => 'El tamaño máximo de la imagen es 2MB.',
        ]);

        
        $destinationPath = public_path() . $this->imageRepository;
        $imageFileName = null;

        if ($request->hasFile('imageUrl') && $request->file('imageUrl')->isValid()) {
            $file = $request->file('imageUrl');
            $extension = $file->extension();
            $fileName = 'imageurl_' . time() . '.' . $extension;
            $file->move($destinationPath, $fileName);
            $imageFileName = $fileName;
        }

        $is_Important = isset($validatedData['isImportant']) && $validatedData['isImportant'] ? true : false;

        $product = Product::create([
            'section_es' => $validatedData['section_es'],
            'section_en' => $validatedData['section_en'],
            'title_es' => $validatedData['title_es'],
            'title_en' => $validatedData['title_en'],
            'name' => $validatedData['name'],
            'shortDescription_es' => $validatedData['shortDescription_es'],
            'shortDescription_en' => $validatedData['shortDescription_en'],
            'description_es' => $validatedData['description_es'],
            'description_en' => $validatedData['description_en'],
            'imageUrl' => $imageFileName ? $this->imageRepository . $imageFileName : null,
            'isImportant' => $is_Important,
        ]);

        $return_message = 'Producto creado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route($this->package .'.products.index')->with('logSuccess', $return_message);
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
    public function edit(Product $product)
    {

        return view($this->package . '.products.edit', compact('product'))->with('editMode', true);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'section_es'=> 'required|string|max:255',
            'section_en' => 'required|string|max:255',
            'title_es'=> 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'name'=> 'required|string|max:255',
            'shortDescription_es' => 'required|string',
            'shortDescription_en' => 'required|string',
            'description_es' => 'required|string',
            'description_en' => 'required|string',
            'imageUrl' => 'nullable|image|mimes:jpeg,jpg,png,webp,avif|max:2048',
            'isImportant' => 'nullable',
        ], [
            'section_es.required' => 'La sección en español es requerida.',
            'section_en.required' => 'La sección en ingles es requerida.',
            'section_es.max' => 'La sección en español no debe exceder los 255 caracteres.',
            'section_en.max' => 'La sección en ingles no debe exceder los 255 caracteres.',
            'title_es.required' => 'El título en español es requerido.',
            'title_en.required' => 'El título en ingles es requerido.',
            'title_es.max' => 'El título en español no debe exceder los 255 caracteres.',
            'title_en.max' => 'El título en ingles no debe exceder los 255 caracteres.',
            'name.required' => 'El nombre del producto es requerido.',
            'shortDescription_es.required' => 'La descripción corta en español es requerida.',
            'shortDescription_en.required' => 'La descripción corta en ingles es requerida.',
            'description_es.required' => 'La descripción en español es requerida.',
            'description_en.required' => 'La descripción en ingles es requerida.',
            'imageUrl.image' => 'La imagen debe ser una imagen.',
            'imageUrl.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png, webp, avif.',
            'imageUrl.max' => 'El tamaño máximo de la imagen es 2MB.',
        ]);

        $destinationPath = public_path() . $this->imageRepository;
        $imageOldFilename = $product->imageUrl;
        $imageFileName = null;

        if ($request->hasFile('imageUrl') && $request->file('imageUrl')->isValid()) {
            $file = $request->file('imageUrl');
            $extension = $file->extension();
            $fileName = 'imageurl_' . time() . '.' . $extension;
            $file->move($destinationPath, $fileName);
            $imageFileName = $fileName;

            if ($imageOldFilename !== null) {
                $oldImagePath = public_path($imageOldFilename);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }else{
            if($product->imageUrl !== null){
                $imageFileName = basename($product->imageUrl);
            }
        }

        $is_Important = isset($validatedData['isImportant']) && $validatedData['isImportant'] ? true : false;

        $product->update([
            'section_es' => $validatedData['section_es'],
            'section_en' => $validatedData['section_en'],
            'title_es' => $validatedData['title_es'],
            'title_en' => $validatedData['title_en'],
            'name' => $validatedData['name'],
            'shortDescription_es' => $validatedData['shortDescription_es'],
            'shortDescription_en' => $validatedData['shortDescription_en'],
            'description_es' => $validatedData['description_es'],
            'description_en' => $validatedData['description_en'],
            'imageUrl' => $imageFileName ? $this->imageRepository . $imageFileName : null,
            'isImportant' => $is_Important,
        ]);

        $return_message = 'Producto actualizado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route($this->package .'.products.index')->with('logSuccess', $return_message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Product $product)
    {
        $imageProfile = $product->imageUrl;

        if ($imageProfile !== null) {
            $ImagePath = public_path($imageProfile);
            if (file_exists($ImagePath) && is_file($ImagePath)) {
                unlink($ImagePath);
            }
        }

        $product->delete();

        $return_message = 'Producto borrado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route($this->package . '.products.index')->with('logSuccess', $return_message);
    }
}

<?php

namespace App\Http\Controllers\diegopenavicente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LogService;
use App\Models\diegopenavicente\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public $routeName = 'books';
    public $label = 'Libros';
    public $icon;
    protected $package;
    protected $imageRepository;

    protected $logService;

    
    public function __construct()
    {
        
        $this->icon = Storage::get('images/book.svg');

        $this->middleware(function ($request, $next) {
            $this->logService = app(LogService::class);
            $this->package = auth()->user()->package;
            $this->imageRepository = '/images/' . $this->package . '/books/';
            return $next($request);
        });
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve only verified users with pagination
        $booksQuery = Book::query();

        // Check if the title search parameter is provided
        $title = $request->query('title');
        if ($title) {
            // Apply the title filter to the query
            $booksQuery->where('title', 'like', '%' . $title . '%');
        }

        // Paginate the categories
        $books = $booksQuery->paginate(10);

        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $books->lastPage())) {
            return redirect()->route('books.index');
        }

        $searchParam = $title ? $title : '';

        // Return a view or JSON response as desired
        return view($this->package . '.books.index', compact('books', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view($this->package . '.books.create')->with('editMode', false);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title'=> 'required|string|max:255',
            'type'=> 'required|string|max:255',
            'author'=> 'required|string|max:255',
            'content_es' => 'required|string',
            'content_en'=> 'required|string',
            'content_it'=> 'required|string',
            'href'=> 'required|string',
            'img' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'title.required' => 'El nombre de la habilidad es requerido.',
            'type.required' => 'El tipo de la habilidad es requerido.',
            'author.required' => 'El autor de la habilidad es requerido.',
            'content_es.required' => 'El contenido en español es requerido.',
            'content_en.required' => 'El contenido en ingles es requerido.',
            'content_it.required' => 'El contenido en italiano es requerido.',
            'href.required' => 'El enlace es requerido.',
            'img.required' => 'La imagen es requerida.',
            'img.image' => 'El archivo debe ser una imagen.',
            'img.mimes' => 'El archivo debe ser de tipo: jpeg, jpg, png, webp.',
            'img.max' => 'El tamaño máximo del archivo es 2MB.'
        ]);

        $destinationPath = public_path() . $this->imageRepository;
        $imageFileName = null;

        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $file = $request->file('img');
            $extension = $file->extension();
            $fileName = 'img_' . time() . '.' . $extension;
            $file->move($destinationPath, $fileName);
            $imageFileName = $fileName;
        }

        $book = Book::create([
            'title' => $validatedData['title'],
            'type' => $validatedData['type'],
            'author' => $validatedData['author'],
            'content_es' => $validatedData['content_es'], 
            'content_en' => $validatedData['content_en'],
            'content_it' => $validatedData['content_it'],
            'href' => $validatedData['href'], 
            'img' => $imageFileName ? $this->imageRepository . $imageFileName : null,
        ]);

        $return_message = 'Libro creado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route('books.index')->with('logSuccess', $return_message);
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
    public function edit(Book $book)
    {
        return view($this->package . '.books.edit', compact('book'))->with('editMode', true);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title'=> 'required|string|max:255',
            'type'=> 'required|string|max:255',
            'author'=> 'required|string|max:255',
            'content_es' => 'required|string',
            'content_en'=> 'required|string',
            'content_it'=> 'required|string',
            'href'=> 'required|string',
            'img' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'title.required' => 'El nombre de la habilidad es requerido.',
            'type.required' => 'El tipo de la habilidad es requerido.',
            'author.required' => 'El autor de la habilidad es requerido.',
            'content_es.required' => 'El contenido en español es requerido.',
            'content_en.required' => 'El contenido en ingles es requerido.',
            'content_it.required' => 'El contenido en italiano es requerido.',
            'href.required' => 'El enlace es requerido.',
            'img.image' => 'El archivo debe ser una imagen.',
            'img.mimes' => 'El archivo debe ser de tipo: jpeg, jpg, png, webp.',
            'img.max' => 'El tamaño máximo del archivo es 2MB.'
        ]);

        $destinationPath = public_path() . $this->imageRepository;
        $imageOldFilename = $book->img;
        $imageFileName = null;

        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $file = $request->file('img');
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
            if($book->img !== null){
                $imageFileName = basename($book->img);
            }
        }

        $book->update([
            'title' => $validatedData['title'],
            'type' => $validatedData['type'],
            'author' => $validatedData['author'],
            'content_es' => $validatedData['content_es'],
            'content_en' => $validatedData['content_en'],
            'content_it' => $validatedData['content_it'],
            'href' => $validatedData['href'],
            'img' => $imageFileName ? $this->imageRepository . $imageFileName : null,
        ]);

        $return_message = 'Libro actualizado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route('books.index')->with('logSuccess', $return_message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $imageProfile = $book->img;

        if ($imageProfile !== null) {
            $ImagePath = public_path($imageProfile);
            if (file_exists($ImagePath) && is_file($ImagePath)) {
                unlink($ImagePath);
            }
        }

        $book->delete();

        $return_message = 'Libro borrado exitosamente.';

        $this->logService->Log(1,$return_message);

        return redirect()->route('books.index')->with('logSuccess', $return_message);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books       = Book::all();
        return view('book', compact('books'));
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
        $book = new Book;

        $validatedData = $request->validate([
            'title'=> 'required|string|max:255',
            'author'=> 'required|string|max:255',
            'content_es' => 'required|string',
            'content_en'=> 'required|string',
            'content_it'=> 'required|string',
            'href'=> 'required|string'
        ], [
            'title.required' => 'El nombre de la habilidad es requerido.',
            'author.required' => 'El autor de la habilidad es requerido.',
            'content_es.required' => 'El contenido en español es requerido.',
            'content_en.required' => 'El contenido en ingles es requerido.',
            'content_it.required' => 'El contenido en italiano es requerido.',
            'href.required' => 'El enlace es requerido.'
        ]);


        $fileName = '';
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $file = $request->file('img');
            $extension = $file->extension();
            $fileName = 'books_'.time().'.' .$extension;
            $destinationPath = public_path().'/images/books';
            $file->move($destinationPath,$fileName);
        }

        $book->title                   = $request->title;
        $book->type                    = $request->type;
        $book->author                  = $request->author;
        $book->content_es              = $request->content_es;
        $book->content_en              = $request->content_en;
        $book->content_it              = $request->content_it;
        $book->href                    = $request->href;


        if($fileName != ''){
           $book->img = '/images/books/'. $fileName;
        }


        try {
            $book->save();
        } catch (\Exception $e) {
            error_log('Some message here.');
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while creating the news. Please try again.']);
        }

        return redirect()->back()->with('success', 'Book is created successfully.');
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
        $book = Book::findOrFail($id);

        $validatedData = $request->validate([
            'title'=> 'required|string|max:255',
            'author'=> 'required|string|max:255',
            'content_es' => 'required|string',
            'content_en'=> 'required|string',
            'content_it'=> 'required|string',
            'href'=> 'required|string'
        ], [
            'title.required' => 'El nombre de la habilidad es requerido.',
            'author.required' => 'El autor de la habilidad es requerido.',
            'content_es.required' => 'El contenido en español es requerido.',
            'content_en.required' => 'El contenido en ingles es requerido.',
            'content_it.required' => 'El contenido en italiano es requerido.',
            'href.required' => 'El enlace es requerido.'
        ]);


        $fileName = '';
        if ($request->hasFile('img') && $request->file('img')->isValid()) {

            //delete previous image
            $imagePath = public_path($book->img);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            //load new image
            $file = $request->file('img');
            $extension = $file->extension();
            $fileName = 'books_'.time().'.' .$extension;
            $destinationPath = public_path().'/images/books';
            $file->move($destinationPath,$fileName);
        }

        $book->title                   = $request->title;
        $book->type                    = $request->type;
        $book->author                  = $request->author;
        $book->content_es              = $request->content_es;
        $book->content_en              = $request->content_en;
        $book->content_it              = $request->content_it;
        $book->href                    = $request->href;


        if($fileName != ''){
           $book->img = '/images/books/'. $fileName;
        }


        try {
            $book->save();
        } catch (\Exception $e) {
            error_log('Some message here.');
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while creating the news. Please try again.']);
        }

        return redirect()->back()->with('success', 'Book is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book=Book::findorFail($id);
        $imagePath = public_path($book->img);

        try {

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $book->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while deleting the News Section. Please try again.']);
        }

        return redirect()->back()->with('success', 'Book deleted successfully.');
    }
}

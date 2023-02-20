<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{

    protected $rules =
    [
        'ISBN' => 'required|string|size:13|unique:books',
        'title' => 'required|string|min:2|max:200',
        'author' => 'required|min:2|max:100',
        'pages' => 'required|integer|min:1',
        'price' => 'required|numeric',
        'thumb' => 'required|url|min:5',
        'year' => 'required|integer|between:1450,2023',
    ];

    protected $messages = [
        'ISBN.required' => 'E\' necessario inserire un codice ISBN',
        'ISBN.size' => 'Il codice ISBN deve contenere 13 cifre',
        'ISBN.unique' => 'Questo codice ISBN è già presente in archivio',

        'title.required' => 'E\' necessario inserire un TITOLO',
        'title.min' => 'Il titolo deve contenere almeno 2 caratteri',
        'title.max' => 'Il titolo non può essere più lungo 200',

        'author.required' => 'E\' necessario inserire un AUTORE',
        'author.min' => 'L\'autore deve contenere almeno 2 caratteri',
        'author.max' => 'L\'autore non può essere più lungo 100',

        'pages.required' => 'Inserisci un numero di PAGINE',
        'pages.min' => 'Il numero di pagine deve esssere maggiore di ZERO',

        'price.required' => 'Inserisci un PREZZO corretto',

        'thumb.required' => 'Inserisci un link nella THUMB',
        'thumb.url' => 'Inserisci una URL valido nella THUMB',
        'thumb.min' => 'La THUMB deve contenere almeno 5 caratteri',

        'year.required' => 'Inserisci l\'ANNO di pubblicazione',
        'year.between' => 'L\'anno deve essere compreso tra il 1450 e il 2023',
    ];




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $books = Book::all();
        return view('books.index', compact('books'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Book $book)
    {
        // $book = new Book();
        return view('books.create', compact('book'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        //        $newRules = $this->rules;
        //        $newRules['ISBN'] = 'required|string|size:13|unique:books';

        $request->validate($this->rules, $this->messages);

        $newBook = new Book();
        $newBook->fill($data);
        $newBook->save();

        return redirect()->route('books.show', $newBook->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->all();

        // required|string|size:13|unique:books        

        $newRules = $this->rules;
        $newRules['ISBN'] = ['required', 'string', 'size:13', Rule::unique('books')->ignore($book->id)];

        $request->validate($newRules, $this->messages);

        if (!array_key_exists('soldout', $data)) {
            $data['soldout'] = false;
        }

        //$book = Book::findOrFail($id);
        $book->update($data);
        return redirect()->route('books.index', compact('book'))->with('message', "Updated: ($book->title) ")->with('alert-type', 'alert-success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('message', 'Delete successfully')->with('alert-type', 'alert-danger');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Environment\Console;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return new BookCollection($books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //cuva obj u bazi i proverava da li je u skladu sa zahtevima
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'slug'=>'required|string|max:100',
            'year_of_publication'=>'required',
            'edition'=>'required',
            'genre_id'=>'required',
        ]);

        if($validator->fails())
            return response()->json($validator->errors());

        $book = Book::create([
            'name'=>$request->name,
            'slug'=>$request->slug,
            'year_of_publication'=>$request->year_of_publication,
            'edition'=>$request->edition,
            'user_id'=>Auth::user()->id,
            'genre_id'=>$request->genre_id
        ]);

        return response()->json(["Book is created successfully!", new BookResource($book)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
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
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'slug'=>'required|string|max:100',
            'year_of_publication'=>'required',
            'edition'=>'required',
            'genre_id'=>'required',
        ]);

        if($validator->fails())
            return response()->json($validator->errors());

        $book ->name = $request->name;
        $book ->slug = $request->slug;
        $book ->year_of_publication = $request->year_of_publication;
        $book ->edition = $request->edition;
        $book ->genre_id = $request->genre_id;

        $book->save();
        return response()->json(["Book is updated successfully", new BookResource($book)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($book_id)
    {
        Book::destroy($book_id);

        return response()->json("Book is deleted successfully!");
    }
}


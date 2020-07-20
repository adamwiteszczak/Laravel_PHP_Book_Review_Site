<?php

namespace App\Http\Controllers;

use App\Book;
use App\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all()->sortBy('name');
        return view('genre/index', compact('genres'));
    }

    public function show($link)
    {
        $genre = Genre::where('link', '=', $link)->firstOrFail();
        $books = Book::whereGenreId($genre->id)
            ->orderBy('title', 'asc')
            ->with('user')
            ->paginate(20);
        //show books in that genre, ordered by title, paginated.

        return view('genre/show', compact('genre', 'books'));
    }
}

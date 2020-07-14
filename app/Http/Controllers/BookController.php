<?php

namespace App\Http\Controllers;

use App\Book;
use App\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BookController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        //$this->authorize('create', $user);
        $genres = Genre::all()->sortBy('name');
        return view('books/create', compact('user', 'genres'));
    }

    public function store()
    {
        $user = auth()->user();

        //$this->authorize('create', $user);

        $data = request()->validate(
          array(
              'author_name' => ['required'],
              'title' => ['required'],
              'blurb'=> ['required'],
              'genre_id' => ['required'],
              'cover_image' => ''
          )
        );

        if (request('cover_image')) {
            request()->validate(['cover_image' => 'image']);
            $data['cover_image'] = request('cover_image')->store('book', 'public');
            $image = Image::make(public_path('storage/' . $data['cover_image']))->fit('500', 500);
            $image->save();
        }

        $data['user_uuid'] = auth()->user()->uuid;

        Book::create($data);

        return redirect('/profile');

    }
}

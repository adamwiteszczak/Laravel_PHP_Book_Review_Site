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

        $this->authorize('create', Book::Class);

        $genres = Genre::all()->sortBy('name');
        return view('books/create', compact('user', 'genres'));
    }

    public function store()
    {
        $user = auth()->user();

        $this->authorize('create', Book::Class);

        $data = request()->validate(
            array(
                'author_name' => ['required'],
                'title' => ['required'],
                'blurb'=> ['required'],
                'genre_id' => ['required'],
                'cover_image' => '',
                'store_link' => ''
            )
        );

        if (request('cover_image')) {
            request()->validate(['cover_image' => 'image']);
            $data['cover_image'] = request('cover_image')->store('book', 'public');
            $image = Image::make(public_path('storage/' . $data['cover_image']))
                ->fit(1000, 1600, function ($constraint) {
                    $constraint->aspectRatio();
                });
            $image->save();
        }

        $data['user_uuid'] = auth()->user()->uuid;

        Book::create($data);

        return redirect('/profile');
    }

    public function show(Book $book)
    {
        $user = auth()->user();
        $cover_image = $this->getCoverImage($book);
        $edit_link = false;

        if ($user && $user->uuid == $book->user_uuid) {
            $edit_link = true;
        }

        return view('books/show', compact('book', 'cover_image', 'edit_link'));
    }

    public function edit(Book $book)
    {
        $user = auth()->user();
        $this->authorize('update', $book);

        $genres = Genre::all()->sortBy('name');
        return view('books/edit', compact('book', 'genres'));
    }

    public function update(Book $book)
    {
        $user = auth()->user();
        $this->authorize('update', $book);

        $data = request()->validate(
            array(
                'author_name' => ['required'],
                'title' => ['required'],
                'blurb'=> ['required'],
                'genre_id' => ['required'],
                'cover_image' => '',
                'store_link' => ''
            )
        );

        if (request('cover_image')) {
            request()->validate(['cover_image' => 'image']);
            $data['cover_image'] = request('cover_image')->store('book', 'public');
            $image = Image::make(public_path('storage/' . $data['cover_image']))
                ->fit(1000, 1600, function ($constraint) {
                    $constraint->aspectRatio();
                });
            $image->save();

            //delete the existing image if exists:
            if ($book->cover_image && $book->cover_image != '/img/nocover.jpg') {
                Storage::disk('public')->delete($this->getCoverImage());
            }
        }

        $book->update($data);

        return redirect('/books/' . $book->id);
    }

    public static function getCoverImage(Book $book)
    {
        if ($book->cover_image) {
            return '/storage/' . $book->cover_image;
        }

        return '/img/nocover.jpg';
    }
}

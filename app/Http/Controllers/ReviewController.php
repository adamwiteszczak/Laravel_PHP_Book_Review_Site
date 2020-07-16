<?php

namespace App\Http\Controllers;

use App\Book;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Book $book)
    {
        if (!auth()->user()) {
            return redirect('/login');
        }

        return view('review/create', compact('book'));
    }

    public function store()
    {
        $user = auth()->user();

        if (!auth()->user()) {
            return redirect('/login');
        }

        $data = request()->validate(
            array(
                'review' => ['required', 'min:50'],
                'book_id' => ['required', 'int'],
                'score' => ['required', 'int']
            )
        );

        $data['user_uuid'] = $user->uuid;
        $book = Book::findOrFail($data['book_id']);
        Review::create($data);
        return redirect('/books/' . $data['book_id']);
    }
}

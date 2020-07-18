<?php

namespace App\Http\Controllers;

use App\Book;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function create(Book $book)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect('/login');
        }

        //check to see if the user has previously reviewed this book - they can't review it
        //twice, and so instead, take them to the edit review pages for their existing review:
        $review = Review::whereUserUuid($user->uuid)
            ->whereBookId($book->id)
            ->get();

        if ($review->count()) {
            return redirect('/books/review/edit/' . $review[0]->id);
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

    public function edit(Review $review)
    {
        $this->authorize('update', $review);
        return view('/review/edit', compact('review'));
    }

    public function update(Review $review)
    {
        $this->authorize('update', $review);
        $data = request()->validate(
            array(
                'review' => ['required', 'min:50'],
                'score' => ['required', 'int']
            )
        );

        $review->update($data);
        return redirect('/books/' . $review->book->id);
    }

    public function show(Book $book)
    {
        return view('/review/show', compact('book'));
    }

    public static function calculateRating($book_id)
    {
        $data = DB::table('reviews')
            ->select('score')
            ->where('book_id', '=', $book_id);
        return round($data->average('score'), 2);
    }
}

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row col-6 offset-3">
            <div class="h3">Update Review: <span class="font-weight-bold">{{ $review->book->title }}</span></div>
        </div>
        <form action="/books/review/edit/{{$review->book_id}}" method="post" enctype="application/x-www-form-urlencoded">
            @csrf
            @method('PATCH')

            <input type="hidden" id="book_id" name="book_id" value="{{ $review->book_id }}">
            <div class="form-group row col-6 offset-3">
                <label for="review" class="col-md-4 col-form-label">Your thoughts?</label>
                <textarea
                    class="form-control @error('review') is-invalid @enderror"
                    id="review"
                    name="review"
                    autofocus
                    cols="10"
                    rows="10"
                >{{ old('review') ?? $review->review }}</textarea>

                @error('review')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group-row col-6 offset-3 d-flex align-items-baseline">
                <label for="score form-label pr-3">My Rating: </label>
                <select name="score" id="score" class="ml-4">
                    @for($i = 1; $i < 11; $i++)
                        <option value="{{ $i }}"
                            {{ $review->score == $i ? ' SELECTED' : '' }}
                        >{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group row col-6 offset-3">
                Remember, your review is public and can be read by others!
            </div>
            <div class="form-group row col-6 offset-3">
                <button class="btn btn-primary">Update Review</button>
            </div>

        </form>
    </div>
@endsection

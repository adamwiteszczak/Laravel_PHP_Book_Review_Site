@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                <img src="{{$cover_image}}" alt="{{$book->title}}" class="img-fluid img-thumbnail">
                <div class="pt-2 text-center"><a href="/books/review/{{$book->id}}">Review Book</a></div>
                <div class="pt-2 text-center">
                    @if($book->review && $book->review->count())
                        Avg Score:
                        {{ \App\Http\Controllers\ReviewController::calculateRating($book->id) }}
                        / 10
                    @endif
                    @if(!$book->review->count())
                        n/a
                    @endif
                </div>
            </div>
            <div class="col-9">
                <div class="d-flex">
                    <div class="h3">{{ $book->title }}</div>
                    <div class="small pl-3">> <a class="text-dark" href="/genres">{{$book->genre->name}}</a></div>
                </div>
                <div class="small">
                    <div>
                        by <a href="/profile/{{$book->user->profile->profile_link}}" class="text-dark">
                        {{ $book->author_name }}
                        </a>
                    </div>
                    @if($edit_link)
                        <div>
                            <a href="/books/edit/{{$book->id}}">Edit Details</a>
                        </div>
                    @endif
                </div>
                <hr>
                <div class="pt-2">{{ $book->blurb }}</div>
                <hr>
                <div class="pt-2">
                    <a href="{{$book->store_link}}" class="text-dark">{{$book->store_link}}</a>
                </div>
            </div>
        </div>
        <div class="h3 row col-6 offset-3">Reviews:</div>
        @if($book->review->count() == 0)
            <div class="row col-6 offset-3 panel">Nothing here! &nbsp
                <a href="/books/review/{{$book->id}}">
                    Why not write a review?
                </a>
            </div>
        @endif

        @foreach($book->review as $review)
            <div class="row col-6 offset-3 pt-4 pb-4 mb-4 panel">
                <div class="d-flex">
                    <div class="pr-4">
                        <img
                            src="{{\App\Http\Controllers\ProfileController::getProfileImage($review->user)}}"
                            class="rounded-circle"
                            style="width:50px"
                        >
                    </div>
                    <div>
                        <div class="h6">
                            <div>
                                Review by -
                                <a href="/profile/{{ $review->user->profile->profile_link }}">
                                    {{ $review->user->name }}
                                </a>
                            </div>
                            <div class="small">
                                {{date("F d, Y", strtotime($review->created_at))}}
                            </div>
                            <div class="pt-4 font-weight-bold">
                                Rating: {{ $review->score }} / 10
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    {{ $review->review }}
                </div>
            </div>
        @endforeach
    </div>

@endsection

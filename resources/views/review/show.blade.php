@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row col-6 offset-3">
            <div class="h3">
                <div>
                    Reviews for {{ $book->title }}
                </div>
            </div>
        </div>
        <div class="row col-6 offset-3 pb-2">
            <div class="small"><a href="/books/review/{{$book->id}}">Review this book</a></div>
        </div>
        <div class="row col-6 offset-3 pb-4">
            <div class="d-flex">
                <div>
                    <img
                        src="\storage\{{$book->cover_image}}"
                        style="width:100px;",
                        class="pt-0 mb-4 mr-4"
                    >
                </div>
                <div class="small align-text-top">{{$book->blurb}}</div>
            </div>
        </div>

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

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row col-6 offset-3">
            <div class="h3">{{ $genre->name }}</div>
        </div>

        <div class="row col-6 offset-3">

        <div class="">
            @foreach($books as $b)
                <div class="d-flex pb-3 mb-4">
                    <div class="pr-3">
                        <a href="/books/{{$b->id}}">
                            <img
                                src="{{\App\Http\Controllers\BookController::getCoverImage($b)}}"
                                class=""
                                style="max-width:150px;"
                            ></img>
                        </a>
                    </div>
                    <div class="pr-3 panel">
                        <div>{{ $b->title }}</div>
                        <div class="small mb-2">by
                            <a href="/profile/{{ $b->user->profile->profile_link }}">
                                {{ $b->author_name }}
                            </a>
                        </div>
                        <div style="">{{ substr($b->blurb, 0, 200) . '...' }}</div>
                        <div class="pt-2"><a href="/books/{{$b->id}}">read more ...</a></div>
                        <div class="pt-2">Avg rating: <span class="font-weight-bold">
                                        @if($b->review && $b->review->count())
                                    {{ \App\Http\Controllers\ReviewController::calculateRating($b->id) }}
                                @endif
                                @if(!$b->review->count())
                                    n/a
                                @endif
                                    </span>
                        </div>
                        <div class="pt-0 small">From ({{$b->review->count()}})
                            <a href="/books/{{$b->id}}/reviews">reviews</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-6 offset-3 align-content-center">{{$books->links()}}</div>
        </div>
    </div>
@endsection

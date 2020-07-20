@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="h3">
            Search Results
        <hr>
        </div>
        @if(count($return_data['genres']))
            <div class="row col-6 offset-3 pt-2">
                <div class="h3">Genres</div>
            </div>
            <div class="row col-6 offset-3">
            @foreach($return_data['genres'] as $g)
                <div><a href="/genres/{{$g->link}}"> {{ $g->name }}</a></div>
            @endforeach
        </div>
        @endif

        @if(count($return_data['authors']))
            <div class="row col-6 offset-3">
                <div class="h3">Authors</div>
            </div>
            <div class="row col-6 offset-3">
                @foreach($return_data['authors'] as $a)
                    <div><a href="/profile/{{$a->profile->profile_link}}"> {{ $a->name }}</a></div>
                @endforeach
            </div>
        @endif

        @if(count($return_data['books']))
            <div class="row col-6 offset-3">
                <div class="h3">Books</div>
            </div>
                @foreach($return_data['books'] as $b)
                    <div class="d-flex pb-3 mb-4" style="min-width: 200px;">
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
        @endif

    </div>

@endsection

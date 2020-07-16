@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                <img src="{{$cover_image}}" alt="{{$book->title}}" class="img-fluid img-thumbnail">
                <div class="pt-2 text-center"><a href="/books/review/{{$book->id}}">Review Book</a></div>
                <div class="pt-2 text-center">[Star Rating Placeholder]</div>
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
    </div>

@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row col-6 offset-3">
            <div class="h3">Browse Genres</div>
        </div>
        <div class="row col-6 offset-3 panel">
            @foreach($genres as $genre)
                <div class="genre">
                    <a href="genres/{{$genre->link}}" class="text-dark">
                        {{ $genre->name }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

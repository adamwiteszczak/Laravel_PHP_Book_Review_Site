@extends('layouts.app')

@section('content')
    <div class="container">

        @foreach($list as $letter => $authors)
            <div class="row col-6">
                <div>
                    <div class="h3">{{$letter}}</div>
                    @foreach($authors as $author)
                        <div class="small ml-5">
                            <a href="/profile/{{$author['link']}}">
                                {{$author['name']}}
                            </a>
                        </div>
                    @endforeach

                    @if(!count($authors))
                        <div class="small ml-5">...</div>
                    @endif
                    <hr>
                </div>
            </div>
        @endforeach
    </div>

@endsection

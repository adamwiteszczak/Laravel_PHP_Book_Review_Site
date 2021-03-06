@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row col-6 offset-3">
            <div class="h3">Edit Book</div>
        </div>
        <form action="/books/edit/{{$book->id}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group row col-6 offset-3">
                <label for="author_name" class="col-md-4 col-form-label">Author</label>

                <input
                    id="author_name"
                    type="text"
                    class="form-control @error('author_name') is-invalid @enderror"
                    name="author_name"
                    value="{{ old('author_name') ?? $book->author_name }}"
                    autocomplete="author_name"
                    autofocus
                >

                @error('author_name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group row col-6 offset-3">
                <label for="title" class="col-md-4 col-form-label">Title</label>

                <input
                    id="title"
                    type="text"
                    class="form-control @error('title') is-invalid @enderror"
                    name="title"
                    value="{{ old('title') ?? $book->title}}"
                    autocomplete="title"
                >

                @error('title')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group row col-6 offset-3">
                <label for="genre_id" class="col-md-4 col-form-label">Genre</label>

                <select
                    id="genre_id"
                    class="form-control"
                    name="genre_id"
                    autocomplete="genre_id"
                >
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}"
                            {{ $book->genre->id == $genre->id ? 'SELECTED' : '' }}
                        >{{ $genre->name }}</option>
                    @endforeach
                </select>
                @error('genre_id')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group row col-6 offset-3">
                <label for="blurb" class="col-md-4 col-form-label">Blurb</label>

                <textarea
                    id="blurb"
                    type="text"
                    class="form-control @error('blurb') is-invalid @enderror"
                    name="blurb"
                    autocomplete="blurb"
                >{{ old('blurb') ?? $book->blurb}}</textarea>

                @error('blurb')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group row col-6 offset-3">
                <label for="store_link" class="col-md-4 col-form-label">
                    Store Page URL? (e.g. url to Amazon store page, or your website)
                </label>

                <input
                    id="store_link"
                    type="text"
                    class="form-control @error('store_link') is-invalid @enderror"
                    name="store_link"
                    value="{{ old('store_link') ?? $book->store_link }}"
                    autocomplete="store_link"
                >

                @error('store_link')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group row col-6 offset-3">
                <label for="cover_image" class="col-form-label">Cover Image</label>
                <input type="file" class="form-control-file" id="cover_image" name="cover_image">
            </div>

            <div class="form-group row col-6 offset-3">
                <button class="btn btn-primary">Update</button>
            </div>

        </form>

        <form action="/books/{{$book->id}}" method="post" enctype="application/x-www-form-urlencoded">
        @csrf
        @method('DELETE')
            <div class="form-group row col-6 offset-3">
                <button class="btn btn-danger">Delete Book?</button>
            </div>
        </form>

    </div>
@endsection

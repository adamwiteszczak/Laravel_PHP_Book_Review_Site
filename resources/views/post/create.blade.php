@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row col-6 offset-3">
            <div class="h3">Create new blog post:</div>
        </div>
        <form action="/post" method="post" enctype="application/x-www-form-urlencoded">
            @csrf
            @method('PUT')

            <div class="form-group row col-6 offset-3">
                <label for="title" class="col-md-4 col-form-label">Title</label>
                <input
                    id="title"
                    type="text"
                    class="form-control @error('title') is-invalid @enderror"
                    name="title"
                    value="{{ old('title')}}"
                    autocomplete="title"
                    autofocus
                >
            </div>

            <div class="form-group row col-6 offset-3">
                <label for="review" class="col-md-4 col-form-label">Your thoughts?</label>
                <textarea
                    class="form-control @error('entry') is-invalid @enderror"
                    id="entry"
                    name="entry"
                    autofocus
                    cols="10"
                    rows="10"
                >{{ old('entry') }}</textarea>

                @error('entry')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group row col-6 offset-3">
                <button class="btn btn-primary">Submit Post</button>
            </div>

        </form>
    </div>
@endsection

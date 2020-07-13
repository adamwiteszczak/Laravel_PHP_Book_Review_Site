@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row col-6 offset-3">
            <div class="h3">Edit Profile</div>
        </div>
        <form action="/profile/" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group row col-6 offset-3">
                <label for="displayname" class="col-md-4 col-form-label">Name</label>

                <input
                    id="displayname"
                    type="text"
                    class="form-control @error('displayname') is-invalid @enderror"
                    name="displayname"
                    value="{{ old('displayname') ?? $user->name }}"
                    autocomplete="displayname"
                    autofocus
                >

                @error('displayname')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group row col-6 offset-3">
                <label for="description" class="col-md-4 col-form-label">About You</label>

                <textarea
                    id="description"
                    class="form-control @error('description') is-invalid @enderror"
                    name="description"
                    autocomplete="description"
                >{{ old('description') ?? $user->profile->description }}</textarea>

                @error('description')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group row col-6 offset-3">
                <label for="twitter_handle" class="col-md-4 col-form-label">Twitter handle</label>

                <input
                    id="twitter_handle"
                    type="text"
                    class="form-control @error('twitter_handle') is-invalid @enderror"
                    name="twitter_handle"
                    value="{{ old('twitter_handle') ?? $user->profile->twitter_handle }}"
                    autocomplete="twitter_handle"
                    autofocus
                >

                @error('twitter_handle')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group row">
                <div class="d-flex col-3 offset-3">
                    <div>
                        <img src="{{ $user->profile->getProfileImage() }}" alt="profile image" class="w-100 rounded-circle">
                    </div>
                </div>
                <div class="col-3">
                    <label for="image" class="col-form-label">Profile Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
            </div>

            <div class="form-group row col-6 offset-3">
                <button class="btn btn-primary">Update</button>
            </div>

        </form>
    </div>
@endsection

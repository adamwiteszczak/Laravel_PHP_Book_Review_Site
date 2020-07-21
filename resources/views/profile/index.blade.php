@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-2 align-content-center">
            <img src="{{ $user_profile_image }}" class="w-100 rounded-circle">
            <div class="pt-4 align-content-center text-center">
                @if(!$hide_follow_button)
                <follow-button
                    user-uuid="{{ $user->uuid }}"
                    follows="{{ $follows }}"
                ></follow-button>
                @endif
            </div>

            @if($user->profile->twitter_handle)
            <div class="pt-4 align-content-center text-center d-flex">
                <div>
                    <img src="/img/Twitter_Logo_Blue.png" style="width:25px">
                </div>
                <div class="align-items-baseline">
                    <a href="https://twitter.com/{{ $user->profile->twitter_handle }}" target="_blank">
                        {{ $user->profile->twitter_handle }}
                    </a>
                </div>
            </div>
            @endif

            @if($user->profile->website_url)
                <div class="align-content-center text-center d-flex">
                    <div>
                        <span class="glyphicon glyphicon-globe" style="width:25px"></span>
                    </div>
                    <div class="align-items-baseline">
                        <a href="{{ $user->profile->website_url }}" target="_blank">
                            {{ $user->profile->website_url }}
                        </a>
                    </div>
                </div>
            @endif

            @if($user->profile->profile_type == 'author')
                <div class="mt-2">
                    <a href="/post">
                        <button class="btn btn-success">Create Blog Post</button>
                    </a>
                </div>
            @endif

        </div>
        <div class="col-6">
            <div class="d-flex">
                <div class="h3 pr-2">{{ $user->name }}</div>
                <div class="font-weight-lighter small text-capitalize mt-2" style="color: #bbb;">
                    ({{ $user->profile->profile_type }})
                </div>
            </div>
            @can('update', $user->profile)
                <div class="d-flex">
                    <div class="small pb-2"><a href="/profile/edit">Edit Profile</a></div>
                    @if($user->profile->profile_type == 'author')
                        <div class="small pl-4"><a href="/books/create">Add Your Book</a></div>
                    @endif
                </div>
            @endcan
            <div class="d-flex">
                <div class="pr-4 small"><following-count link="{{ $user->profile->profile_link }}"></following-count></div>
                @if($user->profile->profile_type == 'author')
                    <div class="pr-4 small"><follower-count link="{{ $user->profile->profile_link }}"></follower-count></div>
                @endif
            </div>
            <div class="pt-4"> {{ $user->profile->description }}</div>
        </div>

        @if($user->profile->profile_type == 'author')
        <div class="col-6 offset-2 pt-4">
            <div class="h3">Books by {{ $user->name }}</div>
            <hr>
            <div class="">
                @foreach($user->book as $b)
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
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

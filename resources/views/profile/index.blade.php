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
                    <img src="img/Twitter_Logo_Blue.png" style="width:25px">
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

        </div>
        <div class="col-6">
            <div class="d-flex">
                <div class="h3 pr-2">{{ $user->name }}</div>
                <div class="font-weight-lighter small text-capitalize mt-2" style="color: #bbb;">
                    ({{ $user->profile->profile_type }})
                </div>
            </div>
            @can('update', $user->profile)
                <div class="small pb-2"><a href="/profile/edit">Edit Profile</a></div>
            @endcan
            <div class="d-flex">
                <div class="pr-4 small"><following-count link="{{ $user->profile->profile_link }}"></following-count></div>
                @if($user->profile->profile_type == 'author')
                    <div class="pr-4 small"><follower-count link="{{ $user->profile->profile_link }}"></follower-count></div>
                @endif
                <div class="pr-4 small">Reviews <strong>2</strong></div>
            </div>
            <div class="pt-4"> {{ $user->profile->description }}</div>
        </div>
    </div>
</div>
@endsection

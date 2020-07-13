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
                <div class="pr-2 small">Following <strong>65</strong> </div>
                @if($user->profile->profile_type == 'author')
                    <div class="pr-2 small">Readers <strong>18</strong></div>
                @endif
                <div class="pr-2 small">Reviews <strong>2</strong></div>
            </div>
            <div class="pt-4"> {{ $user->profile->description }}</div>
        </div>
    </div>
</div>
@endsection

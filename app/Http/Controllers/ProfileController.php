<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /** helper functions todo move these out to their own helper class */
    public static function getProfileImage($user)
    {
        if (!$user->profile->image || $user->profile->image == '/img/noimage.jpg') {
            return '/img/noimage.jpg';
        }

        return '/storage/'. $user->profile->image;
    }

    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect('/');
        }

        $follows = false; // you can't follow yourself
        $hide_follow_button = true;

        $user_profile_image = $this->getProfileImage($user);

        return view('profile/index', compact(
            'user_profile_image',
            'user',
            'follows',
            'hide_follow_button'
        ));
    }

    public function show($link)
    {
        $profile = Profile::where('profile_link', '=', $link)->firstOrFail();
        $user = $profile->user;
        $user_profile_image = $this->getProfileImage($user);

        $auth_user = auth()->user();
        $hide_follow_button = true;
        $follows = false;

        if ($auth_user && $auth_user->uuid != $user->uuid) {
            //unhide the button if you are not viewing your own profile
            $follows = auth()->user()->following->contains($user->profile->uuid);
            $hide_follow_button = false;
        }

        return view(
            'profile/index',
            compact(
                'user_profile_image',
                'user',
                'follows',
                'hide_follow_button'
            )
        );
    }

    public function update()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        $this->authorize('update', $user->profile);

        $data = request()->validate(
            array(
                'displayname' => array('required', 'min:3', 'max:255'),
                'description' => '',
                'twitter_handle' => '',
                'website_url' => '',
                'image' => ''
            )
        );

        $user->update(array(
            'name' => $data['displayname']
        ));

        $profile_data = array(
            'description' => $data['description']
        );

        if (array_key_exists('twitter_handle', $data)) {
            request()->validate(['twitter_handle', 'string']);
            $profile_data['twitter_handle'] = $data['twitter_handle'];
        } else {
            $profile_data['twitter_handle'] = ''; //delete the existing one if they send no value
        }

        if (array_key_exists('website_url', $data)) {
            request()->validate(['website_url', 'url']);
            $profile_data['website_url'] = $data['website_url'];
        } else {
            $profile_data['website_url'] = ''; //delete the existing one if they send no value
        }

        if (request('image')) {
            request()->validate(['image' => 'image']);
            $profile_data['image'] = request('image')->store('profile', 'public');
            $image = Image::make(public_path('storage/' . $profile_data['image']))->fit(400, 400);
            $image->save();

            // delete the existing user profile image to save space:
            Storage::disk('public')->delete($user->profile->image);
        }

        $user->profile()->update($profile_data);

        //@todo add option to set a new link address for the user - a tick box they select on the edit form

        return redirect('/profile');
    }

    //display the edit profile panel
    public function edit()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect('/login');
        }

        $this->authorize('update', $user->profile);
        return view('profile/edit', compact('user'));
    }

    public function followerCount($link)
    {
        $profile = Profile::where('profile_link', '=', $link)->firstOrFail();
        return json_encode(
            array('follower_count' => $profile->followers->count())
        );
    }

    public function followingCount($link)
    {
        $profile = Profile::where('profile_link', '=', $link)->firstOrFail();
        return json_encode(
            array('following_count' => $profile->user->following->count())
        );
    }

    public static function createProfileLink(string $name)
    {
        $link = str_replace(" ", "-", $name);

        //check db to see if this name is available:
        $exists = DB::table('profiles')
            ->select('profile_link')
            ->where('profile_link', '=', $link)
            ->count();

        if ($exists) {
            $count = DB::table('profiles')
                ->select('profile_link')
                ->where('profile_link', 'like', $link . '_%')
                ->count();
            $link .= '_' . ($count + 1);
        }

        return strtolower($link);
    }

    private function getFollowerCount(User $user)
    {
        return $user->followers->count();
    }
}

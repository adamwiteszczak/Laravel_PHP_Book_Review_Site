<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /** helper functions */
    public function getProfileImage($user)
    {
        return ($user->profile->image) ? '/storage/'. $user->profile->image : '/img/noimage.jpg';
    }


    public function index()
    {
        $user_profile_image = $this->getProfileImage(auth()->user());
        $user = auth()->user();
        return view('profile/index', compact('user_profile_image', 'user'));
    }

    public function show($link)
    {
        $profile = Profile::where('profile_link', '=', $link)->firstOrFail();
        $user = $profile->user;
        $user_profile_image = $this->getProfileImage($user);

        return view('profile/index', compact('user_profile_image', 'user'));
    }

    public function update()
    {
        $user = auth()->user();

        $data = request()->validate(
            array(
                'displayname' => array('required', 'min:3', 'max:255'),
                'description' => '',
                'twitter_handle' => '',
                'image' => ''
            )
        );

        $user->update(array(
            'name' => $data['displayname']
        ));

        $profile_data = array(
            'description' => $data['description'],
            'twitter_handle' => $data['twitter_handle']
        );

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
        return view('profile/edit', compact('user'));
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
}

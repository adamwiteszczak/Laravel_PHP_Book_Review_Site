<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        $user_profile_image = (auth()->user()->profile->image) ? auth()->user()->profile->image : 'img/noimage.jpg';
        $user = auth()->user();

        return view('profile/index', compact('user_profile_image', 'user'));
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

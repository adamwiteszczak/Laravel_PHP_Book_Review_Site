<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public static function createProfileLink(string $name)
    {
        //@todo check that this is unique in the DB
        $link = str_replace(" ", "-", $name);
        return strtolower($link);
    }
}

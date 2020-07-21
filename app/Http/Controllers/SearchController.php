<?php

namespace App\Http\Controllers;

use App\Book;
use App\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class SearchController extends Controller
{
    public function index()
    {
        $data = request()->validate(['search' => 'required']);

        $return_data = array(
            'books' => array(),
            'authors' => array(),
            'genres' => array()
        );

        //search authors
        $authors = DB::table('users')
            ->join('profiles', 'profiles.user_uuid', '=', 'users.uuid')
            ->where('profiles.profile_type', '=', 'author')
            ->where('users.name', 'like', '%' . $data['search'] .'%')
            ->select('users.uuid')
            ->orderBy('users.name', 'asc')
            ->get();

        $uuids = array();
        foreach ($authors as $author) {
            $uuids[] = $author->uuid;
        }
        if (!empty($uuids)) {
            $return_data['authors'] = User::find($uuids);
        }

        $books = DB::table('books')
            ->where('title', 'like', '%' . $data['search'] . '%')
            ->orderBy('title', 'asc')
            ->select('id')
            ->get();

        $book_uuids = array();
        foreach ($books as $book) {
            $book_uuids[] = $book->id;
        }

        if (!empty($book_uuids)) {
            $return_data['books'] = Book::find($book_uuids);
        }

        $genres = DB::table('genres')
            ->where('name', 'like', '%' . $data['search'] . '%')
            ->orderBy('name', 'asc')
            ->select('id')
            ->get();

        $genre_uuids = array();
        foreach ($genres as $genre) {
            $genre_uuids[] = $genre->id;
        }

        if (!empty($genre_uuids)) {
            $return_data['genres'] = Genre::find($genre_uuids);
        }

        return view('/search/show', compact('return_data'));
    }

    public function authors()
    {
        $authors = DB::table('users')
            ->join('profiles', 'profiles.user_uuid', '=', 'users.uuid')
            ->where('profiles.profile_type', '=', 'author')
            ->select('users.name', 'profiles.profile_link')
            ->get();

        $list = range("A", "Z");
        $list = array_flip($list);

        foreach ($list as $letter => $position) {
            $list[$letter] = array();
        }

        foreach ($authors as $a) {
            $name = explode(" ", $a->name);
            $last = last($name);
            $list[strtoupper($last[0])][] = array(
                'name' => implode(", ", array_reverse($name)),
                'link' => $a->profile_link
            );
        }

        foreach ($list as $letter => &$entries) {
            usort($entries, function ($a, $b) {
                return strcmp($b['name'], $a['name']);
            });
        }

        return view('/search/authors', compact('list'));
    }
}

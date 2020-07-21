<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('/post/create');
    }

    public function store()
    {
        $this->authorize('create', Post::class);
        $data = request()->validate(array(
            'title' => ['required', 'min:10'],
            'entry'=> ['required', 'min:100']
        ));

        $data['user_uuid'] = auth()->user()->uuid;

        Post::create($data);
        return redirect('/profile');
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}

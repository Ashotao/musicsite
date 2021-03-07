<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Rules\CorrectLink;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Song;

class SongController extends Controller
{
    public function index()
    {
        return User::find(auth()->user()->id)->songs;
    }

    public function create(Request $request)
    {
        $validated = $this->validate($request, ['link' => new CorrectLink(), 'name' => 'required|max:50']);
        Song::create([
            'link' => request()->link,
            'name' => request()->name,
            'lenght' => 333,
        ])->users()->attach(auth()->user()->id);

        return redirect('/music');
    }


}

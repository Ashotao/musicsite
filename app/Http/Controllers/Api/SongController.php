<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Song;

class SongController extends Controller
{
    public function index()
    {
      return User::with('songs')->find(auth()->user()->id);
    }

    public function addSong()
    {
        Song::create([
            'link' => request()->link,
            'name' => 'test',
            'lenght' => 333,
        ])->users()->attach(auth()->user()->id);

        return redirect('/music');
    }
}

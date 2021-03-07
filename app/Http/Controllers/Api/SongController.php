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
       return User::find(auth()->user()->id)->songs()->orderBy('id', 'DESC')->paginate(20);
    }

    public function create(Request $request)
    {
        $validated = $this->validate($request, ['link' => new CorrectLink(), 'name' => 'required|max:50']);

        preg_match('/[\?\&]v=([^\&]*)/', request()->link, $ok);
        if(!empty($ok[1])){
            $link = trim($ok[1]);
        } else {
            $link = request()->link;
        }

        Song::create([
            'link' => $link,
            'name' => request()->name,
            'lenght' => 333,
        ])->users()->attach(auth()->user()->id);

        return redirect('/music');
    }


}

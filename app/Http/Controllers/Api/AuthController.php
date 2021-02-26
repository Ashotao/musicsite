<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function registration(Request $request)
    {
        $validatedData = $request->validate([
            'nickname' => 'max:25',
            'login' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        if ($validatedData['nickname'] === NULL) {
            $validatedData['nickname'] = $validatedData['login'];
        }

        User::create([
           'nickname' => $validatedData['nickname'],
           'login' => $validatedData['login'],
           'email' => $validatedData['email'],
           'password' => $validatedData['password']
        ]);

        return redirect('/');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'login' => 'required|min:3',
            'password' => 'required|min:6'
        ]);
        
        User::get('password')->where('login', $validatedData['login']);
        return 123;
    }
}

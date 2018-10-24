<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserByInvite(User $user)
    {
        return view('userinvite', ['user' => $user]);
    }

    public function postUserByInvite(Request $request, User $user)
    {
        $request->validate([
            'password'   => 'nullable|string|min:4|confirmed',
            'sex'        => 'required',
            'location'   => 'required|string|max:255',

        ]);

        $user->sex       = $request['sex'];
        $user->password  = trim(bcrypt($request['password']));
        $user->location  = $request['location'];

        $user->save();

        return redirect()->route('login');
    }

}

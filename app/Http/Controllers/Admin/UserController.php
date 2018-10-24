<?php

namespace App\Http\Controllers\Admin;

use App\Invitation;
use App\User;
use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use League\Flysystem\Config;
use Symfony\Component\Routing\Route;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.users', [
            'users' => User::with('status')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.users.store', [
           'statuses'   => Status::get(),
           ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|max:255',
            'sex'        => 'required',
            'location'   => 'required|string|max:255',
            'status'     => 'required ',
        ]);

        User::create([
            'name'              => $request['name'],
            'email'             => $request['email'],
            'password'          => trim(bcrypt($request['email'])),
            'sex'               => $request['sex'],
            'location'          => $request['location'],
            'status_id'         => $request['status'],
            'registration_date' => Carbon::now(),
        ]);

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user'      => $user,
            'statuses'  => Status::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
       $validator = $request->validate([
           'name'       => 'required|string|max:255',
           'email'      => [
               'required',
               'string',
               'email',
               'max:255',
               Rule::unique('users')->ignore($user->id)
           ],
           'password'   => 'nullable|string|min:4',
           'sex'        => 'required',
           'location'   => 'required|string|max:255',
           'status'     => 'required ',
       ]);

       $user->name      = $request['name'];
       $user->email     = $request['email'];
       $user->sex       = $request['sex'];
       $user->password  = $request['password'] === null ? $user->password : trim(bcrypt($request['password']));
       $user->location  = $request['location'];
       $user->status_id = $request['status'];

       $user->save();
       return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $removedStatus = Status::where('name', 'removed')->pluck('id')->first();
        $user->update(['status_id' => $removedStatus]);
        return redirect()->back();
    }

    public function wachIvite(Request $request , $inviteStr)
    {
        $invite = Invitation::whereHas('status', function($q) {
            $q->where('name', 'invited');
        })->where('invite_code', $inviteStr)->first();

        if($invite) {
            $user = User::where('email', $invite->email)->first();

            if ($user) {
                return redirect()->route('login');
            }
            $user = User::create([
                'name'              => $invite->name,
                'email'             => $invite->email,
                'password'          => bcrypt('12345'),
                'status_id'         => Status::where('name', 'invited')->pluck('id')->first(),
                'registration_date' => Carbon::now(),
            ]);
            return redirect()->route('invited-user', $user);
        }
//
       return abort(404);
    }

}

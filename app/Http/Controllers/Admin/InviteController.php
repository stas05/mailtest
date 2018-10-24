<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Invitation;
use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.invites.invite', [
           'invites' => Auth::user()->isAdmin() ? Invitation::with('getUser')->get() : Invitation::with('getUser')->where('user_id', Auth::user()->id)->get(),
       ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.invites.store', [
            'statuses' => Status::get(),
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
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'author'        => 'required',
            'invite_text'   => 'required'
        ]);

        $inviteCode     = str_random(10) . time();
        $link           = $request->getHttpHost() . '/invites/' . $inviteCode;
        $statusInvite   = Status::where('name', 'registered')->pluck('id')->first();

        $invite = Invitation::create([
                    'name'              => $request['name'],
                    'email'             => $request['email'],
                    'user_id'           => $request['author'],
                    'link'              => $link,
                    'invite_code'       => $inviteCode,
                    'text_of_invite'    => $request['invite_text'],
                    'status_id'         => $statusInvite,
                ]);

        return redirect()->route('admin.invites.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function show(Invitation $invitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function edit(Invitation $invite)
    {
        return view('admin.invites.edit', [
            'invite'   => $invite,
            'statuses' => Status::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invitation $invite)
    {
        $validator = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255',
            'invite_text'       => 'required|string'
        ]);

        $invite->name           = $request['name'];
        $invite->email          = $request['email'];
        $invite->text_of_invite = $request['invite_text'];
        $status = Status::where('name', 'registered')->pluck('id')->first();
        $invite->status_id = $status;

        $invite->save();

        return redirect()->route('admin.invites.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invitation $invitation)
    {
        //
    }

    /**
     * Function for send mail
     */
    public function send(Request $request)
    {
        $invite = Invitation::find($request['invite_id']);

        // code for send
        $invite->changeStatusOnInvite();
        $invite->sent_date = Carbon::now();
        $invite->save();
        return redirect()->back();
    }
}

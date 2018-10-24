<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'link',
        'invite_code',
        'text_of_invite',
        'sent_date',
        'status_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    // Get user

    public function getUser()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function changeStatusOnInvite()
    {
        $status = Status::where('name', 'invited')->pluck('id')->first();
        return $this->update(['status_id' => $status]);
    }

    public function isInvited()
    {
        return $this->status->where('name', 'invited');
    }

}

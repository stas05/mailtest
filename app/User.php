<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'sent_date',
        'registration_date',
        'date_of_last_sign_in',
        'sex',
        'location',
        'status_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Get role

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    // Get Invintations

    public function invintations()
    {
        return $this->hasMany('App\Invitation');
    }

    // Check on Admin rights

    public function isAdmin()
    {
        return $this->roles()->where('description', 'Main Admin')->exists();
    }

    // Get status

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function isBlocked()
    {
        return in_array($this->status->name, ['blocked', 'removed']);
    }
}

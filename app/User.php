<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // set the primary key to be the uuid
    protected $primaryKey = 'uuid';

    protected static function boot()
    {
        parent::boot();

        //create a uuid for a new user
        static::creating(function($user){
            $user->uuid = (string) Str::uuid();
        });
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}

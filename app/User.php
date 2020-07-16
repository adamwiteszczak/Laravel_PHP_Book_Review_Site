<?php

namespace App;

use App\Http\Controllers\ProfileController;
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
    public $incrementing = false; // this needs setting because we're using uuid instead of int.

    protected static function boot()
    {
        parent::boot();

        //create a uuid for a new user
        static::creating(function($user){
            $user->uuid = (string) Str::uuid();
        });

        static::created(function($user) {

            $user->profile()->create(array(
                'description' => 'A little about me ...',
                'profile_type' => request()->get('profile-type'),
                'profile_link' => ProfileController::createProfileLink($user->name),
            ));
        });
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function following()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function book()
    {
        return $this->hasMany(Book::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }
}

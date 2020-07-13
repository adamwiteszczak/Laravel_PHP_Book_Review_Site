<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profile extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false; // this needs setting because we're using uuid instead of int.

    protected $fillable = array('description', 'profile_type', 'profile_link');

    protected static function boot()
    {
        parent::boot();

        //create a uuid for a new profile
        static::creating(function ($profile) {
            $profile->uuid = (string)Str::uuid();
        });
    }

    public function getProfileImage()
    {
        if ($this->image) {
            return '/storage/' . $this->image;
        }
        return '/img/noimage.jpg';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }
}

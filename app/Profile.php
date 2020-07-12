<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profile extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false; // this needs setting because we're using uuid instead of int.

    protected $fillable = array('description', 'profile_type');

    protected static function boot()
    {
        parent::boot();

        //create a uuid for a new profile
        static::creating(function ($profile) {
            $profile->uuid = (string)Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}

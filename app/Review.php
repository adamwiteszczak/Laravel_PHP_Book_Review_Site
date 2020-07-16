<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $guarded = [];

    protected static function boot()
    {
        parent::boot();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

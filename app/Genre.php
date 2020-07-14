<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected static function boot()
    {
        parent::boot();
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

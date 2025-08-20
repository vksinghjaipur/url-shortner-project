<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    

    protected $fillable = ['name'];


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function urls()
    {
        return $this->hasManyThrough(ShortUrl::class, User::class);
    }
}

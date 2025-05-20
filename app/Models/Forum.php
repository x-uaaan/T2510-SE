<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    public function admin()
    {    return $this->belongsTo(Admin::class);    }

    public function posts()
    {    return $this->hasMany(Post::class);    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $primaryKey = 'forumID';
    public $incrementing = true;
    protected $keyType = 'int';

    public function posts()
    {
        return $this->hasMany(Post::class, 'forumID', 'forumID');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $table = 'forums';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'forumID';
    
    protected $fillable = [
        'forumID',
        'forumTitle',
        'forumDesc',
        'organiserName',
        'organiserID',
        'Categories',
    ];

    public function organiser()
    {
        return $this->belongsTo(User::class, 'organiserID', 'userID');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'forumID', 'forumID');
    }
}

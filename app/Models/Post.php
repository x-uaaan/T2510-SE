<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'postID';

    protected $fillable = [
        'postID',
        'postTitle',
        'postDesc',
        'comment',
        'timestamp',
        'forumID',
        'userID'
    ];

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forumID', 'forumID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }
}

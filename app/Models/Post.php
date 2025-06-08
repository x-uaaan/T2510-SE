<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $primaryKey = 'postID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'postTitle',
        'postDesc',
        'comment',
        'timestamp',
        'forumID',
        'alumniID'
    ];

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forumID', 'forumID');
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumniID', 'alumniID');
    }
}

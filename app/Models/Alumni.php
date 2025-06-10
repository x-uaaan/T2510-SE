<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = 'alumni';
    protected $primaryKey = 'alumniID';

    protected $fillable = [
        'alumniName',
        'alumniEmail',
        'alumniPhone',
        'alumniFaculty',
        'alumniResume'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'alumniEmail', 'email');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'alumniID', 'alumniID');
    }
}

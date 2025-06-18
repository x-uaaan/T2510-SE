<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $table = 'lecturers';
    protected $primaryKey = 'lecturerID';

    protected $fillable = [
        'lecturerName',
        'lecturerEmail',
        'lecturerPhone',
        'lecturerFaculty'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'lecturerEmail', 'email');
    }
}

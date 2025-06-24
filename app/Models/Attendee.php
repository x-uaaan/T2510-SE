<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    protected $table = 'attendees';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'attendeesID';
    public $timestamps = false;

    protected $fillable = [
        'attendeesID',
        'eventID',
        'userID',
        'created_at',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'eventID', 'eventID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }
}

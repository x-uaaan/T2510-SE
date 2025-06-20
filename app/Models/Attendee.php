<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $table = 'attendees';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'attendeesID';

    protected $fillable = [
        'attendeesID',
        'eventID',
        'userID'
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

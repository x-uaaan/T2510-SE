<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'eventID';

    public function organiser()
    {
        return $this->belongsTo(User::class, 'organiserID', 'userID');
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class, 'eventID', 'eventID');
    }

    protected $fillable = [
        'eventID',
        'eventName',
        'eventDesc',
        'startDate',
        'startTime',
        'endDate',
        'endTime',
        'eventVenue',
        'capacity',
        'organiserName',
        'organiserID',
        'image',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function admin()
    {    return $this->belongsTo(Admin::class);    }

    public function attendees()
    {    return $this->hasMany(Attendee::class);    }

    protected $primaryKey = 'eventID'; // if your PK is eventID, not id

    protected $fillable = [
        'eventName',
        'eventImage',
        'startDate',
        'startTime',
        'endDate',
        'endTime',
        'eventDesc',
        'eventVenue',
        'capacity',
        'organiser',
        'organiserID',
    ];
}
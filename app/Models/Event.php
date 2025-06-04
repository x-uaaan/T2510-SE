<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function admin()
    {    return $this->belongsTo(Admin::class);    }

    public function attendees()
    {    return $this->hasMany(Attendee::class);    }
    protected $fillable = [
        'eventName',
        'eventDesc',
        'eventDate',
        'eventTime',
        'eventVenue',
        'capacity',
        'organiser',
        'image',
    ];
}
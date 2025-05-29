<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function admin()
    {    return $this->belongsTo(Admin::class);    }

    public function attendees()
    {    return $this->hasMany(Attendee::class);    }
    protected $fillable = ['organiser', 'event_title', 'start_time', 'end_time', 'capacity', 'location'];
}
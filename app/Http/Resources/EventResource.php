<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'eventName' => $this->eventName,
            'eventDesc' => $this->eventDesc,
            'eventDate' => $this->eventDate,
            'eventTime' => $this->eventTime,
            'eventVenue' => $this->eventVenue,
            'capacity' => $this->capacity,
            'organiser' => is_object($this->organiser) ? $this->organiser->name : $this->organiser,
        ];
    }
}
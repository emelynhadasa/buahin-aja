<?php

namespace App\Http\Controllers;

use App\Models\Academic;
use App\Models\Art;
use App\Models\Science;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Milestone;
use App\Models\User;

class BrowseController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('user.browse.index', ['events' => $events]);
    }

   public function addEvent(Request $request)
    {
        $validatedData = $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $eventId = $validatedData['event_id'];
        $userId = auth()->id();
        $event = Event::find($eventId);
        $progress = 0;

        $existingEvent = $this->getExistingEvent($event->type, $userId, $eventId);
        $existingMilestone = $this->checkMilestone($userId, $eventId);

        if ($existingEvent or $existingMilestone) {
            return redirect()->route('user.browse')->withErrors(['error' => 'You have already added this event.']);
        }

        $newEvent = $this->addNewEvent($event->type, $userId, $eventId, $progress);
        $newEvent->save();

        return redirect()->route('user.dashboard')->with('success', 'Event added successfully.');
    }

   
    
}

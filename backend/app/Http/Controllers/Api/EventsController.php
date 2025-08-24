<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Event;   
use App\Models\Image;

class EventsController extends Controller   
{
    
    public function addEvent(Request $request)
    {
        
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
            'location' => 'required',
            'price' => 'required',
            'available_time' => 'required',
        ]);

        $now = Carbon::now();

        DB::insert(
            'INSERT INTO events (user_id, name, description, category, location, price, available_time, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $request->user_id,
                $request->name,
                $request->description,
                $request->category,
                $request->location,
                $request->price,
                $request->available_time,
                $now,
                $now
            ]
        );

        
        return response()->json([
            'success' => true,
            'message' => 'Event created successfully!'
        ]);
    }

  
    public function home_card()
    {
        $events = DB::table('events')   
            ->leftJoin('images', 'events.user_id', '=', 'images.user_id')
            ->select(
                'events.*',           
                'images.path as profile_picture'
            )
            ->orderBy('events.event_id', 'desc')  
            ->paginate(10);

       
        return response()->json($events);
    }

   
    public function show($event_id)   
    {
        $event = Event::where('event_id', $event_id)->first();  

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        }

        $image = Image::where('user_id', $event->user_id)->first();
        $event->profile_picture = $image ? url('storage/'.$image->path) : url('storage/default.jpeg');

        return response()->json([
            'success' => true,
            'event' => $event
        ]);
    }

    public function destroy($event_id)
    {
        
        $event = Event::find($event_id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully!'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;    
use App\Models\Image;
use App\Models\Booking;

class EventPageController extends Controller   
{
 
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
        $event->profile_picture = $image ? $image->path : 'default.jpeg';

        return response()->json([
            'success' => true,
            'event' => $event   
        ]);
    }

   
    public function addBookings(Request $request)
    {
        $request->validate([
            'event_id' => 'required|integer',   
            'user_id' => 'required|integer',
            'booking_time' => 'required|string',
            'status' => 'required',
            'payment_status' => 'required',
        ]);

        $booking = new Booking();
        $booking->event_id = $request->event_id;   
        $booking->user_id = $request->user_id;
        $booking->booking_time = $request->booking_time;
        $booking->status = $request->status;
        $booking->payment_status = $request->payment_status;
        $booking->save();

        return response()->json([
            'success' => true,
            'message' => 'Booking completed successfully!',
            'booking' => $booking
        ]);
    }
}

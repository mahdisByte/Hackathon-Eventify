<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Image;
use App\Models\Booking;

class ServicePageController extends Controller
{
    // Show service page with profile picture
    public function show($services_id)
    {
        // Fetch the service
        $service = Service::where('services_id', $services_id)->firstOrFail();

        // Fetch user's profile picture if exists
        $image = Image::where('user_id', $service->user_id)->first();
        $service->profile_picture = $image ? $image->path : 'default.jpeg'; // default in storage/app/public/

        return view('servicePage', compact('service'));
    }

    // Add booking
    public function addBookings(Request $request)
    {
        $request->validate([
            'services_id' => 'required|integer',
            'user_id' => 'required|integer',
            'booking_time' => 'required|string',
            'status' => 'required',
            'payment_status' => 'required',
        ]);

        $booking = new Booking();
        $booking->services_id = $request->services_id;
        $booking->user_id = $request->user_id;
        $booking->booking_time = $request->booking_time;
        $booking->status = $request->status;
        $booking->payment_status = $request->payment_status;
        $booking->save();

        if ($booking) {
            return redirect()
                ->route('services.show', $request->services_id)
                ->with('success', 'Booking completed successfully!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Booking failed. Please try again.');
        }
    }
    // Fetch bookings for logged-in user
public function getUserBookings(Request $request)
{
    // Get the currently authenticated user
    $user = auth()->user(); 

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not authenticated'
        ], 401);
    }

    // Fetch bookings with related service data
    $bookings = Booking::with('service')
        ->where('user_id', $user->id)
        ->get();

    return response()->json([
        'success' => true,
        'bookings' => $bookings
    ]);
}

}

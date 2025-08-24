<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Add a new review for an event.
     */
    public function addReview(Request $request)
    {
        // Validate request
        $request->validate([
            'event_id' => 'required|integer',
            'rating'   => 'required|integer|min:1|max:5',
            'comment'  => 'required|string|max:100',
        ]);

        // Create review
        $review = new Review();
        $review->event_id = $request->event_id;  // Correct field name
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

       
        if ($review) {
            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully',
                'review'  => $review
            ], 201); 
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Operation failed. Please try again.'
            ], 500); 
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Review;

class ReviewController extends Controller
{
    //
    function addReview(Request $request) {

        $request->validate([
            'services_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review = new Review();
        $review->services_id = $request->services_id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        if ($review) {
            return redirect()
                ->route('service.show', $request->services_id) // redirect to service page
                ->with('success', 'Review submitted successfully');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Operation failed. Please try again.');
                
        }
    }

}

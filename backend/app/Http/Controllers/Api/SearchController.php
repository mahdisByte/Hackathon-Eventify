<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->search;

        $events = DB::table('events')   
            ->leftJoin('images', 'events.user_id', '=', 'images.user_id')   
            ->where('events.category', 'like', "%{$searchTerm}%")
            ->select(
                'events.*',                 
                'images.path as profile_picture'
            )
            ->orderBy('events.event_id', 'desc')   
            ->paginate(10);

        return response()->json([
            'success' => true,
            'events' => $events   
        ]);
    }
}

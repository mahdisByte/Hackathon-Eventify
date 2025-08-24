<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\Image;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->search;

        // Fetch services with left join to images
        $services = DB::table('services')
            ->leftJoin('images', 'services.user_id', '=', 'images.user_id')
            ->where('services.category', 'like', "%{$searchTerm}%")
            ->select(
                'services.*',
                'images.path as profile_picture' // null if no image
            )
            ->orderBy('services.services_id', 'desc')
            ->paginate(10);

        return view('home', ['services' => $services]);
    }
}


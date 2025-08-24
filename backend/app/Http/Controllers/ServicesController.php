<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Image;

class ServicesController extends Controller
{
    //
    function addService(Request $request){

        $request->validate([
            'user_id'=>'required',
            'name'=>'required',
            'description'=>'required',
            'category'=>'required',
            'location'=>'required',
            'price'=>'required',
            'available_time'=>'required',
        ]);

        // using sql query
        $now = Carbon::now();

        DB::insert(
            'INSERT INTO services (user_id, name, description, category, location, price, available_time, created_at, updated_at) 
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


        // Flash message
        session()->flash('success', 'Service created successfully!');

        // Redirect to home
        return redirect()->route('home')->with('reload', true);
    }


    // public function home_card() {
    //     // Fetch 10 services per page, ordered by newest first
    //     $services = DB::table('services')
    //                 ->orderBy('services_id', 'desc') // newest first
    //                 ->paginate(10);

    //     return view('home', ['services' => $services]);
    // }

    // public function show($services_id)
    // {
    //     // Fetch the service by its ID
    //     $service = \App\Models\Service::where('services_id', $services_id)->firstOrFail();

    //     // Pass it to your servicePage view
    //     return view('servicePage', compact('service'));
    // }


public function home_card() {
    // Fetch 10 services per page, newest first
    $services = DB::table('services')
                ->leftJoin('images', 'services.user_id', '=', 'images.user_id')
                ->select(
                    'services.*',
                    'images.path as profile_picture' // keep null if no image
                )
                ->orderBy('services.services_id', 'desc')
                ->paginate(10);

    return view('home', ['services' => $services]);
}

public function show($services_id) {
    // Fetch the service by its ID
    $service = Service::where('services_id', $services_id)->firstOrFail();

    // Fetch the user's profile picture if exists
    $image = Image::where('user_id', $service->user_id)->first();
    $service->profile_picture = $image ? $image->path : 'default.jpeg'; // default in storage/app/public/

    return view('servicePage', compact('service'));
}

}

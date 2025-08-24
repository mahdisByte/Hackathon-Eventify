<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\EventPageController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminProfileController;

// ----------------------------
// Public Routes
// ----------------------------

// User Auth
Route::post('signup', [UserAuthController::class, 'signup']);
Route::post('login', [UserAuthController::class, 'login']);

// Admin Auth
Route::post('admin/login', [AdminAuthController::class, 'login']);

// Public Events
Route::get('events', [EventsController::class, 'home_card']);
Route::get('events/{event_id}', [EventsController::class, 'show']);
Route::get('event/{event_id}', [EventPageController::class, 'show']);

// ----------------------------
// Protected Routes (User JWT)
// ----------------------------
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::get('me', [UserAuthController::class, 'me']);
    Route::post('refresh', [UserAuthController::class, 'refresh']);

    Route::post('events', [EventsController::class, 'addEvent']);
    Route::post('addBookings', [EventPageController::class, 'addBookings']);
    Route::post('addReview', [ReviewController::class, 'addReview']);
    Route::post('addPayment', [PaymentController::class, 'addPayment']);
    Route::get('search', [SearchController::class, 'search']);
    Route::post('upload-profile', [ProfileController::class, 'upload']);
    Route::get('profile-pictures', [ProfileController::class, 'show_profile_picture']);
    Route::get('profile', [ProfileController::class, 'getProfile']);
});

// ----------------------------
// Protected Routes (Admin JWT)
// ----------------------------
Route::middleware('auth:admin')->group(function () {
    Route::get('admin-events', [EventsController::class, 'home_card']); 
    Route::post('admin-addEvent', [EventsController::class, 'addEvent']);
    Route::post('admin/logout', [AdminAuthController::class, 'logout']);

    // Optional: Admin homepage route
    Route::get('admin/homepage', function () {
        return response()->json(['msg' => 'Welcome Admin']);
    });
});

Route::middleware('auth:admin')->group(function () {
    Route::get('admin/profile', [AdminProfileController::class, 'getProfile']);
});

// Protected user bookings route
Route::middleware('auth:api')->get('bookings', [EventPageController::class, 'getBookings']);
// Protected route (user must be logged in)
Route::middleware('auth:api')->group(function () {
    
});
Route::get('my-bookings', [EventPageController::class, 'getUserBookings']);




Route::delete('/events/{id}', [EventsController::class, 'destroy']);

Route::middleware('jwt.verify')->get('/user/bookings', [EventPageController::class, 'getUserBookings']);



// Public route: view single event
Route::get('events/{event_id}', [EventPageController::class, 'show']);

// Protected routes (user must be logged in)
Route::middleware('auth:api')->group(function () {

    // Booking
    Route::post('addBookings', [EventPageController::class, 'addBookings']);

    // Review
    Route::post('addReview', [ReviewController::class, 'addReview']);

    // Optional: fetch user's bookings
    Route::get('my-bookings', [EventPageController::class, 'getUserBookings']);
});

Route::get('/event/{event_id}', [EventPageController::class, 'show']);
Route::post('/bookings', [EventPageController::class, 'addBookings']);


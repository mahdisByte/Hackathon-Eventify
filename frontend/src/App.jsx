import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";

import LandingPage from "./Pages/LandingPage";
import LoginPage from "./Pages/LoginPage";
import SignupPage from "./Pages/SignupPage";
import EventForm from "./Pages/EventForm";
import HomePage from "./Pages/HomePage";
import EventPage from "./Pages/EventPage";
import PaymentPage from "./Pages/PaymentPage";
import Profile from "./Pages/ProfilePage";
import AdminLogin from "./Pages/AdminLoginPage";  // Admin Login Page
import HomePageAdmin from "./Pages/HomePageAdmin";

import "./App.css";
import AdminProfile from "./Pages/AdminProfile";
import BookingHistory from "./Pages/BookingHistory";
import Events from "./Pages/Events";

function App() {
  return (
    <Router>
      <Routes>
        {/* Public Routes */}
        <Route path="/" element={<LandingPage />} />      
        <Route path="/login" element={<LoginPage />} />   
        <Route path="/signup" element={<SignupPage />} /> 

        {/* User Routes */}
        <Route path="/homepage" element={<HomePage />} /> 
        <Route path="/event-form" element={<EventForm />} />
        <Route path="/event/:id" element={<EventPage />} />
        <Route path="/payment/:bookingId" element={<PaymentPage />} />
        <Route path="/profile" element={<Profile />} />

        {/* Admin Routes */}
        <Route path="/admin-login" element={<AdminLogin />} />
        <Route path="/homepage-admin" element={<HomePageAdmin />} />

        <Route path="/admin-profile" element={<AdminProfile />} />

        <Route path="/booking-history" element={<BookingHistory />} />

        <Route path="/events" element={<Events/>} />

        {/* Fallback Route */}
        <Route
          path="*"
          element={<h2 className="text-center mt-10">Page Not Found</h2>}
        />
      </Routes>
    </Router>
  );
}

export default App;

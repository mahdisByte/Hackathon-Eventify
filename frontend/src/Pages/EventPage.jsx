import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import axios from "axios";
import "../styles/EventPage.css";

export default function EventPage() {
  const { id } = useParams(); // event_id from route
  const navigate = useNavigate();
  const [event, setEvent] = useState(null);
  const [message, setMessage] = useState("");

  const API_BASE = "http://127.0.0.1:8000/api";
  const token = localStorage.getItem("token");

  const [profile, setProfile] = useState(null); // For user_id in booking
  const [booking, setBooking] = useState({
    event_id: id,
    user_id: "",
    booking_time: "",
    status: "",
    payment_status: "",
  });

  const [review, setReview] = useState({
    event_id: id,
    rating: "",
    comment: "",
  });

  // Fetch profile if logged in
  useEffect(() => {
    if (!token) {
      navigate("/login");
      return;
    }
    axios
      .get(`${API_BASE}/profile`, {
        headers: { Authorization: `Bearer ${token}` },
      })
      .then((res) => {
        if (res.data.success) {
          setProfile(res.data.user);
          setBooking((b) => ({ ...b, user_id: res.data.user.id })); // Set user_id
        }
      })
      .catch(() => console.log("Failed to fetch profile"));
  }, [token, navigate]);

  // Fetch event details
  useEffect(() => {
    axios
      .get(`${API_BASE}/event/${id}`, {
        headers: token ? { Authorization: `Bearer ${token}` } : {},
      })
      .then((res) => {
        if (res.data.success) setEvent(res.data.event);
        else setMessage("❌ Failed to load event");
      })
      .catch(() => setMessage("❌ Failed to load event"));
  }, [id, token]);

  const handleBookingChange = (e) =>
    setBooking({ ...booking, [e.target.name]: e.target.value });

  const handleReviewChange = (e) =>
    setReview({ ...review, [e.target.name]: e.target.value });

  const authHeaders = () => ({
    headers: {
      Authorization: token ? `Bearer ${token}` : "",
    },
  });

  const handleBookingSubmit = (e) => {
    e.preventDefault();
    if (!token) {
      setMessage("❌ Please login first.");
      navigate("/login");
      return;
    }

    axios
      .post(`${API_BASE}/addBookings`, booking, authHeaders())
      .then((res) => {
        if (res.data.success) {
          setMessage("✅ Booking completed successfully!");
          setBooking({
            event_id: id,
            user_id: profile?.id || "",
            booking_time: "",
            status: "",
            payment_status: "",
          });
        }
      })
      .catch((err) => {
        if (err.response && err.response.status === 401) {
          setMessage("❌ Unauthorized. Please login again.");
          localStorage.removeItem("token");
          navigate("/login");
        } else setMessage("❌ Booking failed");
      });
  };

  const handleReviewSubmit = (e) => {
    e.preventDefault();
    if (!token) {
      setMessage("❌ Please login first.");
      navigate("/login");
      return;
    }

    axios
      .post(`${API_BASE}/addReview`, review, authHeaders())
      .then((res) => {
        if (res.data.success) {
          setMessage("✅ Review submitted!");
          setReview({ event_id: id, rating: "", comment: "" });
        }
      })
      .catch((err) => {
        if (err.response && err.response.status === 401) {
          setMessage("❌ Unauthorized. Please login again.");
          localStorage.removeItem("token");
          navigate("/login");
        } else setMessage("❌ Review failed");
      });
  };

  const handlePayment = () => {
    if (!token) {
      setMessage("❌ Please login first.");
      navigate("/login");
      return;
    }
    navigate(`/payment/${booking.event_id}`);
  };

  if (!event) return <p>Loading event...</p>;

  return (
    <div className="container">
      {message && <p className="message">{message}</p>}

      <div className="left-column">
        <img
          src={
            event.profile_picture
              ? `http://127.0.0.1:8000/storage/${event.profile_picture}`
              : `http://127.0.0.1:8000/storage/default.jpeg`
          }
          alt="Profile"
        />
        <h3><strong>User ID:</strong> {event.user_id}</h3>
        <h3><strong>Event ID:</strong> {event.event_id}</h3>
        <h3><strong>Name:</strong> {event.name}</h3>
        <h3><strong>Category:</strong> {event.category}</h3>
        <h3><strong>Location:</strong> {event.location}</h3>
        <h3><strong>Price:</strong> {event.price} Tk</h3>
        <h3><strong>Available Time:</strong> {event.available_time}</h3>
      </div>

      <div className="right-column">
        {/* Booking Form */}
        <div className="form-container">
          <h2>Booking</h2>
          <form onSubmit={handleBookingSubmit}>
            <div className="input-wrapper">
              <label>Event Id</label>
              <input type="number" value={id} name="event_id" readOnly />
            </div>
            <div className="input-wrapper">
              <label>User ID</label>
              <input
                type="number"
                name="user_id"
                value={booking.user_id}
                readOnly
              />
            </div>
            <div className="input-wrapper">
              <label>Booking time</label>
              <input
                type="text"
                name="booking_time"
                value={booking.booking_time}
                onChange={handleBookingChange}
              />
            </div>
            <div className="input-wrapper">
              <label>Status</label>
              <input
                type="text"
                name="status"
                value={booking.status}
                onChange={handleBookingChange}
              />
            </div>
            <div className="input-wrapper">
              <label>Payment Status</label>
              <input
                type="text"
                name="payment_status"
                value={booking.payment_status}
                onChange={handleBookingChange}
              />
            </div>
            <button type="submit">Book</button>
          </form>
        </div>

        {/* Review Form */}
        <div className="form-container">
          <h2>Submit Review</h2>
          <form onSubmit={handleReviewSubmit}>
            <div className="input-wrapper">
              <label>Event ID</label>
              <input type="number" value={id} name="event_id" readOnly />
            </div>
            <div className="input-wrapper">
              <label>Rating (out of 5)</label>
              <input
                type="number"
                min="1"
                max="5"
                name="rating"
                value={review.rating}
                onChange={handleReviewChange}
              />
            </div>
            <div className="input-wrapper">
              <label>Comment</label>
              <textarea
                name="comment"
                value={review.comment}
                onChange={handleReviewChange}
              ></textarea>
            </div>
            <button type="submit">Submit Review</button>
          </form>
        </div>

        {/* Payment Section */}
        <div className="form-container">
          <h2>Payment</h2>
          <p>Is your booking confirmed?</p>
          <button type="button" className="payment-btn" onClick={handlePayment}>
            Pay Now
          </button>
        </div>
      </div>
    </div>
  );
}

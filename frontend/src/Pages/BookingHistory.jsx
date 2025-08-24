import React, { useEffect, useState } from "react";
import axios from "axios";

const UserBookings = () => {
  const [bookings, setBookings] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  useEffect(() => {
    const fetchBookings = async () => {
      try {
        const token = localStorage.getItem("token"); // JWT stored after login
        const response = await axios.get("http://your-api-url/api/user/bookings", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        if (response.data.success) {
          setBookings(response.data.bookings);
        } else {
          setError("Failed to fetch bookings");
        }
      } catch (err) {
        setError(err.response?.data?.message || "Something went wrong");
      } finally {
        setLoading(false);
      }
    };

    fetchBookings();
  }, []);

  if (loading) return <p>Loading your bookings...</p>;
  if (error) return <p style={{ color: "red" }}>{error}</p>;

  return (
    <div>
      <h2>My Bookings</h2>
      {bookings.length === 0 ? (
        <p>No bookings found.</p>
      ) : (
        <ul>
          {bookings.map((booking) => (
            <li key={booking.id}>
              <strong>Event:</strong> {booking.event?.name || "Event deleted"} <br />
              <strong>Date/Time:</strong> {booking.booking_time} <br />
              <strong>Status:</strong> {booking.status} <br />
              <strong>Payment:</strong> {booking.payment_status}
            </li>
          ))}
        </ul>
      )}
    </div>
  );
};

export default UserBookings;

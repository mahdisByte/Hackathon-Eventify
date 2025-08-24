import React, { useEffect, useState } from "react";
import axios from "axios";
import "../styles/events.css";
const Events = () => {
  const [events, setEvents] = useState([]);

  // Fetch events
  const fetchEvents = async () => {
    try {
      const res = await axios.get("http://localhost:8000/api/events");
      setEvents(res.data.data); // adjust if pagination wrapper differs
    } catch (err) {
      console.error(err);
    }
  };

  // Delete event
  const deleteEvent = async (id) => {
    if (!window.confirm("Are you sure you want to delete this event?")) return;

    try {
      await axios.delete(`http://localhost:8000/api/events/${id}`);
      setEvents(events.filter((event) => event.event_id !== id));
    } catch (err) {
      console.error(err);
      alert("Failed to delete event");
    }
  };

  useEffect(() => {
    fetchEvents();
  }, []);

  return (
    <div>
      <h1>Events</h1>
      <ul>
        {events.map((event) => (
          <li key={event.event_id}>
            <strong>{event.name}</strong> - {event.location}
            <button onClick={() => deleteEvent(event.event_id)}>Delete</button>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Events;

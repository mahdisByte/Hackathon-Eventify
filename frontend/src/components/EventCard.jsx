import React from "react";
import "../styles/EventCard.css"; // updated CSS file name
import EventImage from "../assets/images/event.jpeg";
import LImg from "../assets/images/L_img.png";

const EventCard = ({ event }) => {
  const profileImg =
    event.profile_picture && event.profile_picture !== ""
      ? event.profile_picture
      : "http://localhost:8000/storage/default.jpeg"; // fallback

  const toolsIcon = "http://localhost:8000/storage/tools.png"; // fixed working path

  return (
    <div className="event-card">
      <div className="event-img">
        {/* <img src={profileImg} alt={event.title || "Event"} /> */}
        <img src={EventImage} alt={event.title || "Event"} />
      </div>

      <div className="event-info">
        <div className="event-header">
          <div>
            <h4>{event.title}</h4>
            <p className="user_id">User-Id: {event.user_id}</p>
            <p className="job">Category: {event.category}</p>
          </div>

          <div className="price-section">
            {/* <img src={toolsIcon} alt="Tools" className="icon" /> */}
            <img src={LImg} alt="L" className="icon" /> {/* New image */}
            <p className="price">{event.price} Tk</p>
          </div>
        </div>

        <div className="event-footer">
          <div className="time">⏰ {event.available_time}</div>
        </div>
      </div>
    </div>
  );
};

export default EventCard;

import React, { useEffect, useState, useRef } from "react";
import { Link, useNavigate } from "react-router-dom";
import "../styles/homepage.css";
import EventCard from "../components/EventCard";

const HomePage = () => {
  const [events, setEvents] = useState([]);
  const [searchTerm, setSearchTerm] = useState("");
  const [pagination, setPagination] = useState({});
  const [dropdownOpen, setDropdownOpen] = useState(false);
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [isAdmin, setIsAdmin] = useState(false);
  const [profile, setProfile] = useState(null);
  const navigate = useNavigate();
  const dropdownRef = useRef();

  const API_BASE = "http://127.0.0.1:8000/api";

  // Check if user or admin is logged in
  const checkLoginStatus = () => {
    const adminToken = localStorage.getItem("admin_token");
    const userToken = localStorage.getItem("token");
    setIsLoggedIn(!!(adminToken || userToken));
    setIsAdmin(!!adminToken);
  };

  // Return correct headers for API requests
  const getAuthHeaders = () => {
    const adminToken = localStorage.getItem("admin_token");
    const userToken = localStorage.getItem("token");
    const token = adminToken || userToken;
    return {
      "Content-Type": "application/json",
      Authorization: token ? `Bearer ${token}` : "",
    };
  };

  // Fetch profile info for logged-in user/admin
  const fetchProfile = () => {
    if (!isLoggedIn) return;
    const endpoint = isAdmin ? `${API_BASE}/admin/profile` : `${API_BASE}/profile`;
    fetch(endpoint, { headers: getAuthHeaders() })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) setProfile(isAdmin ? data.admin : data.user);
      })
      .catch((err) => console.error("Failed to fetch profile:", err));
  };

  useEffect(() => {
    checkLoginStatus();
  }, []);

  useEffect(() => {
    fetchEvents();
    fetchProfile();
  }, [isLoggedIn]);

  // Close dropdown if clicked outside
  useEffect(() => {
    const handleClickOutside = (event) => {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
        setDropdownOpen(false);
      }
    };
    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  // Fetch events with optional pagination
  const fetchEvents = (url = `${API_BASE}/events?per_page=15`) => {
    fetch(url, { headers: getAuthHeaders() })
      .then((res) => res.json())
      .then((data) => {
        setEvents(data.data || []);
        setPagination({
          currentPage: data.current_page,
          lastPage: data.last_page,
          prevPageUrl: data.prev_page_url,
          nextPageUrl: data.next_page_url,
        });
      })
      .catch((err) => console.error(err));
  };

  // Handle search form
  const handleSearch = (e) => {
    e.preventDefault();
    fetch(`${API_BASE}/search?search=${searchTerm}&per_page=15`, {
      headers: getAuthHeaders(),
    })
      .then((res) => res.json())
      .then((data) => {
        setEvents(data.events?.data || []);
        setPagination({
          currentPage: data.events?.current_page,
          lastPage: data.events?.last_page,
          prevPageUrl: data.events?.prev_page_url,
          nextPageUrl: data.events?.next_page_url,
        });
      })
      .catch((err) => console.error(err));
  };

  // Handle pagination clicks
  const handlePageClick = (url) => {
    if (url) fetchEvents(url);
  };

  // Handle logout for both users and admins
  const handleLogout = () => {
    const adminToken = !!localStorage.getItem("admin_token");
    const endpoint = adminToken ? `${API_BASE}/admin/logout` : `${API_BASE}/logout`;

    fetch(endpoint, {
      method: "POST",
      headers: getAuthHeaders(),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          if (adminToken) localStorage.removeItem("admin_token");
          else localStorage.removeItem("token");
          setIsLoggedIn(false);
          setIsAdmin(false);
          navigate(adminToken ? "/admin/login" : "/login");
        } else console.error("Logout failed:", data.msg);
      })
      .catch((err) => console.error("Logout API error:", err));
  };

  return (
    <div>
      {/* Top bar */}
      <div className="top-bar" style={{ justifyContent: "flex-start" }}>
        <form
          onSubmit={handleSearch}
          style={{
            display: "flex",
            gap: "8px",
            maxWidth: "600px",
            width: "100%",
          }}
        >
          <input
            type="text"
            placeholder="Search with event name"
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            style={{ flexGrow: 1, padding: "14px 16px", fontSize: "16px" }}
          />
          <button type="submit" style={{ padding: "8px 12px", fontSize: "13px" }}>
            Search
          </button>
        </form>

        {isLoggedIn && (
          <div className="actions" ref={dropdownRef}>
            {isAdmin && (
              <div className="admin-actions">
                <Link to="/event-form" className="create-event-btn">
                  <span className="plus-icon">+</span> Create Event
                </Link>
                <Link to="/events" className="delete-event-btn">
                  Delete Event
                </Link>
              </div>
            )}
            <div className="dropdown">
              <button
                className="dropdown-toggle"
                onClick={() => setDropdownOpen(!dropdownOpen)}
              >
                ☰ Menu
              </button>
              {dropdownOpen && (
                <div className="dropdown-menu">
                  <Link to="/profile" className="dropdown-item">
                    Profile
                  </Link>
                  <Link to="/booking-history" className="dropdown-item">
                    Bookings
                  </Link>
                  <button onClick={handleLogout} className="dropdown-item logout">
                    Logout
                  </button>
                </div>
              )}
            </div>
          </div>
        )}
      </div>

      {/* Events Cards */}
      <div className="all-cards-container">
        {events.length === 0 ? (
          <p style={{ textAlign: "center", color: "#fff" }}>No events found.</p>
        ) : (
          events.map((event) => (
            <Link
              to={`/event/${event.event_id}`}
              key={event.event_id}
              className="event-card-link"
            >
              <EventCard event={event} />
            </Link>
          ))
        )}
      </div>

      {/* Pagination */}
      <div className="pagination-links">
        {pagination.prevPageUrl ? (
          <span onClick={() => handlePageClick(pagination.prevPageUrl)}>
            &lt; Previous
          </span>
        ) : (
          <span>&lt; Previous</span>
        )}

        {Array.from({ length: pagination.lastPage || 0 }, (_, i) => i + 1).map(
          (page) => (
            <span
              key={page}
              className={page === pagination.currentPage ? "current" : ""}
              onClick={() =>
                handlePageClick(`${API_BASE}/events?per_page=15&page=${page}`)
              }
            >
              {page}
            </span>
          )
        )}

        {pagination.nextPageUrl ? (
          <span onClick={() => handlePageClick(pagination.nextPageUrl)}>
            Next &gt;
          </span>
        ) : (
          <span>Next &gt;</span>
        )}
      </div>
    </div>
  );
};

export default HomePage;

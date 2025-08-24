// src/pages/AddEvent.jsx
import React, { useState, useEffect } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";

export default function AddEvent() {
  const [formData, setFormData] = useState({
    user_id: "",
    name: "",
    description: "",
    category: "",
    location: "",
    price: "",
    available_time: "",
  });

  const [message, setMessage] = useState("");
  const navigate = useNavigate();

  const API_BASE = "http://127.0.0.1:8000/api";

  // Redirect to login if not logged in
  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      navigate("/login");
    }
  }, [navigate]);

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setMessage("");

    const token = localStorage.getItem("token");
    if (!token) {
      setMessage("❌ You must be logged in to create an event.");
      navigate("/login");
      return;
    }

    try {
      const response = await axios.post(
        `${API_BASE}/events`,
        formData,
        {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`, // include JWT token
          },
        }
      );

      if (response.data.success) {
        setMessage("✅ Event created successfully!");
        setFormData({
          user_id: "",
          name: "",
          description: "",
          category: "",
          location: "",
          price: "",
          available_time: "",
        });
      }
    } catch (error) {
      if (error.response && error.response.data.errors) {
        setMessage("❌ " + JSON.stringify(error.response.data.errors));
      } else if (error.response && error.response.status === 401) {
        setMessage("❌ Unauthorized. Please login again.");
        localStorage.removeItem("token");
        navigate("/login");
      } else {
        setMessage("❌ Something went wrong.");
      }
    }
  };

  return (
    <div className="form-container">
      <h2>Add New Event</h2>
      {message && <p style={{ textAlign: "center", color: "red" }}>{message}</p>}
      <form onSubmit={handleSubmit}>
        <div className="input-wrapper">
          <label>User ID</label>
          <input
            type="number"
            name="user_id"
            value={formData.user_id}
            onChange={handleChange}
            placeholder="Enter User ID"
          />
        </div>
        <div className="input-wrapper">
          <label>Name</label>
          <input
            type="text"
            name="name"
            value={formData.name}
            onChange={handleChange}
            placeholder="Name"
          />
        </div>
        <div className="input-wrapper">
          <label>Description</label>
          <input
            type="text"
            name="description"
            value={formData.description}
            onChange={handleChange}
            placeholder="Event Description"
          />
        </div>
        <div className="input-wrapper">
          <label>Category</label>
          <input
            type="text"
            name="category"
            value={formData.category}
            onChange={handleChange}
            placeholder="Category"
          />
        </div>
        <div className="input-wrapper">
          <label>Location</label>
          <input
            type="text"
            name="location"
            value={formData.location}
            onChange={handleChange}
            placeholder="Location"
          />
        </div>
        <div className="input-wrapper">
          <label>Price (tk)</label>
          <input
            type="text"
            name="price"
            value={formData.price}
            onChange={handleChange}
            placeholder="Price"
          />
        </div>
        <div className="input-wrapper">
          <label>Available Time (… am – … pm)</label>
          <input
            type="text"
            name="available_time"
            value={formData.available_time}
            onChange={handleChange}
            placeholder="Available time"
          />
        </div>
        <div className="input-wrapper">
          <button type="submit">Create</button>
        </div>
      </form>
    </div>
  );
}

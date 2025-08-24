import React, { useEffect, useState } from "react";
import axios from "axios";
import "../styles/ProfilePage.css"; // Import the CSS

const ProfilePage = () => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      setLoading(false);
      return;
    }

    axios
      .get("http://localhost:8000/api/profile", {
        headers: { Authorization: `Bearer ${token}` },
      })
      .then((res) => {
        if (res.data.success) setUser(res.data.user);
      })
      .catch((err) => {
        console.error(err);
        alert("Failed to fetch profile. Please login again.");
      })
      .finally(() => setLoading(false));
  }, []);

  if (loading) return <p className="loading-text">Loading...</p>;
  if (!user) return <p className="loading-text">No user found. Please login.</p>;

  return (
    <div className="profile-page">
      <h1 className="profile-title">My Profile</h1>

      <div className="profile-card">
        <p className="profile-info">
          <strong>Name:</strong> {user.name}
        </p>
        <p className="profile-info">
          <strong>Email:</strong> {user.email}
        </p>
        <p className="profile-info">
          <strong>Registered At:</strong> {new Date(user.created_at).toLocaleString()}
        </p>
      </div>
    </div>
  );
};

export default ProfilePage;

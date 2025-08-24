import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

const AdminProfile = () => {
  const [admin, setAdmin] = useState(null);
  const navigate = useNavigate();
  const API_BASE = "http://localhost:8000/api";

  useEffect(() => {
    const token = localStorage.getItem("admin_token");
    if (!token) {
      navigate("/admin-login"); // redirect if no token
      return;
    }

    fetch(`${API_BASE}/admin/profile`, {
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) setAdmin(data.admin);
        else {
          localStorage.removeItem("admin_token");
          navigate("/admin-login");
        }
      })
      .catch(err => {
        console.error(err);
        localStorage.removeItem("admin_token");
        navigate("/admin-login");
      });
  }, [navigate]);

  if (!admin) return <p>Loading...</p>;

  return (
    <div>
      <h1>Admin Profile</h1>
      <p>Name: {admin.name}</p>
      <p>Email: {admin.email}</p>
    </div>
  );
};

export default AdminProfile;

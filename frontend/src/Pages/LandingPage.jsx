import React from "react";
import { Link } from "react-router-dom";
import "../Styles/LandingPage.css";
import LandingIllustration from "../assets/images/L_img.png";

const LandingPage = () => {
  return (
    <div className="landing-container">
      {/* Navbar */}
      <nav className="navbar">
        <div className="logo">Eventify</div>
        <div className="nav-links">
          <Link to="/homepage">Home</Link>
          <Link to="/signup" className="cta-btn-link">Sign Up</Link>
          <Link to="/login" className="cta-btn-link">Login</Link>
          {/* New Admin Login Button */}
          <Link to="/admin-login" className="cta-btn-link">Admin Login</Link>
        </div>
      </nav>

      {/* Hero Section */}
      <div className="hero">
        <div className="hero-text">
          <h1>
            Exclusive Events <br /> Seminars <br /> New Opportunity
          </h1>
          <p>University Club Event Management Platform</p>
          <Link to="/signup" className="cta-btn">
            REGISTER NOW!
          </Link>
        </div>
        <div className="hero-image">
          <img src={LandingIllustration} alt="illustration" />
        </div>
      </div>
    </div>
  );
};

export default LandingPage;

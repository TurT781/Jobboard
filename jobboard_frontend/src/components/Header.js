import React, { useState } from "react";
import { NavLink, useNavigate } from "react-router-dom";
import logoRmBg from "../assets/techApply.png";
import "../CSS/Header.css";

const getActiveLink = ({ isActive }) => {
  return isActive ? { color: "#f8cb2e" } : {};
};

const Header = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const navigate = useNavigate();

  const toggleMenu = () => {
    setIsMenuOpen(!isMenuOpen);
  };

  const handleLinkClick = () => {
    setIsMenuOpen(false);
  };

  const logout = () => {
    localStorage.removeItem("token");
    navigate("/login");
  };

  const isAuthenticated = !!localStorage.getItem("token");

  return (
    <header className="header">
      <nav className="navLinkHeader">
        <div className="logoName">
          <img src={logoRmBg} alt="TechApply_logo" className="logoHeader" />
          <NavLink to="/" style={{ textDecoration: "none" }}>
            <h1 className="header">TechApply</h1>
          </NavLink>
        </div>


        <button className="burgerMenu" onClick={toggleMenu}>
          <span className="burgerBar"></span>
          <span className="burgerBar"></span>
          <span className="burgerBar"></span>
        </button>

        <ul className={`ulHeader ${isMenuOpen ? "open" : ""}`}>
          <li><NavLink style={getActiveLink} to="/" onClick={handleLinkClick}> Home</NavLink ></li>
          <li><NavLink style={getActiveLink} to="/offers" onClick={handleLinkClick}>Offers</NavLink></li>
          <li><NavLink style={getActiveLink} to="/dashboard" onClick={handleLinkClick}>Dashboard</NavLink></li>

          <li>
            {isAuthenticated ? (
              <button className="btnConnection" onClick={logout}>
                Logout
              </button>
            ) : (
              <NavLink to="/login" className="btnLink" onClick={handleLinkClick}>
                <button className="btnConnection">
                  <p>Login</p>
                </button>
              </NavLink>
            )}
          </li>
        </ul>

      </nav>
    </header>
  );
};

export default Header;

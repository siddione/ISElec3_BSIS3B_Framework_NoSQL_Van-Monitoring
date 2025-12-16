// src/components/Navbar.jsx
import React from "react";
import { Link, useLocation, useNavigate } from "react-router-dom";

export default function Navbar() {
  const location = useLocation();
  const navigate = useNavigate();

  const token = localStorage.getItem("driverToken");

  const navItemClass = (path) =>
    `px-4 py-2 rounded-lg font-medium text-sm ${
      location.pathname === path
        ? "bg-green-300 text-white shadow-sm"
        : "hover:bg-green-100 text-green-800"
    } transition-all duration-200`;

  return (
   <nav className="w-full bg-white shadow-lg px-6 py-3 flex justify-between items-center sticky top-0 z-50">
      {/* Logo / Title */}
      <div className="text-lg md:text-xl font-bold text-green-700 tracking-wide">
        UV Express Van Monitoring
      </div>

      {/* Navigation Items */}
      <div className="flex items-center gap-2">
        {(location.pathname === "/vans" || 
          location.pathname === "/reservation-form" || 
          location.pathname === "/driver-register" || 
          location.pathname === "/driver-login") && (
          <button
            onClick={() => navigate("/")}
            className="px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-100 text-green-800 transition-all duration-200"
          >
            Home
          </button>
        )}

        {(location.pathname === "/reservations" || location.pathname === "/driver-panel") && (
          <button
            onClick={() => navigate("/driver-panel")}
            className="px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-100 text-green-800 transition-all duration-200"
          >
            Home
          </button>
        )}

        {(!token || location.pathname === "/" || location.pathname === "/vans" || location.pathname === "/reservation-form") && (
          <>
            <Link to="/driver-register" className={navItemClass("/driver-register")}>
              Register as Driver
            </Link>
            <Link to="/driver-login" className={navItemClass("/driver-login")}>
              Driver Login
            </Link>
          </>
        )}

        {token &&
          location.pathname !== "/" &&
          location.pathname !== "/reservation-form" &&
          location.pathname !== "/vans" && (
            <button
              onClick={() => {
                localStorage.removeItem("driverToken");
                navigate("/driver-login");
              }}
              className={
                location.pathname === "/reservations" ||
                location.pathname === "/driver-panel"
                  ? "px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-100 text-green-800 transition-all duration-200"
                  : "ml-2 px-4 py-2 rounded-lg text-sm font-medium bg-red-500 text-white hover:bg-red-600 transition-all duration-200 shadow-sm"
              }
            >
              Logout
            </button>
          )}
      </div>
    </nav>
  );
}

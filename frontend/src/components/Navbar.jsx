import React from "react";
import { Link } from "react-router-dom";

export default function Navbar() {
  return (
    <nav className="bg-green-600 text-white px-6 py-4 shadow-lg flex justify-between items-center">
      <h1 className="text-2xl font-bold">UV Express Monitoring</h1>

      <ul className="flex space-x-6 text-lg font-medium">
        <li>
          <Link to="/" className="hover:text-gray-200 transition duration-200">
            Home
          </Link>
        </li>
        <li>
          <Link to="/vans" className="hover:text-gray-200 transition duration-200">
            Vans
          </Link>
        </li>
        <li>
          <Link to="/reservations" className="hover:text-gray-200 transition duration-200">
            Reserve Seat
          </Link>
        </li>
        <li>
          <Link to="/reservations-lists" className="hover:text-gray-200 transition duration-200">
            View Reservations
          </Link>
        </li>
      </ul>
    </nav>
  );
}

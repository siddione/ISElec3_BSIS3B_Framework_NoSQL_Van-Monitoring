import React from "react";
import { Link } from "react-router-dom";

export default function Navbar() {
  return (
    <nav className="bg-green-600 text-white shadow-md p-4 flex justify-between items-center">
      <div className="font-bold text-xl">
        Welcome to UV Express Monitoring!
      </div>

      <div className="flex gap-4">
        <Link
          to="/vans"
          className="px-3 py-2 rounded hover:bg-green-700 transition"
        >
          Available Vans
        </Link>
        <Link
          to="/reservations"
          className="px-3 py-2 rounded hover:bg-green-700 transition"
        >
         View Reservations
        </Link>
        <Link
          to="/driver-panel"
          className="px-3 py-2 rounded hover:bg-green-700 transition"
        >
          Driver Panel
        </Link>
      </div>
    </nav>
  );
}

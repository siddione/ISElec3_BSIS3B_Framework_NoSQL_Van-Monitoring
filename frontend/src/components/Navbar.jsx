import React from "react";
import { Link } from "react-router-dom";

export default function Navbar() {
  return (
    <nav className="bg-green-600 p-4 text-white flex justify-between">
      <h1 className="font-bold">UV Express Polangui-Legazpi</h1>
      <div className="space-x-4">
        <Link to="/">Home</Link>
        <Link to="/vans">Vans</Link>
        <Link to="/reservations">Reservations</Link>
      </div>
    </nav>
  );
}

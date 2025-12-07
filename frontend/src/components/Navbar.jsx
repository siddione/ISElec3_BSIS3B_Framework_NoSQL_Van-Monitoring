import React from "react";
import { Link } from "react-router-dom";

const Navbar = () => {
  return (
    <nav className="bg-green-600 text-white p-4 flex justify-between">
      <h1 className="font-bold text-xl">UV Express Polangui-Legazpi</h1>
      <ul className="flex gap-4">
        <li><Link to="/" className="hover:underline">Home</Link></li>
        <li><Link to="/vans" className="hover:underline">Vans</Link></li>
        <li><Link to="/reservations" className="hover:underline">Reservations</Link></li>

      </ul>
    </nav>
  );
};

export default Navbar;

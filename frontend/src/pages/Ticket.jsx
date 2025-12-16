import React from "react";
import { useLocation, useNavigate } from "react-router-dom";

export default function Ticket() {
  const location = useLocation();
  const navigate = useNavigate();
  const { ticket } = location.state || {};

  if (!ticket) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gradient-to-r from-green-100 to-green-50 p-6">
        <div className="bg-white rounded-3xl shadow-2xl p-12 max-w-md w-full text-center hover:shadow-3xl transition duration-300">
          <p className="text-red-600 font-semibold mb-6 text-lg">No ticket data available</p>
          <button
            onClick={() => navigate("/")}
            className="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-2xl shadow-lg transition transform hover:scale-105 duration-300"
          >
            Go Home
          </button>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-r from-green-100 to-green-50 p-6">
      <div className="bg-white rounded-3xl shadow-2xl p-12 max-w-md w-full hover:shadow-3xl transition duration-300">
        <h1 className="text-3xl md:text-2xl font-extrabold mb-8 text-center text-green-900">
          Reservation Ticket
        </h1>

        <div className="space-y-3 mb-8">
          {/* Ticket details */}
          {[
            { label: "Passenger Name", value: ticket.passengerName },
            { label: "Number of Seats Reserved", value: ticket.quantity },
            { label: "Van Number", value: ticket.van.plateNumber },
            { label: "Route", value: ticket.van.route },
            { label: "Driver Name", value: ticket.van.driverName },
          ].map((item) => (
            <div
              key={item.label}
              className="flex justify-between items-center bg-green-50 p-4 rounded-xl shadow-sm border border-green-100"
            >
              <span className="text-sm text-center font-semibold text-green-900">{item.label}</span>
              <span className="text-lg font-bold text-green-900">{item.value}</span>
            </div>
          ))}
        </div>

        <button
          onClick={() => navigate("/")}
          className="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 rounded-2xl shadow-lg transition transform hover:scale-105 duration-300"
        >
          Back to Home
        </button>
      </div>
    </div>
  );
}

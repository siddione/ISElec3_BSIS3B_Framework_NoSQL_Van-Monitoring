import React, { useEffect, useState } from "react";

export default function Reservations() {
  const [reservations, setReservations] = useState([]);

  useEffect(() => {
    fetch("http://localhost:3000/reservations")
      .then((res) => res.json())
      .then((data) => setReservations(data))
      .catch((err) => console.error("Error fetching reservations:", err));
  }, []);

  return (
    <div className="p-6">
      <h1 className="text-3xl font-bold mb-4">Reservation List</h1>

      {reservations.length === 0 ? (
        <p>No reservations found.</p>
      ) : (
        <ul className="space-y-4">
          {reservations.map((r) => (
            <li
              key={r._id}
              className="p-4 bg-white shadow rounded border border-gray-200"
            >
              <p><strong>Passenger:</strong> {r.passengerName}</p>
              <p><strong>Van ID:</strong> {r.van}</p>
              <p><strong>Seat #:</strong> {r.seatNumber}</p>
              <p><strong>Date:</strong> {new Date(r.reservationDate).toLocaleString()}</p>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}

import React, { useEffect, useState } from "react";
import API_URL from "../config";

export default function Reservations() {
  const [reservations, setReservations] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch(`${API_URL}/reservations`)
      .then((res) => res.json())
      .then((data) => {
        setReservations(data);
        setLoading(false);
      })
      .catch((err) => {
        console.error("Error fetching reservations:", err);
        setLoading(false);
      });
  }, []);

  if (loading)
    return (
      <p className="p-6 text-center text-green-700 font-semibold">
        Loading reservations...
      </p>
    );

  return (
    <div className="min-h-screen bg-green-50 p-8 flex justify-center">
      <div className="w-full max-w-5xl bg-white rounded-2xl shadow-2xl p-6">
        <h1 className="text-3xl font-bold mb-6 text-center text-green-900">
          Reservation List
        </h1>

        {reservations.length === 0 ? (
          <p className="text-center text-green-700">No reservations found.</p>
        ) : (
          <div className="overflow-x-auto">
            <table className="min-w-full border border-gray-200 rounded-lg overflow-hidden">
              <thead className="bg-gradient-to-r from-green-500 to-green-600 text-white">
                <tr>
                  <th className="p-3 text-left">Passenger Name</th>
                  <th className="p-3 text-left">Van Route</th>
                  <th className="p-3 text-left">Driver</th>
                  <th className="p-3 text-left">Seat Number</th>
                  <th className="p-3 text-left">Van Status</th>
                </tr>
              </thead>
              <tbody>
                {reservations.map((r) => (
                  <tr key={r._id} className="text-black text-center">
                    <td className="p-3 border">{r.passengerName}</td>
                    <td className="p-3 border">{r.van?.route || "N/A"}</td>
                    <td className="p-3 border">{r.van?.driverName || "N/A"}</td>
                    <td className="p-3 border">{r.seatNumber}</td>
                    <td className="p-3 border">
                      {r.van?.status ? (
                        <span
                          className={`px-3 py-1 rounded-full text-sm font-semibold ${
                            r.van.status === "Waiting"
                              ? "bg-yellow-400 text-black"
                              : r.van.status === "Traveling"
                              ? "bg-blue-400 text-black"
                              : r.van.status === "Arrived"
                              ? "bg-green-400 text-black"
                              : "bg-gray-400 text-black"
                          }`}
                        >
                          {r.van.status}
                        </span>
                      ) : (
                        "N/A"
                      )}
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
      </div>
    </div>
  );
}

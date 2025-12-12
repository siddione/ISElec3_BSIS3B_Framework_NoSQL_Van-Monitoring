import React, { useEffect, useState } from "react";

const ReservationsLists = () => {
  const [reservations, setReservations] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch("http://localhost:3000/reservations")
      .then(res => res.json())
      .then(data => {
        setReservations(data);
        setLoading(false);
      })
      .catch(err => {
        console.error(err);
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
        <h2 className="text-3xl font-extrabold text-green-900 mb-6 text-center">
          Reserved Seats
        </h2>

        {reservations.length === 0 ? (
          <p className="text-center text-green-700">No reservations yet</p>
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
                {reservations.map((resv) => (
                  <tr key={resv._id} className="text-black text-center">
                    <td className="p-3 border">{resv.passengerName}</td>
                    <td className="p-3 border">{resv.van?.route || "N/A"}</td>
                    <td className="p-3 border">{resv.van?.driverName || "N/A"}</td>
                    <td className="p-3 border">{resv.seatNumber}</td>
                    <td className="p-3 border">
                      {resv.van?.status ? (
                        <span
                          className={`px-3 py-1 rounded-full text-sm font-semibold ${
                            resv.van.status === "Waiting"
                              ? "bg-yellow-400 text-black"
                              : resv.van.status === "Traveling"
                              ? "bg-blue-400 text-black"
                              : resv.van.status === "Arrived"
                              ? "bg-green-400 text-black"
                              : "bg-gray-400 text-black"
                          }`}
                        >
                          {resv.van.status}
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
};

export default ReservationsLists;

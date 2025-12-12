import React, { useEffect, useState } from "react";

export default function DriverPanel() {
  const [vans, setVans] = useState([]);
  const [loading, setLoading] = useState(true);

  const fetchVans = async () => {
    try {
      const res = await fetch("http://localhost:3000/vans");
      const data = await res.json();
      setVans(data);
      setLoading(false);
    } catch (err) {
      console.error(err);
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchVans();
  }, []);

  const updateStatus = async (vanId, newStatus) => {
    try {
      const res = await fetch(`http://localhost:3000/vans/${vanId}/status`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ status: newStatus }),
      });

      if (!res.ok) {
        const data = await res.json();
        alert(data.error || "Failed to update status");
        return;
      }

      fetchVans(); // refresh list
    } catch (err) {
      console.error(err);
    }
  };

  if (loading) return <p className="p-6 text-center text-green-700">Loading vans...</p>;

  return (
    <div className="min-h-screen bg-green-50 p-8">
      <h1 className="text-3xl font-extrabold text-green-900 mb-6 text-center">Driver Panel</h1>

      {vans.length === 0 ? (
        <p className="text-center text-green-700">No vans available</p>
      ) : (
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          {vans.map((van) => (
            <div key={van._id} className="p-6 bg-white rounded-xl shadow-md border border-gray-200">
              <p><strong>Route:</strong > {van.route}</p>
              <p><strong>Driver:</strong> {van.driverName}</p>
              <p><strong>Status:</strong> {van.status}</p>
              <p><strong>Seats:</strong> {van.availableSeats}/{van.totalSeats}</p>

              <div className="mt-4 flex gap-2">
                {["Waiting", "Traveling", "Arrived", "Parked"].map((statusOption) => (
                  <button
                    key={statusOption}
                    onClick={() => updateStatus(van._id, statusOption)}
                    className={`px-3 py-1 rounded text-white ${
                      van.status === statusOption ? "bg-green-700" : "bg-green-500 hover:bg-green-600"
                    } transition`}
                  >
                    {statusOption}
                  </button>
                ))}
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}

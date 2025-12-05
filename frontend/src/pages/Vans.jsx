import React, { useEffect, useState } from "react";

const Vans = () => {
  const [vans, setVans] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch("http://localhost:3000/vans") // your backend route
      .then((res) => res.json())
      .then((data) => {
        setVans(data);
        setLoading(false);
      })
      .catch((err) => {
        console.error("Error fetching vans:", err);
        setLoading(false);
      });
  }, []);

  if (loading) return <p className="p-4">Loading vans...</p>;

  return (
    <div className="p-8">
      <h2 className="text-2xl font-bold mb-4">Available Vans</h2>
      {vans.length === 0 ? (
        <p>No vans available</p>
      ) : (
        <table className="min-w-full border border-gray-300">
          <thead>
            <tr className="bg-green-600 text-white">
              <th className="p-2 border">Van ID</th>
              <th className="p-2 border">Route</th>
              <th className="p-2 border">Seats Available</th>
              <th className="p-2 border">Status</th>
            </tr>
          </thead>
          <tbody>
            {vans.map((van) => (
              <tr key={van.id} className="text-center">
                <td className="p-2 border">{van.id}</td>
                <td className="p-2 border">{van.route}</td>
                <td className="p-2 border">{van.availableSeats}</td>
                <td className="p-2 border">{van.status}</td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
};

export default Vans;

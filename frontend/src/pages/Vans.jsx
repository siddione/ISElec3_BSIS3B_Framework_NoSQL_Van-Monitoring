import React, { useEffect, useState } from "react";

export default function Vans() {
  const [vans, setVans] = useState([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState("");
  const [statusFilter, setStatusFilter] = useState("");

  // Fetch vans
  const fetchVans = async () => {
    try {
      const res = await fetch("http://localhost:3000/vans");
      const data = await res.json();
      setVans(data);
      setLoading(false);
    } catch (err) {
      console.error("Error fetching vans:", err);
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchVans();
    const interval = setInterval(fetchVans, 5000); // live refresh
    return () => clearInterval(interval);
  }, []);

  const filteredVans = vans.filter((van) => {
    const searchLower = search.toLowerCase();
    return (
      (van.route.toLowerCase().includes(searchLower) ||
        van.driverName.toLowerCase().includes(searchLower) ||
        van.plateNumber.toLowerCase().includes(searchLower)) &&
      (statusFilter === "" || van.status === statusFilter)
    );
  });

  if (loading)
    return (
      <div className="p-8 text-center text-white text-xl font-semibold">
        Loading vans...
      </div>
    );

  return (
    <div className="min-h-screen bg-gradient-to-r from-green-600 to-blue-600 p-8">
      <h1 className="text-4xl font-extrabold text-center text-white mb-8">
        Available Vans
      </h1>

      {/* Search & Filter */}
      <div className="flex flex-col md:flex-row justify-between mb-8 gap-4">
        <input
          type="text"
          placeholder="Search by route, driver, or plate..."
          value={search}
          onChange={(e) => setSearch(e.target.value)}
          className="w-full md:w-2/3 p-3 rounded-xl border border-white bg-white/20 text-white placeholder-white focus:ring-2 focus:ring-white outline-none transition"
        />
        <select
          value={statusFilter}
          onChange={(e) => setStatusFilter(e.target.value)}
          className="w-full md:w-1/3 p-3 rounded-xl border border-white bg-white/20 text-black focus:ring-2 focus:ring-white outline-none transition"
        >
          <option value="">All Statuses</option>
          <option value="Waiting">Waiting</option>
          <option value="Traveling">Traveling</option>
          <option value="Arrived">Arrived</option>
          <option value="Parked">Parked</option>
        </select>
      </div>

      {/* Vans Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {filteredVans.length === 0 ? (
          <p className="text-center text-white col-span-full">No vans found.</p>
        ) : (
          filteredVans.map((van) => (
            <div
              key={van._id}
              className="bg-white/20 shadow-lg rounded-2xl p-6 border border-white/30 hover:scale-105 transform transition duration-300"
            >
              <div className="flex justify-between items-center mb-4">
                <h2 className="text-2xl font-bold text-white">{van.route}</h2>
                <span
                  className={`px-3 py-1 rounded-full text-sm font-semibold 
                    ${
                      van.status === "Waiting"
                        ? "bg-yellow-400 text-black"
                        : van.status === "Traveling"
                        ? "bg-blue-400 text-black"
                        : van.status === "Arrived"
                        ? "bg-green-400 text-black"
                        : "bg-gray-400 text-black"
                    }`}
                >
                  {van.status}
                </span>
              </div>

              <div className="text-white space-y-2 mb-4">
                <p>
                  <span className="font-semibold">Driver:</span> {van.driverName}
                </p>
                <p>
                  <span className="font-semibold">Plate:</span> {van.plateNumber}
                </p>
                <p>
                  <span className="font-semibold">Seats:</span> {van.availableSeats}/{van.totalSeats} available
                </p>
              </div>

              <a
                href="/reservation-form"
                className="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-xl shadow-md transition duration-300"
              >
                Reserve Seat
              </a>
            </div>
          ))
        )}
      </div>
    </div>
  );
}

import React, { useEffect, useState } from "react";

const Reservations = () => {
  const [vans, setVans] = useState([]);
  const [selectedVan, setSelectedVan] = useState(null);
  const [name, setName] = useState("");
  const [success, setSuccess] = useState("");

  useEffect(() => {
    fetch("http://localhost:3000/vans") // get available vans
      .then((res) => res.json())
      .then((data) => setVans(data))
      .catch((err) => console.error(err));
  }, []);

  const handleReservation = () => {
    if (!selectedVan || !name) return alert("Select a van and enter your name");

    fetch(`http://localhost:3000/reservations`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ vanId: selectedVan, passengerName: name }),
    })
      .then((res) => res.json())
      .then((data) => {
        setSuccess(`Seat reserved successfully for ${name} on Van ${selectedVan}`);
        setName("");
        setSelectedVan(null);
      })
      .catch((err) => console.error(err));
  };

  return (
    <div className="p-8">
      <h2 className="text-3xl font-bold mb-6 text-gray-800">Reserve a Seat</h2>

      {vans.length === 0 ? (
        <p>No vans available for reservation</p>
      ) : (
        <div className="space-y-4 max-w-md">
          <label className="block font-semibold">Your Name:</label>
          <input
            type="text"
            value={name}
            onChange={(e) => setName(e.target.value)}
            className="w-full p-2 border rounded"
            placeholder="Enter your name"
          />

          <label className="block font-semibold">Select Van:</label>
          <select
            value={selectedVan || ""}
            onChange={(e) => setSelectedVan(e.target.value)}
            className="w-full p-2 border rounded"
          >
            <option value="" disabled>
              -- Choose a van --
            </option>
            {vans.map((van) => (
              <option key={van.id} value={van.id}>
                Van {van.id} ({van.route}) - {van.availableSeats} seats
              </option>
            ))}
          </select>

          <button
            onClick={handleReservation}
            className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
          >
            Reserve
          </button>

          {success && <p className="text-green-700 font-semibold mt-4">{success}</p>}
        </div>
      )}
    </div>
  );
};

export default Reservations;

import React, { useEffect, useState } from "react";

export default function ReservationForm() {
  const [vans, setVans] = useState([]);
  const [passengerName, setPassengerName] = useState("");
  const [vanId, setVanId] = useState("");
  const [success, setSuccess] = useState("");

  // Fetch vans from backend
  useEffect(() => {
    fetch("http://localhost:3000/vans")
      .then((res) => res.json())
      .then((data) => setVans(data))
      .catch((err) => console.error(err));
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!passengerName || !vanId) {
      alert("Please enter your name and select a van");
      return;
    }

    try {
      const res = await fetch("http://localhost:3000/reservations", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          passengerName,
          vanId,
        }),
      });

      const data = await res.json();

      if (!res.ok) {
        alert(data.error || "Reservation failed");
        return;
      }

      setSuccess(`Reservation successful for ${passengerName}`);
      setPassengerName("");
      setVanId("");

      setTimeout(() => setSuccess(""), 5000);
    } catch (err) {
      console.error(err);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-r from-green-100 to-green-50 p-6">
      <div className="bg-white bg-opacity-90 rounded-2xl shadow-2xl p-10 max-w-lg w-full">
        <h1 className="text-3xl font-extrabold mb-6 text-center text-green-900">
          Reserve a Seat
        </h1>

        <form onSubmit={handleSubmit} className="space-y-6">
          <div>
            <label className="block mb-2 font-semibold text-green-900">Your Name:</label>
            <input
              type="text"
              placeholder="Enter your full name"
              value={passengerName}
              onChange={(e) => setPassengerName(e.target.value)}
              className="w-full p-3 border border-green-300 rounded-xl focus:ring-2 focus:ring-green-400 outline-none transition duration-300 text-black"
            />
          </div>

          <div>
            <label className="block mb-2 font-semibold text-green-900">Select Van:</label>
            <select
              value={vanId}
              onChange={(e) => setVanId(e.target.value)}
              className="w-full p-3 border border-green-300 rounded-xl focus:ring-2 focus:ring-green-400 outline-none transition duration-300 text-black"
            >
              <option value="">-- Choose a van --</option>
              {vans.map((v) => (
                <option key={v._id} value={v._id}>
                  {v.route} — {v.driverName} | Seats Left: {v.availableSeats}
                </option>
              ))}
            </select>
          </div>

          <button
            type="submit"
            className="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-xl shadow-lg transition transform hover:scale-105 duration-300"
          >
            Reserve
          </button>

          {success && (
            <p className="text-green-700 font-semibold text-center mt-4 animate-fade-in">
              {success}
            </p>
          )}
        </form>
      </div>
    </div>
  );
}

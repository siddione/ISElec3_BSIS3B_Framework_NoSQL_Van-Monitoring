import React, { useEffect, useState } from "react";
import axios from "axios";

export default function DriverPanel() {
  const [driver, setDriver] = useState(null);
  const [status, setStatus] = useState("");
  const [loading, setLoading] = useState(true);
  const [message, setMessage] = useState("");

  const token = localStorage.getItem("driverToken");

  useEffect(() => {
    if (!token) {
      setLoading(false);
      return;
    }

    axios
      .get("http://localhost:3000/drivers/me", {
        headers: { Authorization: `Bearer ${token}` },
      })
      .then((res) => {
        setDriver(res.data);
        setStatus(res.data.van?.status || "Waiting");
        setLoading(false);
      })
      .catch((err) => {
        console.error(err);
        setLoading(false);
      });
  }, []);

  const updateStatus = async () => {
    try {
      const res = await axios.put(
        `http://localhost:3000/drivers/${driver._id}/van-status`,
        { status },
        {
          headers: { Authorization: `Bearer ${token}` },
        }
      );

      setMessage("Van status updated successfully");
      setDriver({ ...driver, van: res.data.van });
    } catch (err) {
      console.error(err);
      alert("Failed to update status");
    }
  };

  // 🔴 DELETE FEATURE
  const deleteDriver = async () => {
    const confirmDelete = window.confirm(
      "Are you sure you want to delete your driver account?"
    );

    if (!confirmDelete) return;

    try {
      await axios.delete("http://localhost:3000/drivers/me", {
        headers: { Authorization: `Bearer ${token}` },
      });

      localStorage.removeItem("driverToken");
      alert("Driver account deleted successfully");
      window.location.href = "/driver-login";
    } catch (err) {
      console.error(err);
      alert("Failed to delete driver account");
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <p className="text-xl font-semibold">Loading...</p>
      </div>
    );
  }

  if (!driver) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <p className="text-red-600 font-semibold">
          Unable to load driver data
        </p>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-green-50 p-8">
      <h1 className="text-3xl font-bold text-green-900 mb-6">
        Driver Dashboard
      </h1>

      <div className="bg-white rounded-2xl shadow-lg p-6 max-w-lg">
        <p className="mb-2"><strong>Name:</strong> {driver.name}</p>
        <p className="mb-2"><strong>Email:</strong> {driver.email}</p>
        <p className="mb-4">
          <strong>Plate Number:</strong> {driver.van?.plateNumber}
        </p>

        <label className="block font-semibold mb-2 text-green-900">
          Van Status
        </label>

        <select
          value={status}
          onChange={(e) => setStatus(e.target.value)}
          className="w-full border rounded-xl p-3 mb-4"
        >
          <option value="Waiting">Waiting</option>
          <option value="Traveling">Traveling</option>
          <option value="Arrived">Arrived</option>
          <option value="Parked">Parked</option>
        </select>

        <button
          onClick={updateStatus}
          className="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-xl mb-4"
        >
          Update Status
        </button>

        {/* 🔴 DELETE BUTTON */}
        <button
          onClick={deleteDriver}
          className="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-xl"
        >
          Delete Driver Account
        </button>

        {message && (
          <p className="text-green-700 text-center mt-4 font-semibold">
            {message}
          </p>
        )}
      </div>
    </div>
  );
}

import React, { useState } from "react";

export default function DriverPanel({ driver, token }) {
  const [status, setStatus] = useState(driver.van?.status || "");

  const handleUpdate = async () => {
    try {
      const res = await fetch(`http://localhost:3000/drivers/${driver._id}/van-status`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({ status }),
      });
      const data = await res.json();
      if (!res.ok) alert(data.error || "Failed");
      else alert("Van status updated!");
    } catch (err) { console.error(err); }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-green-50 p-6">
      <div className="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
        <h1 className="text-2xl font-bold text-green-900 mb-6 text-center">Driver Panel</h1>
        <div>
          <label className="block mb-2">Van Status</label>
          <select
            value={status}
            onChange={(e) => setStatus(e.target.value)}
            className="w-full p-2 border border-green-300 rounded"
          >
            <option value="Waiting">Waiting</option>
            <option value="Traveling">Traveling</option>
            <option value="Arrived">Arrived</option>
            <option value="Parked">Parked</option>
          </select>
        </div>
        <button onClick={handleUpdate} className="w-full bg-green-600 text-white py-2 mt-4 rounded">
          Update Status
        </button>
      </div>
    </div>
  );
}

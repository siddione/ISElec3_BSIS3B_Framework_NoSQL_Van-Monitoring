    import React, { useState } from "react";

export default function DriverRegister() {
  const [form, setForm] = useState({
    name: "", licenseId: "", address: "", age: "", birthday: "", email: "", password: "", profilePic: ""
  });
  const [success, setSuccess] = useState("");

  const handleChange = (e) => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const res = await fetch("http://localhost:3000/drivers/register", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(form)
      });
      const data = await res.json();
      if (!res.ok) alert(data.error || "Failed to register");
      else setSuccess("Registered successfully! You can log in now.");
    } catch (err) { console.error(err); }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-green-50 p-6">
      <div className="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg">
        <h1 className="text-2xl font-bold text-green-900 text-center mb-6">Driver Registration</h1>
        <form onSubmit={handleSubmit} className="space-y-4">
          {Object.keys(form).map((key) => (
            <div key={key}>
              <label className="block mb-1 text-green-900">{key}</label>
              <input
                type={key === "password" ? "password" : "text"}
                name={key}
                value={form[key]}
                onChange={handleChange}
                className="w-full p-2 border border-green-300 rounded"
              />
            </div>
          ))}
          <button className="w-full bg-green-600 text-white py-2 rounded">Register</button>
        </form>
        {success && <p className="text-green-700 mt-4 text-center">{success}</p>}
      </div>
    </div>
  );
}

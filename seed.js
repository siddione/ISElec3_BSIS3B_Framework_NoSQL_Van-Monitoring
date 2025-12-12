require('dotenv').config();
const mongoose = require('mongoose');
const Van = require('./models/Van');

async function seedVans() {
  try {
    // Connect to MongoDB (no extra options)
    await mongoose.connect(process.env.MONGO_URI);
    console.log("MongoDB connected successfully!");

    // Optional: clear old vans
    await Van.deleteMany({});
    console.log("Old vans cleared.");

    // Vans to insert
    const vans = [
      { plateNumber: "UVE-001", route: "Polangui - Legazpi", totalSeats: 12, availableSeats: 12, status: "Waiting", driverName: "Juan Dela Cruz" },
      { plateNumber: "UVE-002", route: "Polangui - Legazpi", totalSeats: 14, availableSeats: 14, status: "Waiting", driverName: "Maria Santos" },
      { plateNumber: "UVE-003", route: "Ligao - Legazpi", totalSeats: 10, availableSeats: 10, status: "Waiting", driverName: "Pedro Reyes" },
      { plateNumber: "UVE-004", route: "Ligao - Legazpi", totalSeats: 16, availableSeats: 16, status: "Waiting", driverName: "Ana Lopez" }
    ];

    const inserted = await Van.insertMany(vans);
    console.log(`Vans inserted: ${inserted.length}`);

  } catch (err) {
    console.error("Seeding error:", err);
  } finally {
    mongoose.connection.close();
  }
}

seedVans();

require('dotenv').config();
const mongoose = require('mongoose');
const Van = require('./models/Van');
const Reservation = require('./models/Reservation');

mongoose.connect(process.env.MONGO_URI)
  .then(() => console.log("MongoDB connected successfully!"))
  .catch((err) => console.log("MongoDB connection error:", err));

const seedReservations = async () => {
  try {
    // First, clear previous reservations
    await Reservation.deleteMany();

    // Fetch vans from the database
    const vans = await Van.find();

    // Example reservations
    const reservationsData = [
      { vanPlate: 'UVE-001', passengerName: 'Alice' },
      { vanPlate: 'UVE-001', passengerName: 'Bob' },
      { vanPlate: 'UVE-002', passengerName: 'Charlie' },
      { vanPlate: 'UVE-003', passengerName: 'David' },
      { vanPlate: 'UVE-004', passengerName: 'Eva' },
    ];

    for (const data of reservationsData) {
      // Find the van by plateNumber
      const van = vans.find(v => v.plateNumber === data.vanPlate);
      if (!van) continue; // skip if van not found

      if (van.availableSeats <= 0) {
        console.log(`No available seats for van ${van.plateNumber}, skipping reservation for ${data.passengerName}`);
        continue;
      }

      // Create reservation
      const reservation = new Reservation({
        van: van._id,
        passengerName: data.passengerName,
        seatNumber: van.totalSeats - van.availableSeats + 1,
      });
      await reservation.save();

      // Decrease availableSeats
      van.availableSeats -= 1;
      await van.save();
    }

    console.log("Reservations seeded successfully!");
    mongoose.connection.close();
  } catch (err) {
    console.error("Seeding error:", err);
    mongoose.connection.close();
  }
};

seedReservations();

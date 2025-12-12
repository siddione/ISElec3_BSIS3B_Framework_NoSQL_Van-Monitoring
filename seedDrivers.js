require('dotenv').config();
const mongoose = require('mongoose');
const bcrypt = require('bcrypt');
const Driver = require('./models/Driver');

mongoose.connect(process.env.MONGO_URI)
  .then(() => console.log("MongoDB connected successfully!"))
  .catch((err) => console.log("MongoDB connection error:", err));

async function seed() {
  try {
    const hashedPassword = await bcrypt.hash("password123", 10);

    const drivers = [
      {
        name: "Juan Dela Cruz",
        email: "juan@example.com",
        licenseId: "L1234567",
        age: 30,
        birthday: new Date("1993-01-01"),
        address: "Polangui, Albay",
        profilePicture: "",
        password: hashedPassword
      },
      {
        name: "Maria Santos",
        email: "maria@example.com",
        licenseId: "L7654321",
        age: 28,
        birthday: new Date("1995-06-15"),
        address: "Legazpi City, Albay",
        profilePicture: "",
        password: hashedPassword
      }
    ];

    await Driver.deleteMany({});
    await Driver.insertMany(drivers);
    console.log("Drivers inserted!");
    mongoose.connection.close();
  } catch (err) {
    console.log(err);
  }
}

seed();

// backend/models/Driver.js
const mongoose = require("mongoose");

const driverSchema = new mongoose.Schema({
  name: { type: String, required: true },
  licenseId: { type: String, required: true, unique: true },
  address: { type: String },
  age: { type: Number },
  birthday: { type: Date },
  email: { type: String, required: true, unique: true },
  password: { type: String, required: true },
  profilePic: { type: String }, // store path or URL
  van: { type: mongoose.Schema.Types.ObjectId, ref: "Van" }, // link driver to van
});

module.exports = mongoose.model("Driver", driverSchema);

const mongoose = require('mongoose');

const vanSchema = new mongoose.Schema({
  plateNumber: { type: String, required: true },
  route: { type: String, required: true },
  driverName: { type: String, required: true },
  totalSeats: { type: Number, required: true },
  availableSeats: { type: Number, required: true },
  status: { 
    type: String, 
    enum: ['Arrived', 'Waiting', 'Traveling', 'Parked'], 
    default: 'Waiting' 
  }
}, { collection: 'vans' }); // collection name in DB

module.exports = mongoose.model('Van', vanSchema); // model name must match ref in Reservation

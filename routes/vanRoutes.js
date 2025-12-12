const express = require('express');
const router = express.Router();
const mongoose = require('mongoose');
const Van = require('../models/Van');

// GET /vans → return all vans
router.get('/', async (req, res) => {
  try {
    const vans = await Van.find();
    res.status(200).json(vans);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// GET /vans/:id/status → get the current status of a van
router.get('/:id/status', async (req, res) => {
  const vanId = req.params.id;

  if (!mongoose.Types.ObjectId.isValid(vanId)) {
    return res.status(400).json({ error: "Invalid van ID format" });
  }

  try {
    const van = await Van.findById(vanId);
    if (!van) return res.status(404).json({ error: "Van not found" });
    res.status(200).json({ status: van.status });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// PUT /vans/:id/status → update van status
router.put('/:id/status', async (req, res) => {
  const vanId = req.params.id;
  const { status } = req.body;

  const allowedStatuses = ['Arrived', 'Waiting', 'Traveling', 'Parked'];

  if (!mongoose.Types.ObjectId.isValid(vanId)) return res.status(400).json({ error: "Invalid van ID" });
  if (!status || !allowedStatuses.includes(status)) return res.status(400).json({ error: `Status must be one of ${allowedStatuses.join(', ')}` });

  try {
    const van = await Van.findById(vanId);
    if (!van) return res.status(404).json({ error: "Van not found" });

    van.status = status;
    await van.save();

    res.status(200).json({ message: "Van status updated", van });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// PUT /vans/:id → update van info
router.put('/:id', async (req, res) => {
  const vanId = req.params.id;
  const { plateNumber, route, totalSeats } = req.body;

  if (!mongoose.Types.ObjectId.isValid(vanId)) return res.status(400).json({ error: "Invalid van ID" });

  try {
    const van = await Van.findById(vanId);
    if (!van) return res.status(404).json({ error: "Van not found" });

    if (plateNumber) van.plateNumber = plateNumber;
    if (route) van.route = route;
    if (totalSeats && totalSeats > 0) {
      if (van.availableSeats > totalSeats) van.availableSeats = totalSeats;
      van.totalSeats = totalSeats;
    }

    await van.save();
    res.status(200).json({ message: "Van updated", van });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;

const express = require("express");
const router = express.Router();
const bcrypt = require("bcrypt");
const jwt = require("jsonwebtoken");
const Driver = require("../models/Driver");
const Van = require("../models/Van");
const authDriver = require("../middleware/authDriver");
const multer = require("multer");
const path = require("path");

/* ================= MULTER CONFIG ================= */
const storage = multer.diskStorage({
  destination: (req, file, cb) => cb(null, "uploads/drivers"),
  filename: (req, file, cb) =>
    cb(null, Date.now() + path.extname(file.originalname)),
});

const upload = multer({
  storage,
  fileFilter: (req, file, cb) => {
    const allowed = ["image/jpeg", "image/png", "image/jpg"];
    if (!allowed.includes(file.mimetype)) {
      return cb(new Error("Only images allowed"), false);
    }
    cb(null, true);
  },
});

/* ================= REGISTER DRIVER ================= */
router.post("/register", async (req, res) => {
  try {
    const {
      name,
      licenseId,
      address,
      age,
      birthday,
      email,
      password,
      plateNumber,
    } = req.body;

    if (!name || !licenseId || !email || !password || !plateNumber) {
      return res.status(400).json({ error: "Required fields missing" });
    }

    const existing = await Driver.findOne({ email });
    if (existing) return res.status(400).json({ error: "Email already registered" });

    const hashedPassword = await bcrypt.hash(password, 10);

    const driver = await Driver.create({
      name,
      licenseId,
      address,
      age,
      birthday,
      email,
      password: hashedPassword,
    });

    const van = await Van.create({
      plateNumber,
      driver: driver._id,
      status: "Waiting",
      availableSeats: 12,
    });

    driver.van = van._id;
    await driver.save();

    res.status(201).json({ message: "Driver registered", driver, van });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Server error" });
  }
});

/* ================= LOGIN DRIVER ================= */
router.post("/login", async (req, res) => {
  try {
    const { email, password } = req.body;

    const driver = await Driver.findOne({ email });
    if (!driver) return res.status(401).json({ error: "Invalid credentials" });

    const isMatch = await bcrypt.compare(password, driver.password);
    if (!isMatch) return res.status(401).json({ error: "Invalid credentials" });

    const token = jwt.sign({ id: driver._id }, process.env.JWT_SECRET, { expiresIn: "1d" });

    res.json({
      token,
      driver: {
        id: driver._id,
        name: driver.name,
        email: driver.email,
        van: driver.van,
      },
    });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Server error" });
  }
});

/* ================= UPDATE VAN STATUS ================= */
router.put("/:id/van-status", authDriver, async (req, res) => {
  const driverId = req.params.id;
  const { status } = req.body;
  const allowedStatuses = ["Waiting", "Traveling", "Arrived", "Parked"];

  if (!allowedStatuses.includes(status)) return res.status(400).json({ error: "Invalid status" });

  try {
    if (req.driver._id.toString() !== driverId) return res.status(403).json({ error: "Unauthorized access" });

    const driver = await Driver.findById(driverId).populate("van");
    if (!driver || !driver.van) return res.status(404).json({ error: "Driver or van not found" });

    driver.van.status = status;

    // Auto-reset seats when Arrived
    if (status === "Arrived") {
      driver.van.availableSeats = 12;
    }

    await driver.van.save();

    res.json({ message: "Van status updated successfully", van: driver.van });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Server error" });
  }
});

/* ================= GET DRIVER PROFILE ================= */
router.get("/me", authDriver, async (req, res) => {
  try {
    const driver = await Driver.findById(req.driver._id).populate("van").select("-password");
    res.json(driver);
  } catch (err) {
    res.status(500).json({ error: "Failed to fetch driver profile" });
  }
});

/* ================= UPLOAD PROFILE PIC ================= */
router.put("/:id/profile-pic", authDriver, upload.single("profilePic"), async (req, res) => {
  try {
    if (req.driver._id.toString() !== req.params.id) return res.status(403).json({ error: "Unauthorized" });

    const driver = await Driver.findById(req.params.id);
    driver.profilePic = `/uploads/drivers/${req.file.filename}`;
    await driver.save();

    res.json({ profilePic: driver.profilePic });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Failed to upload profile picture" });
  }
});

/* ================= DELETE DRIVER ACCOUNT ================= */
router.delete("/me", authDriver, async (req, res) => {
  try {
    const driver = await Driver.findById(req.driver._id);
    if (!driver) return res.status(404).json({ error: "Driver not found" });

    // Delete associated van if exists
    if (driver.van) await Van.findByIdAndDelete(driver.van);

    await Driver.findByIdAndDelete(req.driver._id);

    res.json({ message: "Driver account deleted successfully" });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Server error" });
  }
});

module.exports = router;

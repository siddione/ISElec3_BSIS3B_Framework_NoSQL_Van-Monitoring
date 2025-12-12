    // backend/routes/driverRoutes.js
    const express = require("express");
    const router = express.Router();
    const bcrypt = require("bcrypt");
    const jwt = require("jsonwebtoken");
    const Driver = require("../models/Driver");
    const Van = require("../models/Van");

    // Register driver
    router.post("/register", async (req, res) => {
    const { name, licenseId, address, age, birthday, email, password, profilePic } = req.body;

    if (!name || !licenseId || !email || !password) {
        return res.status(400).json({ error: "Name, license, email, and password are required" });
    }

    try {
        const hashedPassword = await bcrypt.hash(password, 10);
        const driver = new Driver({
        name,
        licenseId,
        address,
        age,
        birthday,
        email,
        password: hashedPassword,
        profilePic,
        });
        await driver.save();
        res.status(201).json({ message: "Driver registered successfully" });
    } catch (err) {
        console.error(err);
        res.status(500).json({ error: "Server error" });
    }
    });

    // Login driver
    router.post("/login", async (req, res) => {
    const { email, password } = req.body;
    if (!email || !password)
        return res.status(400).json({ error: "Email and password required" });

    try {
        const driver = await Driver.findOne({ email }).populate("van");
        if (!driver) return res.status(404).json({ error: "Driver not found" });

        const match = await bcrypt.compare(password, driver.password);
        if (!match) return res.status(401).json({ error: "Incorrect password" });

        const token = jwt.sign({ id: driver._id }, process.env.JWT_SECRET || "secret", {
        expiresIn: "2h",
        });

        res.json({ token, driver });
    } catch (err) {
        console.error(err);
        res.status(500).json({ error: "Server error" });
    }
    });

    // Update van status (driver panel)
    router.put("/:id/van-status", async (req, res) => {
    const driverId = req.params.id;
    const { status } = req.body;
    const allowedStatuses = ["Waiting", "Traveling", "Arrived", "Parked"];

    if (!allowedStatuses.includes(status))
        return res.status(400).json({ error: "Invalid status" });

    try {
        const driver = await Driver.findById(driverId).populate("van");
        if (!driver || !driver.van) return res.status(404).json({ error: "Driver or van not found" });

        driver.van.status = status;
        await driver.van.save();

        res.json({ message: "Van status updated", van: driver.van });
    } catch (err) {
        console.error(err);
        res.status(500).json({ error: "Server error" });
    }
    });

    // GET all drivers (for testing / admin)
    router.get("/", async (req, res) => {
    try {
        const drivers = await Driver.find().select("-password"); // exclude passwords
        res.json(drivers);
    } catch (err) {
        res.status(500).json({ error: "Failed to fetch drivers" });
    }
    });

    // Delete a driver account by ID
    router.delete("/:id", async (req, res) => {
    const driverId = req.params.id;

    try {
        const driver = await Driver.findById(driverId);
        if (!driver) return res.status(404).json({ error: "Driver not found" });

        // Optional: Also remove the associated van if needed
        // if (driver.van) await Van.findByIdAndDelete(driver.van);

        await Driver.findByIdAndDelete(driverId);
        res.json({ message: "Driver account deleted successfully" });
    } catch (err) {
        console.error(err);
        res.status(500).json({ error: "Server error" });
    }
    });

    module.exports = router;

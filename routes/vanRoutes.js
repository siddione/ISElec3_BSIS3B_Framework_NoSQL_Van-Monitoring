const express = require("express");
const router = express.Router();
const vanController = require("../controllers/vanController");

router.get("/vans", vanController.getVans);
router.post("/reservations", vanController.addReservation);

module.exports = router;

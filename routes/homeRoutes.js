// routes/homeRoutes.js
const express = require('express');
const router = express.Router();
const homeController = require('../controllers/homeController');

// GET home route
router.get('/', homeController.getHome);

module.exports = router;

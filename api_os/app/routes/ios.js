const express = require('express');

const {
    purchase
} = require('../controllers/PurchaseController');


const router = express.Router();

router.route('/purchase')
    .post(purchase);

module.exports = router;
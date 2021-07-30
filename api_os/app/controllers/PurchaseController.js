const moment = require('moment-timezone');

exports.purchase = (req, res, next)  => {
    const receipt = req.body.receipt;
    const client = req.body.client;

    let lastLetter = receipt.slice(-1)

    let now = moment().tz('America/Denver').format('YYYY-MM-DD hh:mm:ss');

    if (lastLetter % 2 === 1) {
        res.status(200).json({
            status: true,
            expire_date: now,
            client: client
        });
    }
    else {
        res.status(200).json({
            status: false,
            client: client,
        });
    }
};
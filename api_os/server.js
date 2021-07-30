const express       = require('express');
const cookieParser  = require('cookie-parser');
const helmet        = require('helmet');
const xssClean      = require('xss-clean');
const rateLimit     = require('express-rate-limit');
const cors          = require('cors');

const errorHandler  = require('./app/middlewares/error');

// Route files
const googleRouter = require('./app/routes/google');
const iosRouter   = require('./app/routes/ios');

const app = express();

// Body parser
app.use(express.json());

// Cookie parser
app.use(cookieParser());

// Set security headers
app.use(helmet());

// Prevent XSS attacks
app.use(xssClean());

// Rate limiting
app.use(rateLimit({
    windowMs: 10 * 60 * 1000, // 10 mins
    max: 100
}));

// Enable CORS
app.use(cors());

// Mount routers
app.use('/api/v1/google', googleRouter);
app.use('/api/v1/ios', iosRouter);

app.use(errorHandler);

const PORT = 3000;

const server = app.listen(PORT, () => { console.log(`Server running in on port ${PORT}`); });

// Handle unhandled promise rejections
process.on('unhandledRejection', (err, promise) => {
    console.log(`Error: ${err.message}`.red);
    // Close server & exit process
    server.close(() => process.exit(1));
});
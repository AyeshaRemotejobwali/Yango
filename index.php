<?php
session_start();
if (isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yango Clone - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        header {
            background: #1a73e8;
            color: white;
            padding: 20px;
            border-radius: 10px;
        }
        header h1 {
            margin: 0;
            font-size: 2.5em;
        }
        .services {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
        }
        .service-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 30%;
            transition: transform 0.3s;
        }
        .service-card:hover {
            transform: translateY(-10px);
        }
        .service-card h3 {
            color: #1a73e8;
        }
        .btn {
            background: #1a73e8;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px;
            display: inline-block;
        }
        .btn:hover {
            background: #1557b0;
        }
        footer {
            margin-top: 40px;
            padding: 20px;
            background: #1a73e8;
            color: white;
            border-radius: 10px;
        }
        @media (max-width: 768px) {
            .services {
                flex-direction: column;
            }
            .service-card {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome to Yango Clone</h1>
            <p>Your one-stop solution for ride-hailing and parcel delivery</p>
        </header>
        <div class="services">
            <div class="service-card">
                <h3>Ride-Hailing</h3>
                <p>Book a ride to your destination with ease and track your driver in real-time.</p>
                <a href="#" onclick="window.location.href='signup.php'" class="btn">Get Started</a>
            </div>
            <div class="service-card">
                <h3>Parcel Delivery</h3>
                <p>Send packages quickly and securely with our reliable delivery service.</p>
                <a href="#" onclick="window.location.href='signup.php'" class="btn">Get Started</a>
            </div>
        </div>
        <div>
            <a href="#" onclick="window.location.href='login.php'" class="btn">Login</a>
            <a href="#" onclick="window.location.href='signup.php'" class="btn">Sign Up</a>
        </div>
        <footer>
            <p>&copy; 2025 Yango Clone. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>

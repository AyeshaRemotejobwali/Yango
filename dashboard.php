<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'user') {
    echo "<script>window.location.href='login.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Yango Clone</title>
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
        }
        header {
            background: #1a73e8;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .options {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
        }
        .option-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 30%;
            text-align: center;
            transition: transform 0.3s;
        }
        .option-card:hover {
            transform: translateY(-10px);
        }
        .option-card h3 {
            color: #1a73e8;
        }
        .btn {
            background: #1a73e8;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .btn:hover {
            background: #1557b0;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            .options {
                flex-direction: column;
            }
            .option-card {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>User Dashboard</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_id']); ?>!</p>
        </header>
        <div class="options">
            <div class="option-card">
                <h3>Book a Ride</h3>
                <p>Request a ride to your destination.</p>
                <a href="#" onclick="window.location.href='book_ride.php'" class="btn">Book Now</a>
            </div>
            <div class="option-card">
                <h3>Send a Parcel</h3>
                <p>Schedule a delivery for your package.</p>
                <a href="#" onclick="window.location.href='book_delivery.php'" class="btn">Send Now</a>
            </div>
        </div>
        <div class="logout">
            <a href="#" onclick="window.location.href='logout.php'" class="btn">Logout</a>
        </div>
    </div>
</body>
</html>

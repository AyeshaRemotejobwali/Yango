<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'user') {
    echo "<script>window.location.href='login.php';</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];
    // Simulate fare calculation (e.g., $2 per km)
    $distance = rand(1, 50); // Simulated distance
    $fare = $distance * 2;
    
    try {
        $stmt = $pdo->prepare("INSERT INTO rides (user_id, pickup_location, dropoff_location, fare) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $pickup, $dropoff, $fare]);
        $ride_id = $pdo->lastInsertId();
        $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message, type) VALUES (?, ?, 'ride')");
        $stmt->execute([$_SESSION['user_id'], "Your ride has been booked! Fare: $$fare"]);
        echo "<script>alert('Ride booked! Tracking started.'); startTracking($ride_id);</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Ride - Yango Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            color: #1a73e8;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .btn {
            background: #1a73e8;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
        }
        .btn:hover {
            background: #1557b0;
        }
        #map {
            height: 300px;
            background: #e0e0e0;
            border-radius: 10px;
            margin-top: 20px;
            text-align: center;
            line-height: 300px;
        }
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
        }
    </style>
    <script>
        function startTracking(rideId) {
            const map = document.getElementById('map');
            let progress = 0;
            const interval = setInterval(() => {
                progress += 10;
                map.innerHTML = `Tracking Ride #${rideId}: ${progress}% Complete`;
                if (progress >= 100) {
                    clearInterval(interval);
                    map.innerHTML = `Ride #${rideId} Completed!`;
                }
            }, 2000);
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Book a Ride</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="pickup">Pickup Location</label>
                    <input type="text" id="pickup" name="pickup" required>
                </div>
                <div class="form-group">
                    <label for="dropoff">Drop-off Location</label>
                    <input type="text" id="dropoff" name="dropoff" required>
                </div>
                <button type="submit" class="btn">Book Ride</button>
            </form>
            <div id="map">Enter locations to start tracking</div>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="#" onclick="window.location.href='dashboard.php'" class="btn">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>

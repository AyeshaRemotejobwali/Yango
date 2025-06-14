<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'driver') {
    echo "<script>window.location.href='login.php';</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];
    $type = $_POST['type'];
    $table = $type == 'ride' ? 'rides' : 'deliveries';
    try {
        $stmt = $pdo->prepare("UPDATE $table SET driver_id = ?, status = 'accepted' WHERE id = ?");
        $stmt->execute([$_SESSION['user_id'], $request_id]);
        $stmt = $pdo->prepare("UPDATE drivers SET status = 'busy' WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        echo "<script>alert('Request accepted!');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

$rides = $pdo->query("SELECT r.*, u.name AS user_name FROM rides r JOIN users u ON r.user_id = u.id WHERE r.status = 'pending'")->fetchAll();
$deliveries = $pdo->query("SELECT d.*, u.name AS user_name FROM deliveries d JOIN users u ON d.user_id = u.id WHERE d.status = 'pending'")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard - Yango Clone</title>
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
        .requests {
            margin-top: 40px;
        }
        .request-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .request-card h3 {
            color: #1a73e8;
        }
        .btn {
            background: #1a73e8;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background: #1557b0;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        @media (max-width: 768px) {
            .request-card {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Driver Dashboard</h1>
            <p>Welcome, Driver <?php echo htmlspecialchars($_SESSION['user_id']); ?>!</p>
        </header>
        <div class="requests">
            <h2>Available Requests</h2>
            <h3>Rides</h3>
            <?php foreach ($rides as $ride): ?>
                <div class="request-card">
                    <h3>Ride Request from <?php echo htmlspecialchars($ride['user_name']); ?></h3>
                    <p>Pickup: <?php echo htmlspecialchars($ride['pickup_location']); ?></p>
                    <p>Drop-off: <?php echo htmlspecialchars($ride['dropoff_location']); ?></p>
                    <p>Fare: $<?php echo number_format($ride['fare'], 2); ?></p>
                    <form method="POST">
                        <input type="hidden" name="request_id" value="<?php echo $ride['id']; ?>">
                        <input type="hidden" name="type" value="ride">
                        <button type="submit" class="btn">Accept Ride</button>
                    </form>
                </div>
            <?php endforeach; ?>
            <h3>Deliveries</h3>
            <?php foreach ($deliveries as $delivery): ?>
                <div class="request-card">
                    <h3>Delivery Request from <?php echo htmlspecialchars($delivery['user_name']); ?></h3>
                    <p>Pickup: <?php echo htmlspecialchars($delivery['pickup_location']); ?></p>
                    <p>Drop-off: <?php echo htmlspecialchars($delivery['dropoff_location']); ?></p>
                    <p>Package: <?php echo htmlspecialchars($delivery['package_details']); ?></p>
                    <p>Fare: $<?php echo number_format($delivery['fare'], 2); ?></p>
                    <form method="POST">
                        <input type="hidden" name="request_id" value="<?php echo $delivery['id']; ?>">
                        <input type="hidden" name="type" value="delivery">
                        <button type="submit" class="btn">Accept Delivery</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="logout">
            <a href="#" onclick="window.location.href='logout.php'" class="btn">Logout</a>
        </div>
    </div>
</body>
</html>

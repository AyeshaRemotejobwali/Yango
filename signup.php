<?php
session_start();
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $type = $_POST['type'];
    
    try {
        if ($type == 'user') {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $password, $phone]);
            echo "<script>alert('User registered successfully!'); window.location.href='login.php';</script>";
        } else {
            $vehicle_type = $_POST['vehicle_type'];
            $license_plate = $_POST['license_plate'];
            $stmt = $pdo->prepare("INSERT INTO drivers (name, email, password, phone, vehicle_type, license_plate) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $password, $phone, $vehicle_type, $license_plate]);
            echo "<script>alert('Driver registered successfully!'); window.location.href='login.php';</script>";
        }
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
    <title>Sign Up - Yango Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #1a73e8;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input, select {
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
        .driver-fields {
            display: none;
        }
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            color: #1a73e8;
            text-decoration: none;
        }
        @media (max-width: 480px) {
            .form-container {
                padding: 20px;
            }
        }
    </style>
    <script>
        function toggleDriverFields() {
            const type = document.getElementById('type').value;
            const driverFields = document.getElementById('driverFields');
            driverFields.style.display = type === 'driver' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h2>Sign Up</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="type">Account Type</label>
                <select id="type" name="type" onchange="toggleDriverFields()" required>
                    <option value="user">User</option>
                    <option value="driver">Driver</option>
                </select>
            </div>
            <div id="driverFields" class="driver-fields">
                <div class="form-group">
                    <label for="vehicle_type">Vehicle Type</label>
                    <input type="text" id="vehicle_type" name="vehicle_type">
                </div>
                <div class="form-group">
                    <label for="license_plate">License Plate</label>
                    <input type="text" id="license_plate" name="license_plate">
                </div>
            </div>
            <button type="submit" class="btn">Sign Up</button>
        </form>
        <div class="link">
            <p>Already have an account? <a href="#" onclick="window.location.href='login.php'">Login</a></p>
        </div>
    </div>
</body>
</html>

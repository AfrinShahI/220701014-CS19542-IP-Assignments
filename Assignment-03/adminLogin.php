<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        .container {
            width: 400px;
            margin: 0 auto;
            margin-top: 100px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #29a1e1;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Login</h2>
    <form action="" method="POST" id="adminLoginForm">
        <div class="form-group">
            <label for="adminUsername">Username:</label>
            <input type="text" id="adminUsername" name="adminUsername" required>
        </div>
        <div class="form-group">
            <label for="adminPassword">Password:</label>
            <input type="password" id="adminPassword" name="adminPassword" required>
        </div>
        <input class="btn" type="submit" value="Login" name="adminLogin">
    </form>
</div>

<?php
// Database connection
include 'db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['adminLogin'])) {
        // Handle admin login logic
        
        $adminUsername = $_POST['adminUsername'];
        $adminPassword = $_POST['adminPassword'];
        
        $sql = "SELECT * FROM users WHERE username = '$adminUsername' AND is_admin = 1"; // Check if user is admin
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $admin = mysqli_fetch_assoc($result);
            
            // Check if the password matches
            if ($admin['password'] === $adminPassword) {
                session_start();
                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['is_admin'] = true;

                header("Location: adminDashboard.php"); // Redirect to admin dashboard
                exit();
            } else {
                echo "<p style='text-align:center;color:red;'>Invalid password.</p>";
            }
        } else {
            echo "<p style='text-align:center;color:red;'>No admin found with that username.</p>";
        }
    }
}
?>

</body>
</html>

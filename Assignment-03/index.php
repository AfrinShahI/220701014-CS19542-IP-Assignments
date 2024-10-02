<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration</title>
    <style>
        .container {
            width: 400px;
            margin: 0 auto;
            margin-top: 50px;
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
        input[type="text"], input[type="email"], input[type="password"] {
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
        .toggle-btn {
            color: blue;
            border: none;
            cursor: pointer;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div id="loginContainer" style="display:block;">
        <h2>Login</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input class="btn" type="submit" value="Login" name="login">
        </form>
        <p>New user? <button class="toggle-btn" id="toggleRegister">Register Here</button></p>
    </div>

    <div id="registerContainer" style="display:none;">
        <h2>Register</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="regUsername">Username:</label>
                <input type="text" id="regUsername" name="regUsername" required>
            </div>
            <div class="form-group">
                <label for="regEmail">Email:</label>
                <input type="email" id="regEmail" name="regEmail" required>
            </div>
            <div class="form-group">
                <label for="regPassword">Password:</label>
                <input type="password" id="regPassword" name="regPassword" required>
            </div>
            <input class="btn" type="submit" value="Register" name="register">
            <p>Already Registered? <button class="toggle-btn" id="toggleLogin">Login Here</button></p>
        </form>
    </div>
</div>

<script>
    document.getElementById('toggleRegister').addEventListener('click', function() {
        document.getElementById('registerContainer').style.display = 'block';
        document.getElementById('loginContainer').style.display = 'none';
    });
    
    document.getElementById('toggleLogin').addEventListener('click', function() {
        document.getElementById('registerContainer').style.display = 'none';
        document.getElementById('loginContainer').style.display = 'block';
    });
</script>

<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // Handle login logic
        $username = $_POST['username'];
        $password = $_POST['password'];

        // SQL to check user credentials
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Check if the password matches
            if ($user['password'] === $password) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'] == 1;

                // Redirect based on user role
                if ($_SESSION['is_admin']) {
                    header("Location: adminDashboard.php");
                } else {
                    header("Location: home.php");
                }
                exit();
            } else {
                echo "<p style='text-align:center;color:red;'>Invalid password.</p>";
            }
        } else {
            echo "<p style='text-align:center;color:red;'>No user found with that username.</p>";
        }
    } elseif (isset($_POST['register'])) {
        // Handle registration logic
        $regUsername = $_POST['regUsername'];
        $regEmail = $_POST['regEmail'];
        $regPassword = $_POST['regPassword'];

        // Check if the user already exists
        $sql = "SELECT * FROM users WHERE username = '$regUsername'";
        $checkResult = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($checkResult) > 0) {
            echo "<p style='text-align:center;color:red;'>Username already taken. Please choose a different one.</p>";
        } else {
            $sqlInsert = "INSERT INTO users (username, email, password, is_admin) VALUES ('$regUsername', '$regEmail', '$regPassword', 0)";
            if (mysqli_query($conn, $sqlInsert)) {
                echo "<p style='text-align:center;color:green;'>Registration successful. You can now log in.</p>";
            } else {
                echo "<p style='text-align:center;color:red;'>Error: " . mysqli_error($conn) . "</p>";
            }
        }
    }
}
?>

</body>
</html>

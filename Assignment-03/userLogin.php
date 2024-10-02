<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
        <h2>User Login</h2>
        <form action="" method="POST" id="loginForm">
        <div class="form-group">
            <label for="loginUsername">Username:</label>
            <input type="text" id="loginUsername" name="loginUsername" required>
        </div>
        <div class="form-group">
            <label for="loginPassword">Password:</label>
            <input type="password" id="loginPassword" name="loginPassword" required>
        </div>
        <input class="btn" type="submit" value="Login" name="login">
        </form>
        <hr>
        <p>New user? <button class="toggle-btn" id="toggleRegister">Register Here</button></p>
    </div>

    <div id="registerContainer" style="display:none;">
        <h2>User Registration</h2>
        <form action="" method="POST" id="registerForm">
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
            <hr>
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

</body>
</html>

<?php
// Database connection
include 'db.php'; // Make sure to include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // Handle login logic
        
        $username=$_POST['loginUsername'];
        $password=$_POST['loginPassword'];
               
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Check if the password matches
            if ($user['password'] === $password) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                // Check if the user is an admin
                if ($user['is_admin'] == 1) {
                    $_SESSION['is_admin'] = true;
//                    echo "<script type='text/JavaScript'>alert('You are an Admin, login via Admin');</script>";
                    header("Location: adminLogin.php"); // Redirect to admin login
                } else {
                    $_SESSION['is_admin'] = false;
                    header("Location: home.php"); // Redirect to user home
                }
                exit();
            } else {
                echo "<p style='text-align:center;color:red;'>Invalid password.</p>";
            }
        } else {
            echo "<p style='text-align:center;color:red;'>No user found with that username.</p>";
        }
    } elseif (isset($_POST['register'])) {

        $regUsername = $_POST['regUsername'];
        $regEmail = $_POST['regEmail'];
        $regPassword = $_POST['regPassword'];
        
        // Check if the user already exists
        $sql = "SELECT * FROM users WHERE username = '$regUsername'";
        $checkResult = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($checkResult) > 0) {
            echo "<p style='text-align:center;color:red;'>Username already taken. Please choose a different one.</p>";
        } else {
            // Insert the new user into the database
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

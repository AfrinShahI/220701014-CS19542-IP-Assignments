<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #444;
            color: white;
            padding: 15px;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<nav>
    <a href="home.php">Home</a>
    <a href="events.php">Events</a>
    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true) : ?>
        <a href="adminDashboard.php">Admin Dashboard</a>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
</nav>
</body>
</html>
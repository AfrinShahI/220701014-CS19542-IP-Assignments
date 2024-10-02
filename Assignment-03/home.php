<?php
session_start();
include 'db.php'; // Database connection

// Fetch featured events (only events marked as featured)
$featured_events = [];
$sql = "SELECT * FROM events WHERE featured = 1"; 
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $featured_events[] = $row;
    }
}

// Handle event search
$search_results = [];
$no_results_found = false;

if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
    $search_sql = "SELECT * FROM events WHERE title LIKE '%$search_query%'";
    $search_result = mysqli_query($conn, $search_sql);

    if ($search_result) {
        while ($row = mysqli_fetch_assoc($search_result)) {
            $search_results[] = $row;
        }
    }
    
    if (empty($search_results)) {
        $no_results_found = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Event Management</title>
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
        .container {
            width: 85%;
            margin: 20px auto;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        .featured {
            margin-top: 30px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .event-card {
            width: 30%;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px #a7f5fc;
            transition: transform 0.2s ease-in-out;
        }
        .event-card:hover {
            transform: translateY(-10px);
        }
        .event-card h3 {
            color: #444;
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .event-card p {
            color: #666;
            margin: 5px 0;
        }
        .event-card p strong {
            color: #444;
        }
        .search-bar {
            margin-top: 20px;
            margin-bottom: 40px;
            text-align: center;
        }
        .search-bar input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .search-bar input[type="submit"] {
            background-color: #29a1e1;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }
        .search-bar input[type="submit"]:hover {
            background-color: #007bb5;
        }
        .error {
            display: block;
            width: 100%;            
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

<div class="container">
    <h1>Welcome <?php echo $_SESSION["username"]; ?> to the Event Management System</h1>

    <div class="search-bar">
        <form action="" method="POST">
            <input type="text" name="search_query" placeholder="Search for events..." required>
            <input type="submit" name="search" value="Search" class="btn">
        </form>
    </div>

    <div class="featured">
        <?php if (!empty($search_results)): ?>
            <?php foreach ($search_results as $event): ?>
                <div class="event-card">
                    <h3><?php echo $event['title']; ?></h3>
                    <p><?php echo $event['description']; ?></p>
                    <p><strong>Date:</strong> <?php echo $event['date']; ?></p>
                    <p><strong>Time:</strong> <?php echo $event['time']; ?></p>
                    <p><strong>Location:</strong> <?php echo $event['location']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $event['price']; ?></p>
                    <p><strong>Type:</strong> <?php echo $event['type']; ?></p> <!-- Display type -->
                </div>
            <?php endforeach; ?>
        <?php elseif ($no_results_found): ?>
            <h3 class="error" style="text-align: center; color: red;">No matching results found.</h3>
        <?php else: ?>
            <h2 style="display: block; width: 100%;"> Featured Events</h2>
            <?php foreach ($featured_events as $event): ?>
                <div class="event-card">
                    <h3><?php echo $event['title']; ?></h3>
                    <p><?php echo $event['description']; ?></p>
                    <p><strong>Date:</strong> <?php echo $event['date']; ?></p>
                    <p><strong>Time:</strong> <?php echo $event['time']; ?></p>
                    <p><strong>Location:</strong> <?php echo $event['location']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $event['price']; ?></p>
                    <p><strong>Type:</strong> <?php echo $event['type']; ?></p> <!-- Display type -->
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

<?php
session_start();
include 'db.php'; // Database connection

// Initialize filter variables
$date_filter = '';
$location_filter = '';
$type_filter = '';

// Initialize events array
$events = [];

// Build the SQL query based on the filters
$sql = "SELECT * FROM events WHERE 1=1"; // Start with a general query

if (isset($_POST['filter'])) {
    if (!empty($_POST['date'])) {
        $date_filter = $_POST['date'];
        $sql .= " AND date = '$date_filter'";
    }
    if (!empty($_POST['location'])) {
        $location_filter = $_POST['location'];
        $sql .= " AND location LIKE '%$location_filter%'";
    }
    if (!empty($_POST['type'])) {
        $type_filter = $_POST['type'];
        $sql .= " AND type LIKE '%$type_filter%'";
    }
}

$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - Event Management</title>
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
        .event-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .filter-bar {
            text-align: center;
            margin-bottom: 40px;
        }
        .filter-bar input,
        .filter-bar select {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #29a1e1;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #007bb5;
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
    <h1>Event Listing</h1>

    <div class="filter-bar">
        <form action="" method="POST">
            <input type="date" name="date" value="<?php echo $date_filter; ?>" placeholder="Date">
            <input type="text" name="location" value="<?php echo $location_filter; ?>" placeholder="Location">
            <input type="text" name="type" value="<?php echo $type_filter; ?>" placeholder="Type">
            <input type="submit" name="filter" value="Filter" class="btn">
        </form>
    </div>

    <h2>Events</h2>
    
    <div class="events">
        <?php if (!empty($events)): ?>
            <?php foreach ($events as $event): ?>
                <div class="event-card">
                    <h3><?php echo $event['title']; ?></h3>
                    <p><?php echo $event['description']; ?></p>
                    <p><strong>Date:</strong> <?php echo $event['date']; ?></p>
                    <p><strong>Time:</strong> <?php echo $event['time']; ?></p>
                    <p><strong>Location:</strong> <?php echo $event['location']; ?></p>
                    <p><strong>Type:</strong> <?php echo $event['type']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $event['price']; ?></p>

                    <?php if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == false): ?>
                        <a href="eventDetails.php?id=<?php echo $event['id']; ?>" class="btn">View Details</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h3 style="color:red; text-align: center;">No events found matching your criteria.</h3>
        <?php endif; ?>
    </div>
    
</div>

</body>
</html>

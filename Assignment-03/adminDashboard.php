<?php
session_start();
include 'db.php'; // Database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: adminLogin.php"); // Redirect to login if not admin
    exit();
}

// Fetch all events
$events = [];
$event_sql = "SELECT * FROM events";
$event_result = mysqli_query($conn, $event_sql);
if ($event_result) {
    while ($row = mysqli_fetch_assoc($event_result)) {
        $events[] = $row;
    }
}

// Fetch all users
$users = [];
$user_sql = "SELECT * FROM users WHERE is_admin=0";
$user_result = mysqli_query($conn, $user_sql);
if ($user_result) {
    while ($row = mysqli_fetch_assoc($user_result)) {
        $users[] = $row;
    }
}

// Handle event deletion
if (isset($_POST['delete_event'])) {
    $event_id = $_POST['event_id'];
    $delete_sql = "DELETE FROM events WHERE id = $event_id";
    mysqli_query($conn, $delete_sql);
    header("Location: adminDashboard.php"); // Refresh to see changes
    exit();
}

// Handle event addition
if (isset($_POST['add_event'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $type = $_POST['type']; // Get the event type
    $featured = isset($_POST['featured']) ? 1 : 0;

    $insert_sql = "INSERT INTO events (title, description, date, time, location, price, type, featured) VALUES ('$title', '$description', '$date', '$time', '$location', '$price', '$type', '$featured')";
    
    mysqli_query($conn, $insert_sql);
    header("Location: adminDashboard.php"); // Refresh to see new event
    exit();
}

// Handle user deletion
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $delete_user_sql = "DELETE FROM users WHERE id = $user_id";
    mysqli_query($conn, $delete_user_sql);
    header("Location: adminDashboard.php"); // Refresh to see changes
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            width: 80%;
            margin: 20px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            background-color: #29a1e1;
            color: white;
            border: none;
            padding: 10px 5px;
            width: 100px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #007bb5;
        }
        .form {
            margin: auto;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;  
        }
        .inputs {
            width: 50%;
            padding: 10px;
        }
    </style>
</head>
<body>

<nav>
    <a href="home.php">Home</a>
    <a href="events.php">Events</a>
    <a href="adminDashboard.php">Admin Dashboard</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="container">
    <h2 style="text-align:center;">Admin Dashboard</h2>

    <!-- Event Management Section -->
    <div class="form">
        <h3>Add New Event</h3>
        <form class="form" action="" method="POST">
            <input class="inputs" type="text" name="title" placeholder="Event Title" required>
            <textarea class="inputs" name="description" placeholder="Event Description" required></textarea>
            <input class="inputs" type="date" name="date" required>
            <input class="inputs" type="time" name="time" required>
            <input class="inputs" type="text" name="location" placeholder="Event Location" required>
            <input class="inputs" type="number" name="price" placeholder="Ticket Price" required>
            <input class="inputs" type="text" name="type" placeholder="Event Type" required> <!-- New field for type -->
            <div>
                <label for="featured">Mark as Featured:</label>
                <input type="checkbox" name="featured" id="featured" value="1">
            </div>
            <input type="submit" name="add_event" value="Add Event" class="btn">
        </form>
    </div>
    
    <h3>Existing Events</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>Type</th> <!-- New column for type -->
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php foreach ($events as $event) : ?>
        <tr>
            <td><?php echo $event['id']; ?></td>
            <td><?php echo $event['title']; ?></td>
            <td><?php echo $event['description']; ?></td>
            <td><?php echo $event['date']; ?></td>
            <td><?php echo $event['time']; ?></td>
            <td><?php echo $event['location']; ?></td>
            <td><?php echo $event['type']; ?></td> <!-- Displaying the type -->
            <td><?php echo $event['price']; ?></td>
            
            <td style="display: flex; gap: 10px;">
                <form action="editEvent.php" method="GET" style="display:inline;">
                    <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>" >
                    <input type="submit" value="Edit" class="btn" style="width: 50px;">
                </form>
                <form action="" method="POST" style="display:inline;">
                    <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>" >
                    <input type="submit" name="delete_event" value="Delete" class="btn" style="width: 50px;">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- User Management Section -->
    <br>
    <h3>Existing Users</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user) : ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td>
                <form action="" method="POST" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <input type="submit" name="delete_user" value="Delete" class="btn">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>

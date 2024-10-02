<?php
session_start();
include 'db.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: userLogin.php'); // Redirect if not logged in
    exit();
}

// Fetch the event details based on event_id
$event_id = $_GET['event_id'];
$event = [];

$sql = "SELECT * FROM events WHERE id = $event_id";
$result = mysqli_query($conn, $sql);
if ($result) {
    $event = mysqli_fetch_assoc($result);
} else {
    echo "<p style='color:red;text-align:center;'>Event not found.</p>";
}

// Handle ticket booking
if (isset($_POST['book_ticket'])) {
    $user_id = $_SESSION['user_id'];
    
    // Check if the user already booked the event
    $checkBookingSql = "SELECT * FROM bookings WHERE user_id = $user_id AND event_id = $event_id";
    $checkBookingResult = mysqli_query($conn, $checkBookingSql);

    if (mysqli_num_rows($checkBookingResult) > 0) {
        echo "<p style='color:red;text-align:center;'>You have already booked this event.</p>";
    } else {
        // Insert booking into the database
        $insertSql = "INSERT INTO bookings (user_id, event_id) VALUES ($user_id, $event_id)";
        if (mysqli_query($conn, $insertSql)) {
            echo "<p style='color:green;text-align:center;'>Ticket booked successfully!</p>";
        } else {
            echo "<p style='color:red;text-align:center;'>Error booking ticket: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>

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
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .event-details {
            margin: 30px 0;
        }
        .event-details p {
            font-size: 1.2em;
            color: #555;
        }
        .btn {
            background-color: #29a1e1;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            width: 100%;
            margin: 20px 0;
            font-size: 1.2em;
        }
        .btn:hover {
            background-color: #007bb5;
        }
        .error {
            color: red;
            text-align: center;
        }
        .success {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Event Details</h1>

    <?php if (!empty($event)): ?>
        <div class="event-details">
            <p><strong>Title:</strong> <?php echo $event['title']; ?></p>
            <p><strong>Description:</strong> <?php echo $event['description']; ?></p>
            <p><strong>Date:</strong> <?php echo $event['date']; ?></p>
            <p><strong>Time:</strong> <?php echo $event['time']; ?></p>
            <p><strong>Location:</strong> <?php echo $event['location']; ?></p>
            <p><strong>Price:</strong> $<?php echo $event['price']; ?></p>
            <p><strong>Type:</strong> <?php echo $event['type']; ?></p>
        </div>

        <form method="POST" action="">
            <input type="submit" name="book_ticket" value="Book Ticket" class="btn">
        </form>
    <?php else: ?>
        <p class="error">Event not found.</p>
    <?php endif; ?>
</div>

</body>
</html>

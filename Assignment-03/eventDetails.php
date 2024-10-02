<?php
session_start();
include 'db.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    header('Location: userLogin.php'); // Redirect if not logged in
    exit();
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    $sql = "SELECT * FROM events WHERE id = $event_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
    } else {
        echo "Event not found.";
        exit;
    }
} else {
    echo "No event ID provided.";
    exit;
}

if (isset($_POST['book_ticket'])) {
    $user_id = $_SESSION['user_id'];

    $insertSql = "INSERT INTO bookings (user_id, event_id) VALUES ($user_id, $event_id)";
    if (mysqli_query($conn, $insertSql)) {
        $booking_message = "Ticket booked successfully!";
    } else {
        $booking_message = "Error booking ticket: " . mysqli_error($conn);
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
        .btn-container{
            display: flex;
            gap: 20px;
            justify-content: center;
        }
        .btn {
            background-color: #29a1e1;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            width: 300px;
            margin: 20px 0;
            font-size: 1.2em;
            margin: auto;
        }
        .btn:hover {
            background-color: #a3d982;
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

        <?php if (isset($booking_message)): ?>
            <p class="<?php echo (strpos($booking_message, 'successfully') !== false) ? 'success' : 'error'; ?>"><?php echo $booking_message; ?></p>
        <?php endif; ?>

        <div class="btn-container">
            <form method="POST" action="">
                <input type="submit" name="book_ticket" value="Book Ticket" class="btn">
            </form>

            <form action="events.php" method="get">
                <input type="submit" value="Back to Events" class="btn">
            </form>
        </div>
        
    <?php else: ?>
        <p class="error">Event not found.</p>
    <?php endif; ?>
</div>

</body>
</html>

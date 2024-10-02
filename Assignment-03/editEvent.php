<?php
session_start();
include 'db.php'; // Database connection

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['event_id'])) {
    header("Location: adminDashboard.php");
    exit();
}

$event_id = $_GET['event_id'];

$event_sql = "SELECT * FROM events WHERE id = $event_id";
$event_result = mysqli_query($conn, $event_sql);
$event = mysqli_fetch_assoc($event_result);

if (isset($_POST['update_event'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $featured = isset($_POST['featured']) ? 1 : 0;

    $update_sql = "UPDATE events SET title = '$title', description = '$description', date = '$date', time = '$time', location = '$location', price = '$price', type = '$type', featured = '$featured' WHERE id = $event_id";
    mysqli_query($conn, $update_sql);

    header("Location: adminDashboard.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 20px auto;
        }
        .btn {
            background-color: #29a1e1;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #007bb5;
        }
        .form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .inputs {
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Event</h2>
    <form class="form" action="" method="POST">
        <input class="inputs" type="text" name="title" value="<?php echo $event['title']; ?>" required>
        <textarea class="inputs" name="description" required><?php echo $event['description']; ?></textarea>
        <input class="inputs" type="date" name="date" value="<?php echo $event['date']; ?>" required>
        <input class="inputs" type="time" name="time" value="<?php echo $event['time']; ?>" required>
        <input class="inputs" type="text" name="location" value="<?php echo $event['location']; ?>" required>
        <input class="inputs" type="number" name="price" value="<?php echo $event['price']; ?>" required>
        <input class="inputs" type="text" name="type" value="<?php echo $event['type']; ?>" required>
        <div>
            <label for="featured">Mark as Featured:</label>
            <input type="checkbox" name="featured" id="featured" value="1" <?php if ($event['featured']) echo 'checked'; ?>>
        </div>
        <input type="submit" name="update_event" value="Update Event" class="btn">
    </form>
</div>

</body>
</html>

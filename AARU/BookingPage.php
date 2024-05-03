<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "AARU");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if (isset($_GET['book']) && $_GET['book'] == 'true' && isset($_GET['trip_id'])) {
    $trip_id = $_GET['trip_id'];

    // Start transaction
    $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

    try {
        // Check current capacity
        $check_sql = "SELECT capacity FROM trips WHERE id = ?";
        $check_stmt = $conn->prepare($check_sql);
        if (!$check_stmt) {
            throw new Exception($conn->error);
        }
        $check_stmt->bind_param("i", $trip_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        if (!$check_result) {
            throw new Exception($conn->error);
        }
        $capacity_data = $check_result->fetch_assoc();

        if ($capacity_data && $capacity_data['capacity'] > 0) {
            // Reduce capacity by one
            $new_capacity = $capacity_data['capacity'] - 1;
            $update_sql = "UPDATE trips SET capacity = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            if (!$update_stmt) {
                throw new Exception($conn->error);
            }
            $update_stmt->bind_param("ii", $new_capacity, $trip_id);
            $update_stmt->execute();
            if ($update_stmt->affected_rows == 0) {
                throw new Exception("Update failed, no rows affected.");
            }

            $conn->commit();  // Commit transaction
            $message = "Booking successful! Remaining spots: " . $new_capacity;
        } else {
            $message = "Sorry, this trip is fully booked.";
        }
    } catch (Exception $e) {
        $conn->rollback();  // Rollback transaction
        $message = "Booking failed: " . $e->getMessage();
    }
}

// Fetch all trips
$sql = "SELECT * FROM trips";
$result = $conn->query($sql);
if (!$result) {
    die("SQL error: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Book a Trip</title>
</head>

<body>
    <h1>Available Trips</h1>
    <?php if ($message != "")
        echo "<p>$message</p>"; ?>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <?= htmlspecialchars($row['destination']) ?> (<?= $row['date'] ?>) - $<?= $row['price'] ?> - Spots Left:
                <?= $row['capacity'] ?>
                <button onclick="window.location.href='?book=true&trip_id=<?= $row['id'] ?>'">Book Now</button>
            </li>
        <?php endwhile; ?>
    </ul>
</body>

</html>
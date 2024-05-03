<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "AARU");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request to add a new trip
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destination = $conn->real_escape_string($_POST['destination']);
    $date = $_POST['date'];
    $price = $_POST['price'];
    $description = $conn->real_escape_string($_POST['description']);
    $capacity = $_POST['capacity'];

    $sql = "INSERT INTO trips (destination, date, price, description, capacity) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $destination, $date, $price, $description, $capacity);
    $stmt->execute();

    // Redirect to the same page to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch all trips
$sql = "SELECT * FROM trips";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Trips</title>
</head>
<body>
<h1>Add New Trip</h1>
<form method="post">
    <input type="text" name="destination" placeholder="Destination" required>
    <input type="date" name="date" required>
    <input type="number" name="price" placeholder="Price" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="number" name="capacity" placeholder="Capacity" required>
    <button type="submit">Add Trip</button>
    <a href="/AARU/Admin/AdminEdit.php" ><input type="button" value="EDIT OR DELETE" ></a>
</form>

<h1>Existing Trips</h1>
<ul>
    <?php while ($row = $result->fetch_assoc()): ?>
        <li><?= htmlspecialchars($row['destination']) ?> (<?= $row['date'] ?>) - $<?= $row['price'] ?> - Capacity: <?= $row['capacity'] ?></li>
    <?php endwhile; ?>
</ul>
</body>
</html>

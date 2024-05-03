<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "AARU");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $capacity = $_POST['capacity'];

    $update_sql = "UPDATE trips SET destination = ?, date = ?, price = ?, description = ?, capacity = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssisii", $destination, $date, $price, $description, $capacity, $id);
    $stmt->execute();
}

// Handle Delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $delete_sql = "DELETE FROM trips WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
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
    <h1>Trips Management</h1>
    <?php while ($row = $result->fetch_assoc()): ?>
        <form method="post">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="text" name="destination" value="<?= $row['destination'] ?>">
            <input type="date" name="date" value="<?= $row['date'] ?>">
            <input type="number" name="price" value="<?= $row['price'] ?>">
            <textarea name="description"><?= $row['description'] ?></textarea>
            <input type="number" name="capacity" value="<?= $row['capacity'] ?>">
            <button type="submit" name="update">Update</button>
            <button type="submit" name="delete">Delete</button>
        </form>
    <?php endwhile; ?>
</body>

</html>
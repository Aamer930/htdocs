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
    <link rel="stylesheet" href="adminedit.css">

</head>

<body>
<header class="nav-header">
        <a href="#" class="logo">𓄿𓄿𓂋𓅲</a>
        <?php
        session_start();
        if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
            echo 'HELLO, ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
        } else {
            echo 'Session variables are not set.';
        }
        session_unset();
        ?>
        <nav class="navbar">
            <ul>
                <li><a href="/AARU/HomePage.php" class="navbar_text">Home</a></li>
                <li><a href="/AARU/circleNav.php" class="navbar_text">circleNav</a></li>
                <li><a href="/AARU/Admin/Admin.php" class="navbar_text">Publish trip</a></li>
            </ul>
        </nav>
        <a href="/AARU/AboutUs/AboutUs.html"><button class="aboutus_butt">ABOUT US!!</button></a>
    </header>
    <h1>Trips Management</h1>
    <div class="container">


    
    <?php while ($row = $result->fetch_assoc()): ?>
        <form class="box" method="post">
            <input type="hidden" name="id" value="<?= $row['id'] ?>"><br>
            <input type="text" name="destination" value="<?= $row['destination'] ?>"><br>
            <input type="date" name="date" value="<?= $row['date'] ?>"><br>
            <input type="number" name="price" value="<?= $row['price'] ?>"><br>
            <textarea name="description"><?= $row['description'] ?></textarea><br>
            <input type="number" name="capacity" value="<?= $row['capacity'] ?>"><br>
            <button class="button" type="submit" name="update">Update</button>
            <button class="button" type="submit" name="delete">Delete</button>
        </form>
    <?php endwhile; ?>
</div>

<a href="/AARU/Admin/Admin.php" class="button-back">Back to Admin Page</a>

    
</body>

</html>
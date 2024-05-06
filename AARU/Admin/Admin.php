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
    $cover_photo = null;

    // Handle cover photo upload
    // This code handles the file upload process for the cover photo
    // Place this inside the form submission handling block
    if (isset($_FILES['cover_photo']) && $_FILES['cover_photo']['error'] == 0) {
        $target_dir = "uploads/";
        $cover_photo = $target_dir . basename($_FILES['cover_photo']['name']);
        move_uploaded_file($_FILES['cover_photo']['tmp_name'], $cover_photo);
    }

    $sql = "INSERT INTO trips (destination, date, price, description, capacity, cover_photo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisis", $destination, $date, $price, $description, $capacity, $cover_photo);
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
    <link rel="stylesheet" href="Admin.css">
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
                <li><a href="/AARU/BookingPage.php" class="navbar_text">book trip</a></li>

            </ul>
        </nav>
        <a href="/AARU/AboutUs/AboutUs.html"><button class="aboutus_butt">ABOUT US!!</button></a>
    </header>

    <div class="container">
        <div class="box form-box">
            <h1>Add New Trip</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <label class="label">Add destination:</label>
                <div class="field-input">
                    <input type="text" name="destination" placeholder="Destination" required>
                </div>

                <label class="label">Add date:</label>
                <div class="field-input">
                    <input type="date" name="date" required>
                </div>

                <label class="label">Add description:</label>
                <div class="field-input">
                    <textarea name="description" placeholder="Description" required></textarea>
                </div>

                <label class="label">Add Price:</label>
                <div class="field-input">
                    <input type="number" name="price" placeholder="Price" required>
                </div>

                <label class="label">Add capacity:</label>
                <div class="field-input">
                    <input type="number" name="capacity" placeholder="Capacity" required>
                </div>

                <!-- Cover photo file input -->
                <!-- This input allows the admin to upload a cover photo -->
                <label class="label">Add Cover Photo:</label>
                <div class="field-input">
                    <input type="file" name="cover_photo">
                </div>

                <div class="field">
                    <button class="button" type="submit">Add Trip</button>
                    <a href="/AARU/Admin/AdminEdit.php"><input class="button" type="button" value="EDIT OR DELETE"></a>
                </div>

                <br><hr>

                <h1>Existing Trips</h1>

                <div class="trips-field">
                    <ul>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <li class="trips-field">
                            <?= htmlspecialchars($row['destination']) ?> (<?= $row['date'] ?>) - $<?= $row['price'] ?> - Capacity: <?= $row['capacity'] ?>
                            <br> - <?= $row['description'] ?>
                            <!-- Display cover photo if available -->
                            <!-- This code checks if a cover photo exists and displays it -->
                            <?php if (!empty($row['cover_photo'])): ?>
                                <br><img src="<?= $row['cover_photo'] ?>" alt="Cover Photo" style="width:200px;height:auto;">
                            <?php endif; ?>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </form>
        </div>
    </div>

</body>

</html>

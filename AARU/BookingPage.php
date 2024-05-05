<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "AARU");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the session to manage cart and bookings
session_start();

// Initialize the cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle booking cancellation
if (isset($_GET['cancel_booking']) && isset($_GET['trip_id'])) {
    cancelBooking($conn, $_GET['trip_id']);
}

// Handle adding to cart
if (isset($_GET['add_to_cart']) && isset($_GET['trip_id']) && isset($_GET['spots'])) {
    addToCart($_GET['trip_id'], (int) $_GET['spots']);
}

// Calculate total cost of items in the cart
$total_cost = calculateTotalCost($conn);

// Fetch all available trips
$trips = fetchAllTrips($conn);

function cancelBooking($conn, $trip_id)
{
    // Check if the trip is booked and retrieve the number of spots
    $spots = $_SESSION['booked'][$trip_id] ?? 0;
    if ($spots > 0) {
        // Restore the capacity of the trip
        $stmt = $conn->prepare("UPDATE trips SET capacity = capacity + ? WHERE id = ?");
        $stmt->bind_param("ii", $spots, $trip_id);
        $stmt->execute();
        unset($_SESSION['booked'][$trip_id]);
    }
}

function addToCart($trip_id, $spots)
{
    // Add or update the trip in the cart
    $_SESSION['cart'][$trip_id] = isset($_SESSION['cart'][$trip_id]) ? $_SESSION['cart'][$trip_id] + $spots : $spots;
}

function calculateTotalCost($conn)
{
    // Calculate the total cost of the items in the cart
    $total_cost = 0;
    if (!empty($_SESSION['cart'])) {
        $cart_ids = implode(',', array_keys($_SESSION['cart']));
        $result = $conn->query("SELECT id, price FROM trips WHERE id IN ($cart_ids)");
        while ($row = $result->fetch_assoc()) {
            $total_cost += $row['price'] * $_SESSION['cart'][$row['id']];
        }
    }
    return $total_cost;
}

function fetchAllTrips($conn)
{
    // Fetch all available trips from the database
    $result = $conn->query("SELECT * FROM trips");
    if (!$result) {
        die("SQL error: " . $conn->error);
    }
    return $result;
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
    <ul>
        <?php while ($trip = $trips->fetch_assoc()): ?>
            <li>
                <?= htmlspecialchars($trip['destination']) ?> (<?= $trip['date'] ?>) - $<?= $trip['price'] ?> - Spots Left:
                <?= $trip['capacity'] ?>
                <form action="" method="get" style="display:inline;">
                    <input type="hidden" name="trip_id" value="<?= $trip['id'] ?>">
                    <input type="number" name="spots" value="1" min="1" max="<?= $trip['capacity'] ?>">
                    <input type="hidden" name="add_to_cart" value="true">
                    <input type="submit" value="Add to Cart">
                </form>
            </li>
        <?php endwhile; ?>
    </ul>

    <h2>Your Cart</h2>
    <ul>
        <?php if (!empty($_SESSION['cart'])): ?>
            <?php foreach ($_SESSION['cart'] as $trip_id => $spots): ?>
                <li>Trip ID <?= $trip_id ?> - Spots: <?= $spots ?></li>
            <?php endforeach; ?>
            <form action="payment.php" method="post">
                <input type="submit" value="Proceed to Pay">
            </form>
        <?php else: ?>
            <li>Your cart is empty.</li>
        <?php endif; ?>
    </ul>

    <h2>Booked Trips</h2>
    <ul>
        <?php if (!empty($_SESSION['booked'])): ?>
            <?php foreach ($_SESSION['booked'] as $trip_id => $spots): ?>
                <li>Trip ID <?= $trip_id ?> - Spots: <?= $spots ?>
                    <button onclick="window.location.href='?cancel_booking=true&trip_id=<?= $trip_id ?>'">Cancel
                        Booking</button>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>You have no booked trips.</li>
        <?php endif; ?>
    </ul>

    <p>Total Cost: $<?= $total_cost ?></p>
</body>

</html>
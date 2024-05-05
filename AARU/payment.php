<?php
session_start();

// Establish a connection to the database
$conn = new mysqli("localhost", "root", "", "AARU");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission for payment method
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_method'])) {
    if ($_POST['payment_method'] === 'Cash') {
        processCashPayment($conn);
    } else {
        $message = "This payment method is not yet available.";
    }
}

// Calculate total cost of items in the cart
$total_cost = calculateTotalCost($conn);

// Function to process cash payment
function processCashPayment($conn)
{
    // Start transaction
    $conn->begin_transaction();
    $_SESSION['booked'] = [];

    foreach ($_SESSION['cart'] as $trip_id => $spots) {
        if (reserveSpots($conn, $trip_id, $spots)) {
            $_SESSION['booked'][$trip_id] = $spots;
        } else {
            $conn->rollback();
            return;
        }
    }

    $conn->commit();
    $_SESSION['cart'] = [];
    header("Location: BookingPage.php?status=success");
    exit();
}

// Function to reserve spots for a trip
function reserveSpots($conn, $trip_id, $spots)
{
    $stmt = $conn->prepare("SELECT capacity FROM trips WHERE id = ?");
    $stmt->bind_param("i", $trip_id);
    $stmt->execute();
    $capacity = $stmt->get_result()->fetch_assoc()['capacity'];
    $stmt->close();

    if ($capacity >= $spots) {
        $stmt = $conn->prepare("UPDATE trips SET capacity = capacity - ? WHERE id = ?");
        $stmt->bind_param("ii", $spots, $trip_id);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    return false;
}

// Function to calculate the total cost of items in the cart
function calculateTotalCost($conn)
{
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment</title>
</head>

<body>
    <h1>Choose Payment Method</h1>
    <?php if ($message != "")
        echo "<p>$message</p>"; ?>

    <form action="" method="post">
        <label><input type="radio" name="payment_method" value="Visa" disabled> Visa (SOON)</label><br>
        <label><input type="radio" name="payment_method" value="Fawry" disabled> Fawry (SOON)</label><br>
        <label><input type="radio" name="payment_method" value="Instapay" disabled> Instapay (SOON)</label><br>
        <label><input type="radio" name="payment_method" value="Vodafone Cash" disabled> Vodafone Cash
            (SOON)</label><br>
        <label><input type="radio" name="payment_method" value="Cash" required> Cash</label><br>
        <input type="submit" value="Confirm Payment">
    </form>

    <h2>Your Cart</h2>
    <ul>
        <?= renderCartItems($conn) ?>
    </ul>
    <p>Total Cost: $<?= $total_cost ?></p>
</body>

</html>

<?php
// Function to render the cart items
function renderCartItems($conn)
{
    if (!empty($_SESSION['cart'])) {
        $cart_ids = implode(',', array_keys($_SESSION['cart']));
        $result = $conn->query("SELECT id, destination, date, price FROM trips WHERE id IN ($cart_ids)");
        $output = "";
        while ($row = $result->fetch_assoc()) {
            $destination = htmlspecialchars($row['destination']);
            $date = $row['date'];
            $price = $row['price'];
            $spots = $_SESSION['cart'][$row['id']];
            $output .= "<li>$destination ($date) - \$$price x $spots</li>";
        }
        return $output;
    } else {
        return "<li>Your cart is empty.</li>";
    }
}
?>
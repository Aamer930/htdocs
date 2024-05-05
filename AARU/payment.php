<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$db = "AARU";
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for payment method
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_method'])) {
    if ($_POST['payment_method'] === 'Cash') {
        processCashPayment($conn);
    }
}

// Calculate total cost of items in the cart
$total_cost = calculateTotalCost($conn);

// Function to process cash payment
function processCashPayment($conn) {
    // Start a database transaction
    $conn->begin_transaction();
    $_SESSION['booked'] = [];

    foreach ($_SESSION['cart'] as $trip_id => $spots) {
        if (!reserveSpots($conn, $trip_id, $spots)) {
            $conn->rollback();
            return;
        }
        $_SESSION['booked'][$trip_id] = $spots;
    }

    $conn->commit();
    $_SESSION['cart'] = [];
    header("Location: BookingPage.php?status=success");
    exit();
}

// Function to reserve spots for a trip
function reserveSpots($conn, $trip_id, $spots) {
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
function calculateTotalCost($conn) {
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

    <form action="" method="post">
        <?php renderPaymentOptions(); ?>
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
// Function to render the payment options
function renderPaymentOptions() {
    $options = [
        "Visa" => "Visa (SOON)",
        "Fawry" => "Fawry (SOON)",
        "Instapay" => "Instapay (SOON)",
        "Vodafone Cash" => "Vodafone Cash (SOON)",
        "Cash" => "Cash"
    ];
    foreach ($options as $value => $label) {
        $disabled = ($value != "Cash") ? "disabled" : "";
        $required = ($value == "Cash") ? "required" : "";
        echo "<label><input type='radio' name='payment_method' value='$value' $disabled $required> $label</label><br>";
    }
}

// Function to render the cart items
function renderCartItems($conn) {
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
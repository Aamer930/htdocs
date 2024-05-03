<?php
session_start(); // Start the session at the beginning

$servername = "localhost";
$username = "root";
$password = "";
$db = "AARU";
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT first_name, last_name, password, is_admin FROM users WHERE email = ?");
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    } else {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($firstName, $lastName, $hashed_password, $is_admin);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                $_SESSION['email'] = $email;
                $_SESSION['first_name'] = $firstName;
                $_SESSION['last_name'] = $lastName;

                if ($is_admin) {
                    $_SESSION['role'] = 'admin';
                    header("Location: /AARU/ADMIN HomePage.php");
                } else {
                    $_SESSION['role'] = 'user';
                    header("Location: /AARU/HomePage.php");
                }

                exit(); 
            } else {
                echo "Invalid credentials. Please try again or <a href='register.html'>register here</a>.";
            }
        } else {
            echo "Account not found. Please <a href='RegisterForm.HTML'>register</a>.";
        }

        $stmt->close();
    }
}
$conn->close();
?>

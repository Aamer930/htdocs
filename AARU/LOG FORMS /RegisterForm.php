<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "AARU";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phoneNumber = $_POST['phoneNumber'];
$nationality = $_POST['nationality'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$is_admin = $_POST['is_admin'];

$sql = "INSERT INTO users (email, first_name, last_name, phone_number, nationality, password, is_admin)
VALUES ('$email', '$firstName', '$lastName', '$phoneNumber', '$nationality', '$password', '$is_admin')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
  header("Location: /AARU/LOG FORMS /Login.html");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
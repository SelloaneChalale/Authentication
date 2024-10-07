<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "authentication";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input
$email = $_POST['email'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$campus = $_POST['campus'];

// Prepare and execute SQL query
$stmt = $conn->prepare("INSERT INTO admins (email, username, password, campus) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $email, $username, $password, $campus);

if ($stmt->execute()) {
    echo "Sign up successful";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
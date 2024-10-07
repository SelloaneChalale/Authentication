<?php
require_once 'google/config.php';
require_once 'google/core/controller.Class.php';

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

// Start session
session_start();

// Get user input
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($username) && !empty($password)) {
    // Prepare and execute SQL query
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists and password is correct
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Login successful
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $row['user_type'];

            // Redirect based on user type
            if ($row['user_type'] == 'admin') {
                header("Location: dashboard.php"); // Redirect to admin dashboard
            } else {
                header("Location: home.php"); // Redirect to student home
            }
            exit();
        } else {
            // Incorrect password
            $error = "Incorrect password";
        }
    } else {
        // User not found
        $error = "User not found";
    }

    $stmt->close();
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $error = "Please enter both username and password.";
    }
}

$conn->close();
?>
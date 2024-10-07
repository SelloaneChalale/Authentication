<?php
include_once('config.php');
session_start();



// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


// Get the module details
$moduleId = $_GET['id'];
$query = "SELECT * FROM modules WHERE id = '$moduleId'";
$result = $conn->query($query);
$module = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $module['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2><?php echo $module['name']; ?></h2>
    <p>Module Code: <?php echo $module['code']; ?></p>
    <p>Description: <?php echo $module['description']; ?></p>
    <!-- Add more module details as needed -->

    <a href="home.php">Back to Home</a>
</body>
</html>
<?php
session_start();

include_once('config.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}


// Get the user's current profile data
$username = $_SESSION['username'];
$query = "SELECT email, campus FROM users WHERE username = '$username'";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// Update profile if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newEmail = $_POST['email'];
    $newCampus = $_POST['campus'];

    $query = "UPDATE users SET email = '$newEmail', campus = '$newCampus' WHERE username = '$username'";
    if ($conn->query($query) === TRUE) {
        echo "Profile updated successfully";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Edit Profile</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

        <label for="campus">Campus:</label>
        <input type="text" name="campus" value="<?php echo $user['campus']; ?>" required>

        <button type="submit">Update Profile</button>
    </form>
    <a href="home.php">Back to Home</a>
</body>
</html>
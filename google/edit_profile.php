<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'authentication';

$conn = new MySQLI($host, $user, $pass, $db_name);

  


require_once('config.php');
require_once('core/controller.Class.php');

if(isset($_COOKIE['id']) && isset($_COOKIE['sess'])){
   $Controller = new Controller;
   if($Controller -> checkUserStatus($_COOKIE['id'], $_COOKIE['sess'])){
       echo $Controller -> printData(intval($_COOKIE['id']));
       $cook= $_COOKIE['id'];
      
   }
}
if(!isset($cook)){
   header("Location: ../index.php");
   exit();
}



$query = "SELECT email, campus FROM users WHERE id = '$cook'";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// Update profile if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newEmail = $_POST['email'];
    $newCampus = $_POST['campus'];

    $query = "UPDATE users SET email = '$newEmail', campus = '$newCampus' WHERE id = '$cook'";
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
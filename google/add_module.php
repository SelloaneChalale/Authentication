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


// Add the module if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $moduleCode = $_POST['module_code'];
    $userId = getUserId($cook, $conn);

    // Check if the module exists
    $query = "SELECT id FROM modules WHERE code = '$moduleCode'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $moduleId = $row['id'];

        // Check if the user is already enrolled in the module
        $query = "SELECT * FROM enrolled_modules WHERE student_id = '$userId' AND module_id = '$moduleId'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            echo "You are already enrolled in this module";
        } else {
            // Enroll the user in the module
            $query = "INSERT INTO enrolled_modules (student_id, module_id) VALUES ('$userId', '$moduleId')";
            if ($conn->query($query) === TRUE) {
                echo "Module added successfully";
            } else {
                echo "Error adding module: " . $conn->error;
            }
        }
    } else {
        echo "Module not found";
    }
}

$conn->close();

// Helper function to get the user's ID from the username
function getUserId($cook, $conn) {
    $query = "SELECT id FROM users WHERE id = '$cook'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['id'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Module</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Add Module</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="module_code">Module Code:</label>
        <input type="text" name="module_code" required>

        <button type="submit">Add Module</button>
    </form>
    <a href="home.php">Back to Home</a>
</body>
</html>
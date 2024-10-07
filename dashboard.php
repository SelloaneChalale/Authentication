<?php
// Start the session
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    // Redirect to the login page if not an admin
    header("Location: login.php");
    exit();
}

// Database connection
require_once 'config.php';

// Get the username of the logged-in admin
$admin_id = $_SESSION['user_id'];
$query = "SELECT username FROM admins WHERE id = '$admin_id'";
$result = mysqli_query($conn, $query);
$admin_username = mysqli_fetch_assoc($result)['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Dashboard</h1>
            <p>Welcome, <?php echo $admin_username; ?></p>
            <nav>
                <ul>
                    <li><a href="#" id="students-link">Students</a></li>
                    <li><a href="#" id="modules-link">Modules</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <div id="content-area">
                <!-- Content will be loaded here -->
            </div>
        </main>
    </div>

    <script>
        function loadContent(url) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('content-area').innerHTML = xhr.responseText;
                }
            };
            xhr.open('GET', url, true);
            xhr.send();
        }

        document.getElementById('students-link').addEventListener('click', function() {
            loadContent('students.php');
        });

        document.getElementById('modules-link').addEventListener('click', function() {
            loadContent('modules.php');
        });
    </script>
</body>
</html>
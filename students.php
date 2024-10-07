<?php
// Database connection
require_once 'config.php';

// Query to get all students
$query = "SELECT id, username, email, campus FROM users WHERE user_type = 'student'";
$result = mysqli_query($conn, $query);
?>

<h2>Students</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Campus</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['campus'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>
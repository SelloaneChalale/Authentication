<?php
include_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword = $_POST['keyword'];

    // Query the database for module names matching the keyword
    $query = "SELECT code FROM modules WHERE name LIKE '%" . $keyword . "%'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='module-suggestion'>" . $row['code'] . "</div>";
        }
    } else {
        echo "<div class='module-suggestion'>No modules found</div>";
    }
}
?>

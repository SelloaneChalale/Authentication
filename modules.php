<?php
// Database connection
require_once 'config.php';

// Query to get all modules
$query = "SELECT id, code, name, description FROM modules";
$result = mysqli_query($conn, $query);

// Handle form submission to add a new module
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $insert_query = "INSERT INTO modules (code, name, description) VALUES ('$code', '$name', '$description')";
    if (mysqli_query($conn, $insert_query)) {
        echo "New module added successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Modules</h2>
<table>
    <tr>
        <th>Code</th>
        <th>Name</th>
        <th>Description</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['code'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

<h2>Add New Module</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="code">Code:</label>
    <input type="text" id="code" name="code" required>

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea>

    <input type="submit" value="Add Module">
</form>
<?php
include_once('config.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get the list of available modules
$query = "SELECT id, code, name FROM modules";
$result = $conn->query($query);
$modules = $result->fetch_all(MYSQLI_ASSOC);

// Add the module if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['deregister_module'])) {
        $moduleId = $_POST['deregister_module'];
        $username = $_SESSION['username'];
        $userId = getUserId($username, $conn);

        // Deregister the user from the module
        $query = "DELETE FROM enrolled_modules WHERE student_id = '$userId' AND module_id = '$moduleId'";
        if ($conn->query($query) === TRUE) {
            echo "Module deregistered successfully";
        } else {
            echo "Error deregistering module: " . $conn->error;
        }
    } else {
        $moduleCode = $_POST['module_code'];
        $username = $_SESSION['username'];
        $userId = getUserId($username, $conn);

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
}

// Helper function to get the user's ID from the username
function getUserId($username, $conn)
{
    $query = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['id'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add/Deregister Module</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .status {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .status.enrolled {
            background-color: #4CAF50;
            color: #fff;
        }

        .status.not-enrolled {
            background-color: #f44336;
            color: #fff;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #333;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Add/Deregister Module</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="module_code">Module Code:</label>
        <input type="text" name="module_code" required>
        <button type="submit">Add Module</button>
    </form>

    <table>
        <tr>
            <th>Module Code</th>
            <th>Module Name</th>
            <th>Enrollment Status</th>
            <th>Action</th>
        </tr>
        <?php
        $username = $_SESSION['username'];
        $userId = getUserId($username, $conn);

        foreach ($modules as $module) {
            $moduleId = $module['id'];
            $query = "SELECT * FROM enrolled_modules WHERE student_id = '$userId' AND module_id = '$moduleId'";
            $result = $conn->query($query);
            $isEnrolled = $result->num_rows > 0;

            echo "<tr>";
            echo "<td>" . $module['code'] . "</td>";
            echo "<td>" . $module['name'] . "</td>";
            echo "<td><span class='status " . ($isEnrolled ? "enrolled" : "not-enrolled") . "'>" . ($isEnrolled ? "Enrolled" : "Not Enrolled") . "</span></td>";
            echo "<td>";
            if ($isEnrolled) {
                echo "<form id='deregister_form_".$moduleId."' method='post' action='".htmlspecialchars($_SERVER["PHP_SELF"])."'>";
                echo "<input type='hidden' name='deregister_module' value='".$moduleId."'>";
                echo "<button type='button' onclick='confirmDeregister(".$moduleId.")'>Deregister</button>";
                echo "</form>";
            }
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <a href="home.php">Back to Home</a>

    <script>
        function confirmDeregister(moduleId) {
            var confirmDeregister = confirm("Are you sure you want to deregister from this module?");
            if (confirmDeregister) {
                document.getElementById("deregister_form_" + moduleId).submit();
            }
        }
    </script>

     <!-- Include jQuery library -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#module_code').on('input', function() {
                var keyword = $(this).val();
                if (keyword.length >= 2) { // Minimum characters to trigger autocomplete
                    $.ajax({
                        url: 'fetch_modules.php',
                        method: 'POST',
                        data: {keyword: keyword},
                        success: function(response) {
                            $('#module_suggestions').html(response);
                        }
                    });
                } else {
                    $('#module_suggestions').empty();
                }
            });

            // Handle click on suggestion
            $(document).on('click', '.module-suggestion', function() {
                var moduleCode = $(this).text();
                $('#module_code').val(moduleCode);
                $('#module_suggestions').empty();
            });
        });
    </script>
</body>
</html>

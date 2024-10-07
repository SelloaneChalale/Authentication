<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'authentication';

$conn = new MySQLI($host, $user, $pass, $db_name);

require_once('config.php');
require_once('core/controller.Class.php');

if (isset($_COOKIE['id']) && isset($_COOKIE['sess'])) {
    $Controller = new Controller;
    if ($Controller->checkUserStatus($_COOKIE['id'], $_COOKIE['sess'])) {
        echo $Controller->printData(intval($_COOKIE['id']));
        $cook = $_COOKIE['id'];
    }
}

if (!isset($cook)) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Student Portal</title>
    <link rel="stylesheet" type="text/css" href="../home.css">
    <link rel="stylesheet" type="text/css" href="module.css">
</head>

<body>
    <header>
        <nav>
            <ul>
            <li><a href="#" data-target="home-section">Home</a></li>
        <li><a href="add_module.php">Modules</a></li>
        <li><a href="#" data-target="profile-section">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="home-section">
            <?php
            $sql = "SELECT * FROM users WHERE FIND_IN_SET('$cook', id)";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    $fname = $row['username'];
                    echo '<h2>Welcome, ' . $fname . ' !</h2>';
                }
            }
            ?>
            <div class="hero-section">
                <div class="hero-image-container">
                    <img src="https://i.pinimg.com/564x/df/ef/80/dfef80fe400ebed5babc80e92fe08fea.jpg" alt="Hero Image" class="hero-image">
                </div>
                <div class="hero-content">
                    <h1>Welcome, <?php echo $fname; ?>!</h1>
                    <p>Explore your campus, stay connected, and make the most of your academic journey.</p>
                    <a href="#" class="btn">Discover Events</a>
                </div>
            </div>
            <div class="info-section">
                <div class="announcement-section">
                    <h3>Announcements</h3>
                    <marquee>No new announcements at this time.</marquee>
                </div>
                <div class="news-section">
                    <h3>Campus News</h3>
                    <div class="news-container">
                        <img src="https://i.pinimg.com/564x/d3/08/05/d308053ebba3e27d338b3a21723a871d.jpg" alt="Campus News" class="news-image">
                        <p>Check out the latest news and events happening around the campus.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="profile-section" class="hidden-section">
            <h3>My Profile</h3>
            <?php
            $sql = "SELECT * FROM users WHERE FIND_IN_SET('$cook', id)";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    $fname = $row['username'];
                    $email = $row['email'];
                    $campus = $row['campus'];
                }
            ?>
                <p>Email: <?php echo $email; ?></p>
                <p>Campus: <?php echo $campus; ?></p>
            <?php
            }
            ?>
            <a href="edit_profile.php">Edit Profile</a>
        </section>
    </main>

    <footer>
        &copy; 2024 Student Portal
    </footer>

    <script src="../script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('nav ul li a');
            const sections = document.querySelectorAll('main section');

            navLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const targetId = this.getAttribute('data-target');

                    sections.forEach(section => {
                        if (section.id === targetId) {
                            section.style.display = 'block';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>

<?php

include('config.php');

   
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}



$username = $_SESSION['username'];

$query = "SELECT * FROM admins WHERE username = '$username'";
$result = $conn->query($query);
$user = $result->fetch_assoc();

$query = "SELECT m.code, m.name, m.description, em.id 
          FROM enrolled_modules em
          JOIN modules m ON em.module_id = m.id
          WHERE em.student_id = (SELECT id FROM admins WHERE username = '$username')";
$result = $conn->query($query);
$enrolledModules = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Portal</title>
    <link rel="stylesheet" type="text/css" href="home.css">
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
    <div class="hero-section">
        <div class="hero-image-container">
            <img src="https://i.pinimg.com/564x/df/ef/80/dfef80fe400ebed5babc80e92fe08fea.jpg" alt="Hero Image" class="hero-image">
        </div>
        <div class="hero-content">
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
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
    <h3>Profile</h3>
    <div class="profile-info">
        <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Campus:</strong> <?php echo $user['campus']; ?></p>
    </div>
    <button id="edit-profile-btn">Edit Profile</button>
</section>

    </main>

    <footer>
        &copy; 2024 Student Portal
    </footer>

    <script src="script.js"></script>
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

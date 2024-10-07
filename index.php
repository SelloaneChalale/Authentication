
<!DOCTYPE html>
<html>
<head>
    <title>Login/Sign Up</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="683849238219-m4d6o8ua9t07709gqgldvmvk3ghiatmp.apps.googleusercontent.com"> -->
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-toggle">
                <span id="login-toggle" class="active">Login</span>
                <span id="signup-toggle">Sign Up</span>
            </div>
            <div id="login-form" class="form">
                <h2>Login</h2>
                <form action="login.php" method="post">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Login</button>
                </form><br>
                <?php
                if (!empty($error)) {
                    echo '<p style="color:red;">' . $error . '</p>';
                }
                ?>
                <button type="button" class="submit-btn" onclick="window.location= '<?php echo $login_url ?>'">
                    Sign in with Google 
                </button><br>
                <div class="google-signin">
                    <div class="g-signin2" data-onsuccess="onSignIn"></div>
                </div>
            </div>
            <div id="signup-form" class="form">
                <h2>Sign Up</h2>
                <form action="signup.php" method="post">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="text" name="campus" placeholder="Campus" required>
                    <button type="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

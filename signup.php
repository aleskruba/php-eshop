

<?php
require_once 'includes/config.session.inc.php';
require_once 'includes/signup/signup_view.inc.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Sign UP</title>
</head>
<body>
<div class="container">
        <form class="signup-form" action="includes/signup/signup.inc.php" method="post">
            <h2>Sign Up</h2>
            <div class="form-group">
                <label for="email" class="lbl">Email</label>
                <input type="email" class="inp" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password" class="lbl">Password</label>
                <input type="password" class="inp" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password" class="lbl">Confirm Password</label>
                <input type="password" class="inp" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn">Sign Up</button>
               <p class="login-link">Already signed up? <a href="login.php">Login here</a></p>
     
        </form>
        <div class="error-message">
        <?php 
        check_signup_errors();
             ?>
      </div>
      <div class="backToEshop">
    <a href="index.php">
        BACK TO E-SHOP
        </a>
    </div>
    </div>
</body>
</html>


<?php



require_once 'includes/config.session.inc.php';
require_once 'includes/login/login_view.inc.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>
<body>
<div class="example-users">
    <div class="example-users-close">X</div>
        <div class="example-users-text">
            <p>admin@admin.cz  Heslo12345</p>
            <br>
            <p>carmen@carmen.com  Heslo12345</p>
            <p>john@john.com  Heslo12345</p>
            <p>jana@jana.cz  Heslo12345</p> 
        </div>
    </div>
<div class="container">



        <form class="login-form" action="includes/login/login.inc.php" method="post">
            <h2>Login</h2>
            <div class="form-group">
                <label for="email" class="lbl">Email</label>
                <input type="email" class="inp" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password" class="lbl">Password</label>
                <input type="password" class="inp" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
            <p class="signup-link">Not signed up? <a href="signup.php">Sign up here</a></p>

        </form>
        <div class="error-message">
        <?php 
        check_login_errors();
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


<script>
    const exampleusers = document.querySelector('.example-users')
    const exampleusersclose = document.querySelector('.example-users-close')
    const exampleuserstext = document.querySelector('.example-users-text')

    let toggle = false

    exampleusersclose.addEventListener('click', function() {
        toggle = !toggle;
            if (toggle) {
            exampleusers.style.width = '20px';
            exampleusersclose.textContent = 'O';
            exampleuserstext.style.display = 'none';	
            }
            else {
                exampleusers.style.width = '200px';
                exampleusersclose.textContent = 'X';
                exampleuserstext.style.display = 'block';	
            }

    })
    exampleusers.style.transition = 'width 0.5s ease';
</script>

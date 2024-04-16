<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    // Store the current URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit;
} else {
    $current_user_id = $_SESSION["user_id"];
    $current_user_email = $_SESSION["user_email"];
}

include 'head.php'; 
include 'navbar.php';
require_once 'includes/db.inc.php';
require_once 'includes/update/changepassword_view.inc.php';


if (isset($_SESSION["user_id"])) {
    $current_user_id = $_SESSION["user_id"];

    // Query to fetch user details based on ID
    $sql = "SELECT * FROM users WHERE id = :current_user_id";

    try {
        // Prepare and execute the query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':current_user_id', $current_user_id);
        $stmt->execute();

        // Fetch the user details
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Display user details
        if ($user) {

            echo "<form class='update-password-form' action='includes/update/updatepassword.inc.php' method='post'>";
                echo "<div class='password-main'>";
                echo "<label for='password' class='password-label'>New Password:</label>";
                echo "<input class='update-password-input' type='password' name='password'  autocomplete='new-password' >";
                echo "<label for='confirmpassword' class='password-label'>Confirm Password:</label>";
                echo "<input class='update-password-input' type='password' name='confirmpassword'   autocomplete='new-password' >";
                echo "<div class='update-button-active'>";
                    echo "<button class='update-password-button' type='submit'>Save</button>";
                    echo "<button class='update-password-back-button' id='cancelbutton' type='button'>Back</button>";
                    echo "</div>";
                echo "</div>";
            echo "</form>";

            echo "  <div class='error-message'>";
         
            check_signup_errors();
                 
                 echo "  </div>";
   
            
        } else {
            echo "User not found.";
        }
    } catch (PDOException $e) {
        die("Error: Could not execute query. " . $e->getMessage());
    }
} else {
    echo "Invalid user ID.";
}
?>


<script>

const cancelbutton = document.getElementById('cancelbutton');
    cancelbutton.addEventListener('click', () => {
    window.location.href = './profile.php'; 
});
</script>


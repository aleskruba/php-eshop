<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
} else {
    $current_user_email = $_SESSION["user_email"];
}
?>


<?php
    include 'head.php'; 
    include 'navbar.php';
    require_once 'includes/db.inc.php';
    ?>

<div class="profile">

    <div class="profile-inner">
        <a href="updateprofile.php" class="profile-inner-a" >Update Profile </a>
    </div>
    <div class="profile-inner">
        <a href="changepassword.php" class="profile-inner-a" >Change password </a>
    </div>
    <div class="profile-inner">
          <a href="yourorders.php" class="profile-inner-a" >Your Orders </a>
    </div>


</div>
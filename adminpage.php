<?php
session_start();

if (!(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1)) {
    header("Location: login.php");
    exit;
} else {
    $current_user_email = $_SESSION["user_email"];
}

    include 'head.php'; 
    include 'navbar.php';
    require_once 'includes/db.inc.php';
    ?>

    
<div class="admin-main">
    <h1>ADMIN PAGE</h1>
    
    <div class="admin-products-inner">
        <a class="admin-products" href="adminnewproduct.php">
            ADD A NEW PRODUCT
        </a>

        <a class="admin-products" href="adminlistofproducts.php">
           <p>LIST OF PRODUCTS</p>
           <p>&</p>
           <p>UPDATE PRODUCTS</p>
             
        </a>
    </div>
</div>


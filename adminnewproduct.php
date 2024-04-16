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
    require_once 'includes/products/product_view.inc.php';
    ?>

<div class="admin-newproduct-main">
    <h1 class="admin-newproduct-title">
      Add a new Product
    </h1>

    <form action="includes/products/product.inc.php" method="post" class="admin-form-newproduct">
        <div>
    <input type="text" placeholder="model" class="admin-product-model" name='model'/>
    <textarea placeholder="description" class="admin-product-description" rows="10" name='description'></textarea>
    <input type="number" placeholder="price" class="admin-product-price" name='price'>
    <input type="number" placeholder="stock" class="admin-product-stock" name='stock'>
    <input type="text" placeholder="image" class="admin-product-image" name='image'>
        </div>
        <div class="admin-buttons">
        
            <button type="submit" class="admin-submit-button">save</button>
            <button type='button' class="admin-back-button" id="cancelbutton">back</button>
       </div>
    </form>
    <div class="error-message" id='errormessage'>
        <?php 
        check_product_errors();
      ?>
      </div>


</div>

<script>
    const cancelbutton = document.getElementById('cancelbutton');
          cancelbutton.addEventListener('click', () => {
        window.location.href = './adminpage.php'; 
    });
</script>
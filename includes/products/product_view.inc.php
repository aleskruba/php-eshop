<?php
    
    function  check_product_errors() {
    if (isset($_SESSION['errors_product'])) {

         $errors = $_SESSION['errors_product'];

        echo "<br>";

        foreach ($errors as $error) {
            echo '<p class="form-error">'. $error.' </p>';
        }

        unset($_SESSION['errors_product']);
    }

    else if (isset($_GET['product']) && $_GET['product'] === 'success') {
        echo "<br>";
        echo '<p class="form-success">Product saved successfuly </p>';
        
    }
}
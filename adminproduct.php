
<?php
session_start();
include 'head.php'; 
include 'navbar.php';
require_once 'includes/db.inc.php';

if (!(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1)) {
    header("Location: login.php");
    exit;
} else {
    $current_user_email = $_SESSION["user_email"];
}
    ?>

    

<?php

// Retrieve the product ID from the URL parameter
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $productId = $_GET['id'];

    // Query to fetch product details based on ID
    $sql = "SELECT * FROM products WHERE id = :id";

    try {
        // Prepare and execute the query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $productId);
        $stmt->execute();

        // Fetch the product details
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Display product details
        if ($product) {
            echo "<div class='product-main'>";

            echo "<div class='product-main-back-button'>";
            echo "<button class='admin-cancel-button' id='admin-cancel-button'>Back</button>";
            echo "</div>";

            echo "<div class='product-detail'>";
           
            if (strlen($product['img']) > 0) {
                echo "<div class='imgDiv'>";
                echo "<img src='" . $product['img'] . "' alt='" . $product['model'] . "' class='img'>";
                echo "</div>";
            }
            
                echo "<h3>" . $product['model'] . "</h3>";
                echo "<p class='description'>" . $product['description'] . "</p>";
                echo "<p class='price'>$" . $product['price'] . "</p>";
                echo "<p class='stock'>In Stock: " . $product['stock'] . "</p>";

                echo "<div class='admin-product-buttons'>";
                echo "<button type='button' class='admin-update-button' onclick='toggleFunction()'>Update</button>";
                if ($product['stock'] > 0) {
                    echo "<button class='admin-delete-button-disabled' disabled'>Delete</button>";
                } else {
                    echo "<form action='includes/products/product_delete.inc.php?id=" . $product['id'] . "' method='post'>";
                    echo "<button type='submit' class='admin-delete-button' }>Delete</button>";
                    echo "</form>";
                }
                        
                echo "</div>";
        
           
            echo "</div>";
            
            echo "<div class='product-detail-update'>";
            echo "<form action='includes/products/product_update.inc.php?id=" . $product['id'] . "' method='post'>";
                    echo "<div class='form-group'>";
                        echo "<div class='label'>Model:</div>";
                        echo "<input type='text' name='model' value=\"" . $product['model'] . "\" class='admin-model-input'/>";
                    echo "</div>";
                    
                    echo "<div class='form-group'>";
                        echo "<div class='label'>Description:</div>";
                        echo "<textarea name='description' class='admin-description-input' rows='8'>" . $product['description'] . "</textarea>";

                    echo "</div>";
                    
                    echo "<div class='form-group'>";
                        echo "<div class='label'>Stock:</div>";
                        echo "<input type='number' name='stock' value=\"" . $product['stock'] . "\" class='admin-stock-input'/>";
                    echo "</div>";
                    
                    echo "<div class='form-group'>";
                        echo "<div class='label'>Price:</div>";
                        echo "<input type='number' name='price' value=\"" . $product['price'] . "\" class='admin-price-input'/>";
                    echo "</div>";
                    
                    echo "<div class='form-group'>";
                        echo "<div class='label'>Image:</div>";
                        echo "<input type='text' name='image' value=\"" . $product['img'] . "\" class='admin-image-input'/>";
                    echo "</div>";


                  echo "<div class='admin-product-buttons'>";
                        echo "<button type='submit' class='admin-update-button' >Save</button>";
                        echo "<button type='button' class='admin-cancel-button' onclick='toggleFunction()'>Cancel</button>";
                 echo "</div>";
            
             echo "</form>";
             echo "</div>";


            echo "</div>";

      
                echo "<div class='delete-product-info'>"; 
                    if ($product['stock'] > 0) echo "<span> Stock must be 0 in order to delete the product </span>";   
                echo "</div>";
        } else {
            echo "Product not found.";
        }
    } catch (PDOException $e) {
        die("Error: Could not execute query. " . $e->getMessage());
    }
} else {
    echo "Invalid product ID.";
}

// Close the database connection
unset($pdo);
?>





   <script>
    let update = false;

    const toggleFunction = () => {
        update = !update;
        // Toggle visibility of product details based on the value of the update variable
        const productDetail = document.querySelector('.product-detail');
        const productDetailUpdate = document.querySelector('.product-detail-update');


        if (update) {
            productDetail.style.display = 'none';
            productDetailUpdate.style.display = 'block';
               
        } else {
            productDetail.style.display = 'block';
            productDetailUpdate.style.display = 'none';

        }
    };


    document.getElementById('admin-cancel-button').addEventListener('click', function() {
        window.history.back();
    });
    </script>  





<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
 else {
    $current_user_email = $_SESSION["user_email"];
}

    include 'head.php'; 
    include 'navbar.php';
    require_once 'includes/db.inc.php';
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
          
            echo "<button class='product-main-button' id='product-main-button'>Go back</button>";
          
            echo "<div class='product-detail'>";
            echo "<div class='imgDiv'>";
            echo "<img src='" . $product['img'] . "' alt='" . $product['model'] . "' class='img'>";
            echo "</div>";
            echo "<h3>" . $product['model'] . "</h3>";
            echo "<p class='description'>" . $product['description'] . "</p>";
            echo "<p class='price'>$" . $product['price'] . "</p>";
            echo "<p class='stock'>In Stock: " . $product['stock'] . "</p>";
            echo "<div class='add-to-cart'>";
            echo "<button class='minus-button' onclick='removeFromCart(" . $product['id'] . ")'>-</button>";
            echo "<span class='item-quantity' id='itemquantity'></span>";
           // echo "<button class='plus-button' onclick='addToCart(" . $product['id'] . ", " . $product['stock'] . ", " . $product['price'] . ", " . $product['model'] . ")'>+</button>";
           echo "<button class='plus-button' onclick='addToCart(" . $product['id'] . ", " . $product['stock'] . ", " . $product['price'] . ", \"" . $product['model'] . "\", \"" . htmlspecialchars(addslashes($product['description'])) . "\", \"" . htmlspecialchars(addslashes($product['img'])) . "\")'>+</button>";

            echo "</div>";
            echo "</div>";
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

<div class="reviews-main">
<?php
   include 'message.php'; 
  include 'messages.php'; 
?>

</div>

<script>

const stock = <?php echo $product['stock'] ?>;
console.log('stock',stock)

let minusButton = document.querySelector('.minus-button');
let plusButton = document.querySelector('.plus-button');


if (itemquantity.value === undefined) { itemquantity.textContent = 0 };

console.log('itemquantity.value',itemquantity.value)
function getCartProduct() {
    return JSON.parse(localStorage.getItem('cart')) || [];
}
var cartProduct = getCartProduct();

const urlParamsProduct = new URLSearchParams(window.location.search);
const productIdProduct = urlParamsProduct.get('id');


cartProduct.forEach( item=> {

    console.log('test', parseInt(stock) === item.quantity)

    console.log(item)
    if( (item.productID === parseInt(productIdProduct) ) && item.quantity < 1  ) {

        minusButton.style.opacity = '0.5';
        minusButton.style.pointerEvents = 'none';   
    }
    if ( (item.productID === parseInt(productIdProduct) && item.quantity >= parseInt(item.stock))) { 
        plusButton.style.opacity = '0.5';
        plusButton.style.pointerEvents = 'none';  
    }
  /*   if( parseInt(stock) < 1 || parseInt(stock) === item.quantity ) {

        plusButton.style.opacity = '0.5';
        plusButton.style.pointerEvents = 'none';   
        } */

})


    document.getElementById('product-main-button').addEventListener('click', function() {
        window.history.back();
    });

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {




    

})






   
    </script>  


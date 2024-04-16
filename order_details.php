<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // Store the current URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit;
}else {

    $current_user_id = $_SESSION["user_id"];
    $current_user_email = $_SESSION["user_email"];
}

// Include necessary files
include 'head.php'; 
include 'navbar.php';
require_once 'includes/db.inc.php';

// Check if order ID is provided in the URL
if (isset($_GET['orderid'])) {
    $order_id = $_GET['orderid'];
    
    // Sanitize the input to prevent SQL injection
    $order_id = filter_var($order_id, FILTER_SANITIZE_NUMBER_INT);

    // Prepare and execute SQL query using prepared statements
    $stmt = $pdo->prepare("SELECT orders.*, order_items.*, products.* ,  order_items.price AS original_price
                           FROM orders 
                           INNER JOIN order_items ON orders.id = order_items.order_id 
                           INNER JOIN products ON order_items.product_id = products.id
                           WHERE orders.user_id = :user_id AND orders.id = :orderid");
    $stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
    $stmt->bindParam(':orderid', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch the order details
    $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($orderDetails) {
        // Store order details
        $firstDetail = reset($orderDetails);
        $order_id = $firstDetail['id'];
        $created_at = $firstDetail['created_at'];
        $total_price = $firstDetail['total_price'];

        $date = new DateTime($created_at );
        $formatted_date = $date->format('j.n.Y H:i');
        
        // Output order details outside the loop
 
        // Output order items inside the loop
        echo "<div class='user-main'>";
        foreach ($orderDetails as $detail) {
       
            echo "<div class='order-item-details'>";
            echo "<div class='order-item-name'>Item: {$detail['model']}</div>";
            echo "<div class='order-item-price'>Price: {$detail['original_price']}</div>";
            echo "<div class='order-item-quantity'>Quantity: {$detail['quantity']}</div>";
            echo "</div>";
   
        }
    
  
        echo "<div class='order-details-main'>";
        echo "<div class='order-created-at'>Created At: $formatted_date</div>";
        echo "<div class='order-total-price'>Total Price: $total_price</div>";
        echo "</div>";
        echo "<button class='user-back-button' id='cancelbutton'> back</button>";
        echo "</div>";
    } else {
        // Handle case when order is not found
        echo "Order not found.";
    }
} else {
    // Handle case when order ID is not provided
    echo "Order ID not provided.";
}
?>

<script>

document.getElementById("cancelbutton").addEventListener("click", function() {
 
    window.history.back();
});
</script>
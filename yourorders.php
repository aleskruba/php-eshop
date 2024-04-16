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

    // Prepare and execute SQL query using prepared statements
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $current_user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch all orders for the current user
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>

<div class='orderscontainer'>
<h1>Your orders</h1>
<?php
// Define the number of orders per page
$ordersPerPage = 2;

// Determine the current page
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset
$offset = ($current_page - 1) * $ordersPerPage;

// Slice the array of orders based on the offset and number of orders per page
$paginatedOrders = array_slice($orders, $offset, $ordersPerPage);


if ($paginatedOrders) {
    echo "<div class='user-main'>";
    
    foreach ($paginatedOrders as $order) {
        $date = new DateTime($order['created_at']);
        $formatted_date = $date->format('j.n.Y H:i');
       
        echo "<div class='order-item'>";

        echo "<a class='order-link' href='order_details.php?orderid={$order['id']}'>";
        echo "<div class='order-details'>";
        echo "<div class='order-id'>Order: {$order['id']}</div>";
        echo "<div class='order-created-at'>Created At: {$formatted_date}</div>";
        echo "<div class='order-total-price'>Total Price: {$order['total_price']}</div>";
        echo "</div>";
        echo "</a>";
        
        echo "</div>";
    }
    echo "</div>";

    // Pagination controls
    echo "<div class='pagination'>";
    $totalPages = ceil(count($orders) / $ordersPerPage);
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a href='?page=$i'>$i</a>";
    }
    echo "</div>";
    echo "<button class='user-back-button' id='cancelbutton'> back</button>";
}
?>

</div>


<script>

document.getElementById("cancelbutton").addEventListener("click", function() {
 
    window.history.back();
});
</script>

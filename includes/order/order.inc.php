<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once './db.inc.php';

    $json_data = file_get_contents("php://input");
    echo json_encode($json_data);
    if ($json_data !== false) {
        $cart = json_decode($json_data, true);

        if ($cart !== null) {
           $userId = $_SESSION['user_id'];

            try {
                $pdo->beginTransaction();
                $totalPrice = 0;
                foreach ($cart['cart'] as $item) {
                    $totalPrice += $item['quantity'] * $item['price'];
                }

                $query = "INSERT INTO orders (user_id, total_price) VALUES (:userId, :totalPrice)";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(':userId' => $userId, ':totalPrice' => $totalPrice));

                $orderId = $pdo->lastInsertId();

                foreach ($cart['cart'] as $item) {
                    $productId = $item['productID'];
                    $quantity = $item['quantity'];
                    $price = $item['price'];

                    $query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:orderId, :productId, :quantity, :price)";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute(array(':orderId' => $orderId, ':productId' => $productId, ':quantity' => $quantity, ':price' => $price));
               
                     // Update product stock
                     $query = "UPDATE products SET stock = stock - :quantity WHERE id = :productId";
                     $stmt = $pdo->prepare($query);
                     $stmt->execute(array(':quantity' => $quantity, ':productId' => $productId));
             
                }

                $pdo->commit();

              


            } catch (PDOException $e) {
                $pdo->rollBack();
                echo "An error occurred: " . $e->getMessage();
            }
        } else {
            echo "Failed to decode JSON data.";
        }
    } else {

        echo "No JSON data received.";
    }
} else {

}
?>

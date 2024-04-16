<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../db.inc.php'; // Adjust the path to db.inc.php as needed

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Handle the case when user is not logged in
        echo "You must be logged in to submit a message.";
        exit;
    }

    // Get user ID from session
    $userId = $_SESSION['user_id'];

    // Check if the product ID is provided in the URL
    if (isset($_GET['id'])) {
        $productId = $_GET['id'];

        // Retrieve the opinion from the form
        $opinion = $_POST['opinion'];

        try {
            // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO messages (message, created_at, updated_at, users_id, product_id) VALUES (:message, NOW(), NOW(), :users_id, :product_id)");

            // Bind parameters
            $stmt->bindParam(':message', $opinion);
            $stmt->bindParam(':users_id', $userId);
            $stmt->bindParam(':product_id', $productId);

            // Execute the statement
            $stmt->execute();

            // Redirect back to the product page after submission
            header("Location: ../../product.php?id=$productId#message");

            exit;
        } catch(PDOException $e) {
            // Handle database error
            echo "An error occurred while inserting the message: " . $e->getMessage();
        }
    } else {
        // Handle the case when product ID is not provided in the URL
        echo "Product ID is missing in the URL.";
    }
} else {
    // Handle the case when the form is not submitted via POST method
    echo "Invalid request method.";
}
?>

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
    if (isset($_GET['id']) || $_GET['id'] == isset($_GET['messageid']))  {
        $productId = $_GET['id'];
        $opinion = $_POST['reply_message'];
        $messageId=  $_GET['messageid'];

        try {
            // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO replies (reply_text, created_at, users_id, message_id) VALUES (:message, NOW(),  :users_id, :message_id)");

            // Bind parameters
            $stmt->bindParam(':message', $opinion);
            $stmt->bindParam(':users_id', $userId);
            $stmt->bindParam(':message_id', $messageId);

            // Execute the statement
            $stmt->execute();

            // Redirect back to the product page after submission
            header("Location: ../../product.php?id=$productId#reply$messageId");

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

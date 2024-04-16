<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../db.inc.php';

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../login.php");
        exit;
    }

    // Check if message ID is provided
    if (isset($_GET['id']) && isset($_GET['productid'])) {
        $messageId = $_GET['id'];
        $productId = $_GET['productid'];
       
        try {
            // Prepare and execute the DELETE query
            $stmt = $pdo->prepare("DELETE FROM messages WHERE id = :messageId");
            $stmt->bindParam(':messageId', $messageId);
            $stmt->execute();

            // Redirect to the product page after successful deletion
            header("Location: ../../product.php?id=$productId");
            exit;
        } catch(PDOException $e) {
            // Handle errors
            echo "An error occurred while deleting the message: " . $e->getMessage();
        }
    } else {
        // Handle missing message ID
        echo "Message ID is missing in the URL.";
    }
} else {
    // Handle invalid request method
    echo "Invalid request method.";
}
?>

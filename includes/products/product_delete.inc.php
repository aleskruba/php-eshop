<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1)) {
    header("Location: login.php");
    exit;
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once '../db.inc.php'; 

    if (isset($_GET['id']) ) {
        $productId = $_GET['id'];
    
       
        try {
            // Prepare and execute the DELETE query
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = :productId");
            $stmt->bindParam(':productId', $productId);
            $stmt->execute();

            // Redirect to the product page after successful deletion
            header("Location: ../../adminlistofproducts.php");
            exit;
        } catch(PDOException $e) {
            // Handle errors
            echo "An error occurred while deleting the product: " . $e->getMessage();
        }
    } else {
        // Handle missing message ID
        echo "Product ID is missing in the URL.";
    }
} else {
    // Handle invalid request method
    echo "Invalid request method.";
}
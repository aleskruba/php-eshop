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

        $model = $_POST["model"];
        $description = $_POST["description"];
        $stock = $_POST["stock"];
        $price = $_POST["price"];
        $image = $_POST["image"];
    
       
        try {
            // Prepare and execute the DELETE query
            $query = "UPDATE products  
                        SET model = :model, description = :description, stock = :stock, price = :price, img = :image
                        WHERE id = :productId";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':productId', $productId);
            $stmt->bindParam(":model", $model);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":stock", $stock);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":image", $image);
            $stmt->execute();

            $pdo = null;
            $stmt = null;


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
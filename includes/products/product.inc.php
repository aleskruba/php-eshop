<?php

require_once '../db.inc.php';
require_once 'product_model.inc.php';
require_once 'product_contr.inc.php';

$productController = new ProductController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model = $_POST["model"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $image = $_POST["image"];

    try {
        $errors = [];

        if (is_input_empty($model, $description, $price, $stock, $image)) {
            $errors["empty_input"] = "Fill in all fields!"; 
        }

        if ($errors) {
            session_start();
            $_SESSION["errors_product"] = $errors;
            header("Location: ../../adminnewproduct.php#errormessage");
            die();
        }

        $productController->create_product($model, $description, $price, $stock, $image);
        header("Location: ../../index.php?product=success");
        exit();


    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
} else {
    header("Location: ../../adminnewproduct.php");
    exit();
}

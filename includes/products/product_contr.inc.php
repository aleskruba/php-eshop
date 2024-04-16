<?php
    
declare(strict_types=1);

require_once 'product_model.inc.php'; // Include the file containing set_product()

class ProductController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create_product($model, $description, $price, $stock, $image) {
        set_product($this->pdo, $model, $description, $price, $stock, $image);
    }
}

function is_input_empty(string $model, string $description, string $price, string $stock, string $image) {
    if (empty($model) || empty($description) || empty($price) || empty($stock) || empty($image)) {
        return true; 
    } else {
        return false;
    }
}



/* 
function is_input_empty(string $model, string $description, string $price, string $stock, string $image) {
    if (empty($model) || empty($description) || empty($price) || empty($stock) || empty($image)) {
        return true; 
    } else {
        return false;
    }
}



function  create_product(object $pdo , string $model, string $description,string $price, string $stock, string $image ) {
   
    set_product($pdo,$model,$description,$price,$stock,$image);
   } */
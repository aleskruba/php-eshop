<?php
    
declare(strict_types=1);




function set_product(object $pdo, string $model, string $description, string $price,string $stock, string $image){
    $query = "INSERT INTO products (model,description,price,stock,img) VALUES ( :model, :description,:price,:stock,:image)";
    $stmt = $pdo->prepare( $query);
   
   
    $stmt -> bindParam(':model',$model);
    $stmt -> bindParam(':description',$description);
    $stmt -> bindParam(':price',$price);
    $stmt -> bindParam(':stock',$stock);
    $stmt -> bindParam(':image',$image);
    $stmt ->execute(); 
}

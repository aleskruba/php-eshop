<?php
   // $host = 'localhost';
   // $dbname = 'myproject';
   // $dbusername = 'root';
   // $dbpassword = '';





    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname",
                    $dbusername,
                    $dbpassword);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }catch(PDOException $e){
        die('An error occurred'.$e->getMessage());
    }

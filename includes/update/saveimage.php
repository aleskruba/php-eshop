<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../db.inc.php';
    $response = $data['data'];

    if ($response !== false) {

        if ($response !== null) {
              $current_user_id = $_SESSION['user_id']; 
       
             try {
                $pdo->beginTransaction();

                $stmt = $pdo->prepare("UPDATE users SET image = :image_data WHERE id = :user_id");
                $stmt->bindParam(':image_data', $response);
                $stmt->bindParam(':user_id', $current_user_id);
                $stmt->execute(); 

                $pdo->commit();
                
           
                header('Content-Type: application/json');
                echo json_encode($current_user_id);
            } catch (PDOException $e) {
                $pdo->rollBack();
      
                echo json_encode(array('success' => false, 'message' => 'An error occurred: ' . $e->getMessage()));
            } 
        } else {
          
          echo json_encode(array('success' => false, 'message' => 'Failed to decode JSON data or missing "secure_url".'));
        }
    } else {
       
        echo json_encode(array('success' => false, 'message' => 'No JSON data received.'));
    }
}


?>

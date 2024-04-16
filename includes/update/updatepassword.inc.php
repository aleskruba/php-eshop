<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../../login.php");
    exit;
}

require_once '../db.inc.php';
require_once 'change_pass_contr.inc.php';

$current_user_id = $_SESSION["user_id"];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the form
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];

    $errors = [];

    if (is_input_empty($password, $confirmpassword)) {
        $errors["empty_input"] = "Fill in all fields!";
    }

    if (passwords_do_not_match($password, $confirmpassword)) {
        $errors["password_mismatch"] = "Passwords do not match!";
    }

    if ($errors) {
        $_SESSION["errors_signup"] = $errors;
        header("Location: ../../changepassword.php");
        exit();
    }

    try {
        $query = "UPDATE users  
                  SET password = :password
                  WHERE id = :current_user_id";

        $stmt = $pdo->prepare($query);

        $options = [
            'cost' => 12
        ];

        $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':current_user_id', $current_user_id);
        $stmt->execute();

        header("Location: ../../profile.php");
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Redirect the user to the homepage or any other appropriate page
    header("Location: ../../index.php");
    exit();
}
?>

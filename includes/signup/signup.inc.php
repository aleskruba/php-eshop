<?php
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    try {

        require_once '../db.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';

        $errors = [];

     
        if (is_input_empty($email, $password, $confirm_password)) {
            $errors["empty_input"] = "Fill in all fields!"; 
        }
        if (is_email_valid($email)) {
            $errors["invalid_email"] = "Invalid email!"; 
        }
 
        if (is_email_registered($pdo,$email)) {
            $errors["email_taken"] = "Email already exists!"; 
        }
        if (passwords_do_not_match($password,$confirm_password)) {
            $errors["password_mismatch"] = "Passwords do not match!";
        }

        require_once '../config.session.inc.php';

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
          
            $signupData = [
                "email" => $email,
                
            ];

            $_SESSION["signup_data"] = $signupData;
          
          
            header("Location: ../../signup.php");
            die();


        }

        create_user($pdo,$email,$password);
        header("Location: ../../index.php?signup=success");
        $pdo = null;
        $stmt = null;
        die();

    } catch (PDOException $e) {
          die('Connection failed: ' . $e->getMessage());
    }

}
else{
    header("Location: ../index.php");
    die();
}
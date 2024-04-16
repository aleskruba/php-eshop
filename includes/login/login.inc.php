<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        require_once '../db.inc.php';
        require_once 'login_contr.inc.php';
        require_once 'login_model.inc.php';

   

        $errors = [];
  
        if (is_input_empty($email, $password)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        $result = get_user($pdo, $email);

        if (is_email_wrong($result)) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }

        if (!is_email_wrong($result) && is_password_wrong($password, $result["password"])) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }

        if ($errors) {
            session_start(); // Start the session before setting session variables

            $_SESSION["errors_login"] = $errors;

            // Store the current URL in a session variable
            $_SESSION['redirect_url'] = "../../basket.php";

            header("Location: ../../login.php?login=error");
            die();
        }

        require_once '../config.session.inc.php';

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result['id'];
        session_id($sessionId);
        session_start();

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_email"] = htmlspecialchars($result["email"]);
        $_SESSION["admin"] = $result["is_admin"];

        $_SESSION["last_regeneration"] = time();

        // Check if there's a stored URL
        if (isset($_SESSION['redirect_url'])) {
            // Redirect the user back to the stored URL
            header("Location: " . $_SESSION['redirect_url'] . "?login=success");
            unset($_SESSION['redirect_url']); // Remove stored URL after redirection
            die();
        } else {
            // If there's no stored URL, redirect the user to index.php or any default page
            header("Location: ../../index.php?login=success");
            die();
        }

    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
} else {
    header("Location: ../../index.php");
    die();
}
?>

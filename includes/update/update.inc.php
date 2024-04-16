<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect the user to the login page or handle unauthorized access
    header("Location: ../../login.php");
    exit; // Ensure that script execution stops after redirection
}

// Get the current user ID and email
$current_user_id = $_SESSION["user_id"];
$current_user_email = $_SESSION["user_email"];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the form
    $f_name = $_POST["f_name"];
    $l_name = $_POST["l_name"];
    $email = $_POST["email"];
    $country = $_POST["country"];

    try {
        // Include the database connection file
        require_once '../db.inc.php';

        // Prepare the SQL query
        $query = "UPDATE users  
                  SET f_name = :f_name, l_name = :l_name, country = :country, email = :email
                  WHERE id = :current_user_id";

        // Prepare and execute the query
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":f_name", $f_name);
        $stmt->bindParam(":l_name", $l_name);
        $stmt->bindParam(":country", $country);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":current_user_id", $current_user_id);
        $stmt->execute();

        // Check if the email has changed
        if ($email != $current_user_email) {
            // Destroy the current session, logging the user out
            session_destroy();
            // Redirect the user to the login page
            header("Location: ../../login.php");
            exit; // Ensure that script execution stops after redirection
        }

        // Close the database connection
        $pdo = null;
        $stmt = null;

        // Redirect the user to the homepage or any other appropriate page
        header("Location: ../../updateprofile.php");
        exit; // Ensure that script execution stops after redirection
    } catch (PDOException $e) {
        // Handle database errors
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Redirect the user to the homepage or any other appropriate page
    header("Location: ../../index.php");
    exit; // Ensure that script execution stops after redirection
}

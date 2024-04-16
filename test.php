<?php
session_start();

echo "<h1>test</h1>";

if (isset($_SESSION['test_user'])) {
    echo "session user".$_SESSION["test_user"];
} else {
    echo 'Session variable is not set.';
}

if(isset($_SESSION['test_variable'])) {
    echo 'Session variable value: ' . $_SESSION['test_variable'];
} else {
    echo 'Session variable is not set.';
}


    if (isset($_GET['id'])) {
        echo $_GET['id'];
    } else {
        echo "no id params";
    }
    if (isset($_GET['country'])) {
        echo $_GET['country'];
    } else {
        echo "no country params ";
    }


$error = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($_POST['username'] && !empty($_POST['username'])){
        
        if ($_POST['username'] !== "ales" ) {
            $error = ""; 
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['expiration'] = time() + 5;
            header("Location: test.php"); 
           }
        else  {
            $error =  "username already exists";
        }

} else {
    $error =  "input cannot be blank";
  }
}       
  
echo "This line won't be reached if the redirection happens.";

if (isset($_SESSION['name']) && isset($_SESSION['expiration']) && $_SESSION['expiration'] > time()) {

            echo  "WELCOME".$_SESSION['name'];
  
        }
        else {
            unset($_SESSION['name']);
            unset($_SESSION['expiration']);
            session_destroy();
            echo  "YOU ARE LOGGED OUT";
        }
    


?>



<form action="test.php" method="post">
    <input type="text" placeholder="username" name="username">
    <input type='submit' value='save' />
    <?php
        if ($error) {echo $error;}
    ?>
</form>
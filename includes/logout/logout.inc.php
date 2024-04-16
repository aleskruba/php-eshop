<?php
    
session_start();
session_unset();
session_destroy();

$_SESSION['redirect_url'] = null;

 header("Location: ../../index.php");
die();
<?php

require_once 'constants.php';

session_start();


if (isset($_SESSION["user_id"])) {
    $current_user_email = $_SESSION["user_email"];
    $_SESSION['redirect_url'] = null;
} 

?>

<!DOCTYPE html>
<html lang="en">


<?php include 'head.php';



?>



<body>

<?php
        // Include the products.php file
        include 'navbar.php';


        ?>
 </div>



  <div class="productssoffer">  
    <?php
        // Include the products.php file
        include 'products.php';
        ?>
 </div>



 <footer class="footer">
    <?php foreach ($footerLinks as $title => $links): ?>
        <div class="footer-column">
            <h4 ><?php echo $title; ?></h4>
            <ul class="footer-ul">
                <?php foreach ($links as $linkTitle => $url): ?>
                    <li class="footer-li"><a href="<?php echo $url; ?>"><?php echo $linkTitle; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</footer>


</body>
</html>



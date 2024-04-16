<nav class="nav" id="nav">
    <div class="nav-left">
        <div class="nav-left-flex"> 
             <div>
                <a href="index.php"><img src="logo.png" alt="Comments" height="30"></a>
             </div>
              <div>
                <h1 class="welcome">
                    <?php  
                    if (isset($_SESSION["user_id"]) && !(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) ) {
                        echo  $current_user_email;
                    }
                    ?>
              </h1>
             </div>

            
          
         
                  <?php  
                  if (isset($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
                         echo "<a href='adminpage.php' class='manageproducts'>";
                         echo  "MANAGE PRODUCTS";
                         echo " </a> ";
              }  ?>
             
       
         

             <div class="nav-right-icon">
 
             <div class="nav-right-icon-basket">
                    <a href="basket.php"><i class="fa fa-shopping-basket" style="font-size:24px;"></i></a>

                     <div class="basketCounter" id="cartQuantity"> </div>
             </div>
       </div>
        </div>

  


        <div class="burger-div" id="burger-div">
            <div class="burger"></div>
            <div class="burger"></div>
            <div class="burger"></div>
        </div>

    </div>


  
    <div class="nav-right" id="nav-right">
        


     <?php
  
        if (!isset($_SESSION["user_id"])) {
          echo '<div class="nav-right-icon"><a href="login.php">Login</a></div>';
          echo '<div class="nav-right-icon"><a href="signup.php">Sign Up</a></div>';
        } else {
            echo '<div class="nav-right-icon" id="imgprofilediv">
                    <a href="profile.php">
                      <img src="avatar.png" alt="" class="progileimage">
                     </a>
                  </div>';
            echo '
            <div class="nav-right-icon" >
            <form action="includes/logout/logout.inc.php" method="post">
                <button type="submit" class="nav-right-icon" id="logout">Logout</button>
           </form>
           </div>
            ';
        }
      ?>
    </div>
  </nav>
  <div class="success" id="successMessage"></div>

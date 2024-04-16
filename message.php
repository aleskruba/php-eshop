<?php
  

?>
<div class="review">
    <h2 class="review-title">reviews</h2>  
    <form class="message-form" action="includes/messages/message.inc.php?id=<?php echo $_GET['id']; ?>" method="POST">
        <input class="message-form-input-text" type="text" name="opinion" placeholder="your opinion">
        <input class="message-form-input-submit " type="submit" value="send">
    </form>
</div>

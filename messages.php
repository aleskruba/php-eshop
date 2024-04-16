<?php
require 'includes/db.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
} else {
    $current_user_id = $_SESSION["user_id"];
}
$productID = isset($_GET['id']) ? $_GET['id'] : '';

$stmt = $pdo->prepare("SELECT 
                    messages.*, 
                    users.f_name, 
                    users.id AS userID, 
                    users.image AS userImage  
                    FROM 
                    messages 
                    JOIN 
                    users ON messages.users_id = users.id  
                    WHERE 
                    messages.product_id = $productID;
                    ");
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class='messagescontainer'>

<?php



$messagePerPage = 20;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $messagePerPage;
$paginateMessages = array_slice($messages, $offset, $messagePerPage);


// Define a custom comparison function to sort messages by date
function sortByDateDescending($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
}

// Sort the messages array using the custom comparison function
usort($paginateMessages, 'sortByDateDescending');

// Now $paginateMessages is sorted by date in descending order



if ($paginateMessages) {
    echo "<div class='messages-main' id='message'>";
    
    foreach ($paginateMessages as $message) {
        $date = new DateTime($message['created_at']);
        $formatted_date = $date->format('j.n.Y H:i');
       
        $stmtReplies = $pdo->prepare("SELECT replies.*, users.id AS userID, users.f_name, users.image  AS userImage 
                                        FROM replies 
                                        JOIN users ON replies.users_id = users.id 
                                        WHERE message_id = :messageId
                                        ");
        $stmtReplies->bindParam(':messageId', $message['id']);
        $stmtReplies->execute();
        $replies = $stmtReplies->fetchAll(PDO::FETCH_ASSOC);
  

    echo "<div class='message-item'>";


        echo "<div class='message-details'>";
        
          echo "<div class='message-details-inner'>";
  
                echo "<div class='message-user'> <span class='message-created-at'>{$formatted_date}</span> <div class='message-image'><img src={$message['userImage']} class='message-image-img'/></div>";
                echo "<div class=''><b>{$message['f_name']}</b></div></div>";
                echo "<div class='message-message'>{$message['message']}</div>";
            echo "</div>";
            if (($current_user_id == $message['userID']) || $_SESSION["admin"] == 1) {
           
                echo "<form class='delete-message-form' action='includes/messages/delete.inc.php?productid={$productID}&id={$message['id']}' method='POST' onsubmit='return confirmDelete()'>";
                    echo "<button type='submit' class='message-delete-button'>delete</button>";
                echo "</form>";
     
                
            } else {
                if ($current_user_id != $message['userID']) {
                echo "<button class='message-reply-button' id='replyButton' onClick='toggleReplyForm(\"replyForm{$message['id']}\")'>reply</button>";
 
       
            echo "<form class='reply-form' id='replyForm{$message['id']}' action='includes/messages/reply.inc.php?id={$productID}&messageid={$message['id']}' method='POST' style='display: none;'>";
                echo "<input type='text' class='reply-form-input' name='reply_message' placeholder='Reply'>";
                  echo "<div class='reply-buttons'>";
                    echo "<button type='submit' class='reply-send-button'>send</button>";
                    echo "<button type='button' class='reply-cancel-button' onClick='toggleReplyForm(\"replyForm{$message['id']}\")'>cancel</button>";
                  echo "</div>";
            echo "</form>";}
       

        }
  
        foreach ($replies as $reply ){
            $date_reply = new DateTime($reply['created_at']);
            $formatted_date_reply = $date_reply->format('j.n.Y H:i');
            echo "<div class='reply-div' id='messages{$reply['id']}'>";

                echo "<div class='reply-user'><span class='message-created-at'>{$formatted_date_reply}</span><div class='message-image'><img src={$reply['userImage']} class='message-image-img'/></div><div >  <b>   {$reply['f_name']}</b></div> </div>";
                echo "<div class='reply'>{$reply['reply_text']}</div>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";

    }
    echo "</div>";

    // Pagination controls
    echo "<div class='pagination'>";
    $totalPages = ceil(count($messages) / $messagePerPage);
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i > 1 || $totalPages > 1) {
            echo "<a href='?id=$productID&page=$i'>$i</a>";
        }
    }
    echo "</div>";
}

?>

<script>
    function toggleReplyForm(formId) {
        const form = document.getElementById(formId);
        form.style.display = form.style.display === 'none' ? 'flex' : 'none';
        const replyButton = document.getElementById('replyButton');

        if (replyButton.style.opacity === '0') {
            replyButton.style.opacity = '1';
            replyButton.style.cursor = 'pointer';
            replyButton.style.pointerEvents = 'auto'; // Enable pointer events
        } else {
            replyButton.style.opacity = '0';
            replyButton.style.cursor = 'not-allowed';
            replyButton.style.pointerEvents = 'none'; // Disable pointer events
        }

    }
</script>

<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this message?");
}
</script>
<?php
    
declare(strict_types=1);

function is_input_empty(string $password, string $confirmpassword) {
    if (empty( $password || $confirmpassword)){
           return true; 
    }
    else {
        return false;
    }
   }

function passwords_do_not_match(string $password,string $confirmpassword) {
if ($password != $confirmpassword) {
    return true; 
}
else {
    return false;
}
}

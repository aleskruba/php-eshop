<?php
    
declare(strict_types=1);

function is_input_empty(string $email, string $password) {
    if (empty( $email || $password)){
           return true; 
    }
    else {
        return false;
    }
   }

function is_email_valid(string $email) {
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
           return true; 
    }
    else {
        return false;
    }
   }


function is_email_registered(object $pdo,string $email) {
   
    if (get_email($pdo,$email)){
           return true; 
    }
    else {
        return false;
    }
   }
function passwords_do_not_match(string $password,string $confirm_password) {
if ($password != $confirm_password) {
    return true; 
}
else {
    return false;
}
}

function  create_user(object $pdo , string $email, string $password) {
   
    set_user($pdo,$email,$password);
   }
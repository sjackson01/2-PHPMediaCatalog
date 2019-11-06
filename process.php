<?php
//Using value keys save the values from the $_POST array to single variables
$name = $_POST["name"];
$email = $_POST["email"];
$details = $_POST["details"]; 

//Add name and email to email body
echo "<pre>";
$email_body = "";
$email_body .= "Name " . $name . "\n"; 
$email_body .= "Email " . $email . "\n";
$email_body .= "Details " . $details . "\n";
echo $email_body;
echo "</pre>"

/*
$_POST output 
array(3) { 
    ["name"]=> string(14) "Steven Jackson" 
    ["email"]=> string(15) "email@email.com" 
    ["suggest"]=> string(15) "Some suggestion" }
*/
?>
<?php
//Using value keys save the values from the $_POST array to single variables
//Gather all variables from the form
$name = $_POST["name"];
$email = $_POST["email"];
$details = $_POST["details"]; 
/*
$_POST output 
array(3) { 
    ["name"]=> string(14) "Steven Jackson" 
    ["email"]=> string(15) "email@email.com" 
    ["suggest"]=> string(15) "Some suggestion" }
*/
//Add name and email to email body
$email_body = "";
$email_body .= "Name " . $name . "\n"; 
$email_body .= "Email " . $email . "\n";
$email_body .= "Details " . $details . "\n";


header("location:thanks.php");

?>


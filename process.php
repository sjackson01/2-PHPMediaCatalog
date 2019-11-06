<?php
//Using value keys save the values from the $_POST array to single variables
$name = $_POST["name"];
$email = $_POST["email"];
$details = $_POST["details"]; 

//Display each value
echo $name;
echo $email;
echo $details;

/*
$_POST output 
array(3) { 
    ["name"]=> string(14) "Steven Jackson" 
    ["email"]=> string(15) "email@email.com" 
    ["suggest"]=> string(15) "Some suggestion" }
*/
?>
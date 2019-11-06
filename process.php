<?php
//Using value keys save the values from the $_POST array to single variables
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
echo "<pre>";
$email_body = "";
$email_body .= "Name " . $name . "\n"; 
$email_body .= "Email " . $email . "\n";
$email_body .= "Details " . $details . "\n";
echo $email_body;
echo "</pre>";

//To Do: Send email
$pageTitle = "Thank You";
$section = null;
include("inc/header.php");
?>

<div class="section page"
    <h1> Thank you </h1>
    <p> Thanks for the email! I&rsquo;ll check out your suggestion shortly!</p>
</div>

<?php include("inc/footer.php"); ?>
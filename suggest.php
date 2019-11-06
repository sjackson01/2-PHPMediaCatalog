<?php 
//Check $_SERVER array for defined request method 
if($_SERVER["REQUEST_METHOD"]== "POST"){

   //Trim white space to ensure not empty, filter_input code/tags
   $name = trim(filter_input(INPUT_POST,"name", FILTER_SATANIZE_STRING));
   $email = trim(filter_input(INPUT_POST,"email", FILTER_SATANIZE_EMAIL));
   //Concert html to special chars
   $details = trim(filter_input(INPUT_POST,"name", FILTER_SATANIZE_SPECIAL_CHARS)); 

   //Check value from $_POST array is not blank
   If($name == "" || $email == "" || $details ==""){
      echo "Please fill in the required feilds: Name, Email and Details";
      //Stop further processing if blank. 
      exit;
   }
  
   //Add name and email to email body
   $email_body = "";
   $email_body .= "Name " . $name . "\n"; 
   $email_body .= "Email " . $email . "\n";
   $email_body .= "Details " . $details . "\n";

   //Add "thanks" to $_GET status
   header("location:suggest.php?status=thanks");

}
$pageTitle = "Suggest a Media Item";
$section = "suggest";

include("inc/header.php"); 

?>

<div class="section page">
    <div class="wrapper">
        <h1>Suggest a Media Item</h1>
        <!-- Display "Thank You" message if header redirect is completed and $_GET status is thanks -->
        <?php 
        if(isset($_GET["status"]) && $_GET["status"] == "thanks"){
           echo "<p>Thanks for the email! I&rsquo;ll check out your suggestion shortly!</p>";
        }else{ ?>
        <p>If you think there is something I&rsquo;m missing, 
           let me know! Complete the form to send me an e-mail. </p>
           <!--Add form-->
           <form method="post" action="suggest.php">
           <table>
             <tr> 
                <th><label for="name">Name</label></th>
                <td><input type="text" id="name" name="name"/></td>
             </tr>
             <tr> 
                <th><label for="email">EMail</label></th>
                <td><input type="text" id="email" name="email"/></td>
             </tr>
             <tr> 
                <th><label for="details">Suggest Item Details</label></th>
                <td><textarea type="text" id="details" name="details"></textarea></td>
             </tr>
           </table>
                <input type="submit" value="Send" />
           </form>  
        <?php } ?> 
    </div>
</div>

<?php include("inc/footer.php"); ?>
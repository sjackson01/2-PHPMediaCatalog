<?php 
//Check $_SERVER array for defined request method 
if($_SERVER["REQUEST_METHOD"]== "POST"){

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

}
$pageTitle = "Suggest a Media Item";
$section = "suggest";

include("inc/header.php"); 

?>

<div class="section page">
    <div class="wrapper">
        <h1>Suggest a Media Item</h1>
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
    </div>
</div>

<?php include("inc/footer.php"); ?>
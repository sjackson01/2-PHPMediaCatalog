<?php 
//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/Exception.php';
//Require SMTP
require 'vendor/phpmailer/src/SMTP.php';

//Check $_SERVER array for defined request method 
if($_SERVER["REQUEST_METHOD"]== "POST"){

   //Trim white space to ensure not empty, filter_input code/tags
   $name = trim(filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING));
   $email = trim(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL));
   //Concert html to special chars
   $details = trim(filter_input(INPUT_POST,"details",FILTER_SANITIZE_SPECIAL_CHARS)); 

   //Check value from $_POST array is not blank
   If($name == "" || $email == "" || $details ==""){
      echo "Please fill in the required feilds: Name, Email and Details";
      //Stop further processing if blank. 
      exit;
   }

   //Honey Pot conditional to catch bot spams
   if($_POST["address"] != ""){
      echo "Bad form  input";
      exit;
   }
   //Add static PHPMailer validation call to check email valid
   //If valid/invalid returns true/false
   //Use condtional to check return value of method
   if(!PHPMailer::validateAddress($email)){
      echo "Invalide Email Address";
      exit;
   }
   

   //Add name and email to email body
   $email_body = "";
   $email_body .= "Name " . $name . "\n"; 
   $email_body .= "Email " . $email . "\n";
   $email_body .= "Details " . $details . "\n";

   //Send email
   $mail = new PHPMailer;
   //Tell PHPMailer to use SMTP
   $mail->isSMTP();
   //Enable SMTP debugging
   // SMTP::DEBUG_OFF = off (for production use)
   // SMTP::DEBUG_CLIENT = client messages
   // SMTP::DEBUG_SERVER = client and server messages
   $mail->SMTPDebug = off;
   //Set the hostname of the mail server
   $mail->Host = 'smtp.gmail.com';
   // use
   // $mail->Host = gethostbyname('smtp.gmail.com');
   // if your network does not support SMTP over IPv6
   //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
   $mail->Port = 587;
   //Set the encryption mechanism to use - STARTTLS or SMTPS
   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
   //Whether to use SMTP authentication
   $mail->SMTPAuth = true;
   //Username to use for SMTP authentication - use full email address for gmail
   $mail->Username = 'stevenpjackson0@gmail.com';
   //Password to use for SMTP authentication
   $mail->Password = 'dlxnppnpljeftjdz';

   //PHP Mailer native(Not recommended)
   $mail->CharSet = PHPMailer::CHARSET_UTF8;
   //It's important not to use the submitter's address as the from address as it's forgery,
   //which will cause your messages to fail SPF checks.
   //Use an address in your own domain as the from address, put the submitter's address in a reply-to
   //Set from email address and name set to user name input from form
   $mail->setFrom('stevenpjackson0@gmail.com', $name);
   //Replyto form input email and form input name this is a method()
   $mail->addReplyTo($email, $name);
   //Add a recipient manditory but name optional this is a method()
   $mail->addAddress('stevenpjackson0@gmail.com', 'Steven Jackson');
   //Add a subject/user input name to email sent from mailer object this is a property=
   $mail->Subject = 'Library suggestion from ' . $name; 
   //Add form input textarea to email body 
   $mail->Body = $email_body;
   //Call object send method to send the email 
   if (!$mail->send()) {
      //Display error message
       echo "Mailer Error: ". $mail->ErrorInfo;//Display particular error message within property
       exit; 
   }
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
             <!--Create drop down menu--> 
             <tr> 
                <th><label for="category">EMail</label></th>
                <td>
                  <select id="category" name="category"/>
                     <option value="">Select One</option> 
                     <option value="Books">Books</option>
                     <option value="Movies">Movies</option>
                     <option value ="Music">Music</option>
                  </select>
                </td>
             </tr>
             <tr> 
                <th><label for="title">EMail</label></th>
                <td><input type="title" id="title" name="title"/></td>
             </tr>
             <tr> 
                <th><label for="format">EMail</label></th>
                <td>
                  <select id="format" name="format"/>
                     <option value="">Select One</option> 
                     <option value="Books">Books</option>
                     <option value="Movies">Movies</option>
                     <option value ="Music">Music</option>
                  </select>
                </td>
             </tr>
             <tr> 
                <th><label for="details">Suggest Item Details</label></th>
                <td><textarea type="text" id="details" name="details"></textarea></td>
             </tr>
             <!--Honey Pot Field-->
             <!--Hide using CSS--> 
             <tr style="display:none"> 
                <th><label for="address"><Address></Address></label></th>
                <td><input type="text" id="address" name="address"/>
                <p>Please leave this field blank</p></td>
             </tr>
           </table>
                <input type="submit" value="Send" />
           </form>  
        <?php } ?> 
    </div>
</div>

<?php include("inc/footer.php"); ?>
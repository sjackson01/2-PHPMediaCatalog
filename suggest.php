<?php 
//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/Exception.php';
//Require SMTP
require 'vendor/phpmailer/src/SMTP.php';

//Check $_SERVER array for defined request method 
if($_SERVER["REQUEST_METHOD"]== "POST"){
   //Trim white space to ensure not empty, filter_input from form "$_POST" 
   //Arg 1 "input_type" arg 2 "variable name" arg 3 "Filter_Instructions 
   $name = trim(filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING));
   $email = trim(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL));
   $category = trim(filter_input(INPUT_POST,"category",FILTER_SANITIZE_STRING));
   $title = trim(filter_input(INPUT_POST,"title",FILTER_SANITIZE_STRING));
   $format = trim(filter_input(INPUT_POST,"format",FILTER_SANITIZE_STRING));
   $genre = trim(filter_input(INPUT_POST,"genre",FILTER_SANITIZE_STRING));
   $year = trim(filter_input(INPUT_POST,"year",FILTER_SANITIZE_NUMBER_INT));
   $details = trim(filter_input(INPUT_POST,"details",FILTER_SANITIZE_SPECIAL_CHARS));
   
   //Check value from $_POST array is not blank(Making these fields required)
   If($name == "" || $email == "" || $category =="" || $title ==""){
      $error_message = "Please fill in the required feilds: Name, Email, Category and Title.";
   
   }

   //Honey Pot conditional to catch bot spams
   if($_POST["address"] != ""){
      $error_message = "Bad form  input";
   }

   //Add static PHPMailer validation call to check email valid
   //If valid/invalid returns true/false
   //Use condtional to check return value of method
   if(!PHPMailer::validateAddress($email)){
      $error_message = "Invalide Email Address";
   }

   //If error message is not set send email 
   if(!isset($error_message)){
      //Add name and email to email body
      $email_body = "";
      $email_body .= "Name " . $name . "\n"; 
      $email_body .= "Email " . $email . "\n";
      //Add email header
      $email_body .= "\n\n Suggest item \n\n";
      $email_body .= "Category " . $category . "\n";
      $email_body .= "Title " . $title . "\n";
      $email_body .= "Genre " . $genre . "\n";
      $email_body .= "Year " . $year . "\n";
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
      //If Call to send method is successful ridirect to thank you message
      if ($mail->send()) {
         //Add "thanks" to $_GET status
         header("location:suggest.php?status=thanks");
         exit;
      }else{ //Possibly unecessary
         //Display error message
         $error_message = "Mailer Error: ". $mail->ErrorInfo;//Display particular error message within property
      }
   }
}//-------------------------------->End form validation and SMTP call
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
         }else {
            //Display error message 
            if(isset($error_message)){
            echo '<p class="message">' . $error_message . '</p>';
         }else{
            echo "<p>If you think there is something I&rsquo;m missing, 
            let me know! Complete the form to send me an e-mail. </p>";
         }
         ?>
        <p>If you think there is something I&rsquo;m missing, 
           let me know! Complete the form to send me an e-mail. </p>
           <!--Add form-->
           <form method="post" action="suggest.php">
           <table>
             <tr> 
                <th><label for="name">Name (required)</label></th>
                <td><input type="text" id="name" name="name"/></td>
             </tr>
             <tr> 
                <th><label for="email">EMail (required)</label></th>
                <td><input type="text" id="email" name="email"/></td>
             </tr>
             <!--Create drop down menu--> 
             <tr> 
                <th><label for="category">Category (required)</label></th>
                <td>
                  <select id="category" name="category"/>
                     <option value="">Select One</option> 
                     <option value="Book">Books</option>
                     <option value="Movie">Movies</option>
                     <option value ="Music">Music</option>
                  </select>
                </td>
             </tr>
             <tr> 
                <th><label for="title">Title (required)</label></th>
                <td><input type="title" id="title" name="title"/></td>
             </tr>
             <!-- Create format option list --> 
             <tr> 
                <th><label for="format">Format</label></th>
                <td>
                  <select id="format" name="format"/>
                     <option value="">Select One</option> 
                        <optgroup label="Book">
                           <option value="Audio">Audio</option>
                           <option value="Ebook">Ebook</option>
                           <option value="Hardback">Hardback</option>
                           <option value="Paperback">Paperback</option> 
                        </optiongroup>
                        <optgroup label="Movie">
                           <option value="Blue-ray">Blue-ray</option>
                           <option value="DVD">DVD</option>
                           <option value="Streaming">Streaming</option>
                           <option value="VHS">VHS</optoin>
                        </optiongroup>
                        <optgroup label="Music">
                            <option value="Cassette">Cassette</option>
                            <option value="CD">CD</optoin>
                            <option value="MP3">MP3</option>
                            <option value="Vinyl">Vinyl</option>
                     </optiongroup>
                  </select>
                </td>
             </tr>
            <!-- Create genre drop down --> 
             <tr>
                <th>
                    <label for="genre">Genre</label>
                </th>
                <td>
                    <select name="genre" id="genre">
                        <option value="">Select One</option>
                        <optgroup label="Books">
                            <option value="Action">Action</option>
                            <option value="Adventure">Adventure</option>
                            <option value="Comedy">Comedy</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Historical">Historical</option>
                            <option value="Historical Fiction">Historical Fiction</option>
                            <option value="Horror">Horror</option>
                            <option value="Magical Realism">Magical Realism</option>
                            <option value="Mystery">Mystery</option>
                            <option value="Paranoid">Paranoid</option>
                            <option value="Philosophical">Philosophical</option>
                            <option value="Political">Political</option>
                            <option value="Romance">Romance</option>
                            <option value="Saga">Saga</option>
                            <option value="Satire">Satire</option>
                            <option value="Sci-Fi">Sci-Fi</option>
                            <option value="Tech">Tech</option>
                            <option value="Thriller">Thriller</option>
                            <option value="Urban">Urban</option>
                        </optgroup>
                        <optgroup label="Movies">
                            <option value="Action">Action</option>
                            <option value="Adventure">Adventure</option>
                            <option value="Animation">Animation</option>
                            <option value="Biography">Biography</option>
                            <option value="Comedy">Comedy</option>
                            <option value="Crime">Crime</option>
                            <option value="Documentary">Documentary</option>
                            <option value="Drama">Drama</option>
                            <option value="Family">Family</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Film-Noir">Film-Noir</option>
                            <option value="History">History</option>
                            <option value="Horror">Horror</option>
                            <option value="Musical">Musical</option>
                            <option value="Mystery">Mystery</option>
                            <option value="Romance">Romance</option>
                            <option value="Sci-Fi">Sci-Fi</option>
                            <option value="Sport">Sport</option>
                            <option value="Thriller">Thriller</option>
                            <option value="War">War</option>
                            <option value="Western">Western</option>
                        </optgroup>
                        <optgroup label="Music">
                            <option value="Alternative">Alternative</option>
                            <option value="Blues">Blues</option>
                            <option value="Classical">Classical</option>
                            <option value="Country">Country</option>
                            <option value="Dance">Dance</option>
                            <option value="Easy Listening">Easy Listening</option>
                            <option value="Electronic">Electronic</option>
                            <option value="Folk">Folk</option>
                            <option value="Hip Hop/Rap">Hip Hop/Rap</option>
                            <option value="Inspirational/Gospel">Insirational/Gospel</option>
                            <option value="Jazz">Jazz</option>
                            <option value="Latin">Latin</option>
                            <option value="New Age">New Age</option>
                            <option value="Opera">Opera</option>
                            <option value="Pop">Pop</option>
                            <option value="R&B/Soul">R&amp;B/Soul</option>
                            <option value="Reggae">Reggae</option>
                            <option value="Rock">Rock</option>
                        </optgroup>
                    </select>
                </td>
            </tr>
            <!-- Create year text input --> 
            <tr> 
                <th><label for="year">Year</label></th>
                <td><input type="year" id="year" name="year"/></td>
             </tr>
             <tr> 
                <th><label for="details">Additional Details</label></th>
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
<?php 
$pageTitle = "Suggest a Media Item";
$section = "suggest";

include("inc/header.php"); ?>

<div class="section page">
    <div class="wrapper">
        <h1>Suggest a Media Item</h1>
        <p>If you think there is something I&rsquo;m missing, 
           let me know! Complete the form to send me an e-mail. </p>
           <!--Add a 'name' form-->
           <form method="post">
            <label for="name">Name<input type="text" id="name" name="name"/></label>
           </form>
    </div>
</div>

<?php include("inc/footer.php"); ?>
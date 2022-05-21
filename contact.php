<?php

include("./includes/db.php");
include("./includes/config.php");
include("./includes/header.php");


// CHECK STORE ONLINE
$result = mysql_query("SELECT shop_online FROM settings LIMIT 0,1");
$cols   = mysql_fetch_row($result);
if(!$cols[0])
{
	header("location: offline.php");
	die;
}

// get balance
$uid = mysql_real_escape_string($_SESSION['member']);
$result = mysql_query("SELECT balance FROM users WHERE username='$uid'");
$bals = mysql_fetch_row($result);
$balance = $bals[0];

?>

<html>
<head><link rel="stylesheet" href="style.css" type="text/css" media="screen" />

<link href="favicon.ico" rel="icon" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title><?php echo htmlspecialchars($SHOP['maintitle'], ENT_QUOTES, 'UTF-8'); ?></title>
       <link href="style3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
  setTimeout('location.replace("/index.php?act=logout")', 900000);
</script>
<style type="text/css">
<!--
.style8 {
	font-size: x-small
}
-->
</style>
</head>
<body>


<div id="wrap" align="center">
  <div align="center">
<? include 'navbar.php';?>

			            <p>&nbsp;</p>
						            <p>&nbsp;</p>
<div align="center"><br/>
</div>
<div id="contentForm">

            <!-- The contact form starts from here-->
            <?php
                 $error    = ''; // error message
                 $name     = ''; // sender's name
                 $email    = ''; // sender's email address
                 $subject  = ''; // subject
                 $message  = ''; // the message itself
               	 $spamcheck = ''; // Spam check

            if(isset($_POST['send']))
            {
                 $name     = $_POST['name'];
                 $email    = $_POST['email'];
                 $subject  = $_POST['subject'];
                 $message  = $_POST['message'];
               	 $spamcheck = $_POST['spamcheck'];

                if(trim($name) == '')
                {
                    $error = '<div class="errormsg">Please enter your name!</div>';
                }
            	    else if(trim($email) == '')
                {
                    $error = '<div class="errormsg">Please enter your email address!</div>';
                }
                else if(!isEmail($email))
                {
                    $error = '<div class="errormsg">You have enter an invalid e-mail address. Please, try again!</div>';
                }
            	    if(trim($subject) == '')
                {
                    $error = '<div class="errormsg">Please enter a subject!</div>';
                }
            	else if(trim($message) == '')
                {
                    $error = '<div class="errormsg">Please enter your problem!</div>';
                }
	          	else if(trim($spamcheck) == '')
	            {
	            	$error = '<div class="errormsg">Please enter the number for Spam Check!</div>';
	            }
	          	else if(trim($spamcheck) != '6')
	            {
	            	$error = '<div class="errormsg">Spam Check: The number you entered is not correct! 4 + 2 = ???</div>';
	            }
                if($error == '')
                {
                    if(get_magic_quotes_gpc())
                    {
                        $message = stripslashes($message);
                    }

                    // the email will be sent here
                    // make sure to change this to be your e-mail
                    $to      = "smithsmith773@yahoo.com";

                    // the email subject
                    // '[Contact Form] :' will appear automatically in the subject.
                    // You can change it as you want

                    $subject = '[Contact Form] : ' . $subject;

                    // the mail message ( add any additional information if you want )
                    $msg     = "From : $name \r\ne-Mail : $email \r\nSubject : $subject \r\n\n" . "Message : \r\n$message";

                    mail($to, $subject, $msg, "From: $email\r\nReply-To: $email\r\nReturn-Path: $email\r\n");
            ?>

                  <!-- Message sent! (change the text below as you wish)-->
                  <div style="text-align:center;">
                    <h1>Thank You!</h1>
                       <p>Thank you <b><?=$name;?></b>, your message is sent!</p>
                  </div>
                  <!--End Message Sent-->


            <?php
                }
            }

            if(!isset($_POST['send']) || $error != '')
            {
            ?>

            <h3 class="style8"><h3>If ur tools not work/ or invalid please contact us  </h3>
			<a href="ymsgr:SendIM?smithsmith773"><img border="0" src="http://opi.yahoo.com/online?u=smithsmith773&amp;m=g&amp;t=2"></a>

<!--Error Message-->
            <?=$error;?>

            <form  method="post" name="contFrm" id="contFrm" action="">


                      <label><span class="required">*</span> User Name:</label>
            			<input name="name" type="text" class="box" id="name" size="30" value="<?=$name;?>" />

            			<label><span class="required">*</span> Email: </label>
            			<input name="email" type="text" class="box" id="email" size="30" value="<?=$email;?>" />

            			<label><span class="required">*</span> Subject: </label>
            			<input name="subject" type="text" class="box" id="subject" size="30" value="<?=$subject;?>" />

                 		<label><span class="required">*</span> Problem: </label>
                 		<textarea name="message" cols="40" rows="3"  id="message"><?=$message;?></textarea>

            			<label><span class="required">*</span> Spam Check: <b>4 + 2 =</b></label>
						<input name="spamcheck" type="text" class="box" id="spamcheck" size="4" value="<?=$spamcheck;?>" /><br /><br />

            			<!-- Submit Button-->
                 		<input name="send" type="submit" class="button" id="send" value="" />
            </form>

            <!-- E-mail verification. Do not edit -->
            <?php
            }

            function isEmail($email)
            {
                return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i"
                        ,$email));
            }
            ?>
            <!-- END CONTACT FORM -->

            <p>&nbsp;</p>
     </div> 
<!-- /contentForm -->
     
</body>
</html>


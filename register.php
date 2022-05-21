<?<html>
</html>

include('./includes/db.php');
include("./includes/config.php");

// CHECK STORE ONLINE
$result = mysql_query("SELECT shop_online FROM settings LIMIT 0,1");
$cols   = mysql_fetch_row($result);
if(!$cols[0])
{
	header("location: offline.php");
	die;
}

$errormsg   = 'Complete the required fields!'; // default message
$incomplete = 0; // prevents users from tampering with variables

if($_SESSION['member']!='') 
{
	header("location:index.php");
}

function VisitorIP()
{ 
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else 
		$ip = $_SERVER['REMOTE_ADDR'];
		
 	return trim($ip);
}

if(isset($_POST['txtUser']) && !preg_match("/perl/i", $_SERVER['HTTP_USERAGENT']))
{
	$username  = mysql_real_escape_string($_POST['txtUser']);
	$password  = mysql_real_escape_string($_POST['txtPass']);
	$password2 = mysql_real_escape_string($_POST['txtPass2']);
	$email     = mysql_real_escape_string($_POST['txtEmail']);
	$icq       = mysql_real_escape_string($_POST['txtIcq']);
	
	$result = mysql_query("SELECT * FROM users WHERE username='$username'");
	$userexist = mysql_num_rows($result);
	
	$result = mysql_query("SELECT * FROM users WHERE email='$email'");
	$emailexist = mysql_num_rows($result);
	
	$res = mysql_query("SELECT registration FROM settings");
	$reg = mysql_fetch_row($res);
	
	if($userexist == 1 || $username == "NONE" || $username == "NULL" || $username == "SYSTEM" || $username == "none" || $username == "system") // PRESERVED USERNAMES! 
	{
		$incomplete = 1;
		$errormsg = 'The username you choose is already taken!';
	}
	else if($emailexist == 1)
	{
		$incomplete = 1;
		$errormsg = 'Email address you entered already exists!';
	}
	else if($password != $password2 || $password == "")
	{
		$incomplete = 1;
		$errormsg = 'Your passwords do not match!';
	}	
	else if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email))
	{
		$incomplete = 1;
		$errormsg = 'Please enter a valid email address!';
	}
	else if($icq == "0")
	{
		$incomplete = 1;
		$errormsg = 'Please enter your ICQ number!';
	}
	else if(strlen($username) > 20 || $username == "")
	{
		$incomplete = 1;
		$errormsg = 'Your username must be under 20 characters!';
	}
	else if(!$reg[0])
	{
		$incomplete = 1;
		$errormsg = 'Registrations closed contact support icq#: 620334543 .';
	}
	else
	{
		$salt = 'fs978'; // SALT for encrypting
		$password = md5($password . $salt);
		// All the fields were completed lets insert the user!
		$ip = VisitorIP();
		$ip = mysql_real_escape_string($ip);
		// (username, password, icq, email, ips, regdate, lastlogin, failedlogin, balance, checkercredits, lastip)
		mysql_query("INSERT INTO users VALUES('$username', '$password', '$icq', '$email', '$ip', now(), 'NULL', 0, 0.00, 0, '$ip', '0', '0', 0, 0)") or die (mysql_error());
		
		header("location: login.php?reg=1");
	}	
}

?>

<!-- saved from url=(0037)http://mafianet.org/protect/login.php -->
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title><?php echo htmlspecialchars($SHOP['name'], ENT_QUOTES, 'UTF-8'); ?></title>
<link rel="stylesheet" media="screen" href="http://mafianet.org/protect/css/reset.css">
<link rel="stylesheet" media="screen" href="http://mafianet.org/protect/css/grid.css">
<link rel="stylesheet" media="screen" href="css/login.css">
<link rel="stylesheet" media="screen" href="http://mafianet.org/protect/css/forms.css">
<script type="text/javascript" src="js/jquery.tools.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.min.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript">
  setTimeout('location.replace("/index.php?act=logout")', 900000);
</script>
<!--[if lt IE 8]>
<link rel="stylesheet" media="screen" href="http://mafianet.org/protect/css/ie.css" />
<![endif]-->
<!--[if lt IE 9]>
<script src="http://mafianet.org/protect/js/html5.js"></script>
<script src="http://mafianet.org/protect/js/PIE.js"></script>
<script src="http://mafianet.org/protect/js/IE9.js"></script>
<![endif]-->
</head>
<body>
<div style="overflow:hidden; margin-top: 10px; color: black; font-size: 12px; font-weight:bold; text-align:center;">
    <br />
	    <p>&nbsp;</p>
    <p>
      <?php if($incomplete == 1) echo '<p class="style2">'.htmlspecialchars($errormsg, ENT_QUOTES, 'UTF-8').'</p>'; ?>
    </p>
    <p>&nbsp;</p>
</div>
<div id="wrapper">

	<section>            <div class="container clearfix">   
                			
                <section class="main-section grid_2">
                    <div class="main-content grid_1">					
					<header>
					
                            <h2>Register</h2>
                    </header>
                    <section class="clearfix">
					<form class="form" name="form1" method="post" action="" novalidate="novalidate">
				<div class="clearfix">
                     <label>Username <small>Enter your username</small></label><input type="text" method="post" name="txtUser" required="required" id="acpro_inp0">
                </div>
				<div class="clearfix">
                     <label>Password <small>Enter your password</small></label><input type="password" name="txtPass" required="required">
                </div>
				<div class="clearfix">
                     <label>Verify Password:<small>Verify your password</small></label><input type="password" name="txtPass2" required="required">
                </div>
				<div class="clearfix">
                     <label>Email<small>Enter your email</small></label><input type="text" name="txtEmail" required="required">
                </div>
				<div class="action clearfix">
                    <button class="button button-gray" id="btnRegister" type="submit" name="btnRegister" value="Register"><span class="send"></span>Register</button>
					<button class="button button-gray" type="reset">Reset</button>
                </div>
					</form>
			        </section>
               
            </section>
		</div>
			                    
	</section>
</div>
<script>
$(function () {
    var triggers = $(".modalInput").overlay({
        mask: {
            color: '#000',
            loadSpeed: 200,
            opacity: 0.5
        },

        closeOnClick: false
    });
});
</script>

</body></html>
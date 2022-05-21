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
$result = mysql_query("SELECT balance FROM users WHERE username='$uid'") or die(mysql_error());
$bals = mysql_fetch_row($result);
$balance = $bals[0];

if(isset($_POST['chgpass']))
{

	$salt = 'fs978'; // SALT for encrypting

	$password = md5($_POST['oldpass'] . $salt);
	
	$result = mysql_query("SELECT password FROM users WHERE username='$uid'");
	$oldpass = mysql_fetch_row($result);
	
	if($_POST['newpass1'] != $_POST['newpass2'])
	{
		$chgmsg = 'The passwords you entered do not match! Please try again!';
	}
	else if($oldpass[0] != $password)
	{
		$chgmsg = 'Old password does not match!';
	}
	else
	{
		$newpass = md5($_POST['newpass1'] . $salt);
		mysql_query("UPDATE users SET password='$newpass' WHERE username='$uid' AND password='$password'");
		$chgmsg = 'Password successfully changed!';
	}
}

?>

<html>
<head><link rel="stylesheet" href="style.css" type="text/css" media="screen" />

<link href="favicon.ico" rel="icon" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title><?php echo htmlspecialchars($SHOP['maintitle'], ENT_QUOTES, 'UTF-8'); ?></title>

<script type="text/javascript">
  setTimeout('location.replace("/index.php?act=logout")', 900000);
</script>
</head>
<body>


<div id="wrap" align="center">
  <div align="center">
<? include 'navbar.php';?>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p><strong>Change Password</strong></p>
    <p><?php echo '<span>'.htmlspecialchars($chgmsg, ENT_QUOTES, 'UTF-8').'</span>'; ?>&nbsp;</p>
    <?php echo '<form name="form1" action="" method="POST">'; ?>
      
        <div align="center"><strong>Old Password:</strong></div>
        <input name="oldpass" type="password" class="thon1r" id="oldpass">
      
      
      
       <div align="center"><strong>New Password:</strong></div>
        <input name="newpass1" type="password" class="thon1r" id="newpass1">
      
      
      
        <div align="center"><strong>Confirm Password:</strong></div>
        <input name="newpass2" type="password" class="thon1r" id="newpass2">


    <p>&nbsp;</p>
    <p class="style7">&nbsp;</p>
    <p>
      <label>
      <input name="chgpass" type="submit" class="myButton" id="chgpass" value="Change Account Password">
      </label>
      <?php echo '</form>'; ?>
    </p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
</div>
</body>
</html>

</body>
</html>

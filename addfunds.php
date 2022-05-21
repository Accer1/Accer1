<?php


include("./includes/db.php");
include("./includes/config.php");
include("./includes/header.php");

$infoMsg = "";

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

if(isset($_POST['btnWMZ']))
{
	$amount = mysql_real_escape_string($_POST['txtWMZ']);
	$purse  = mysql_real_escape_string($_POST['txtPurse']);
	
	$ip = mysql_real_escape_string(VisitorIP());
	
	mysql_query("INSERT INTO orders(amount,username,lrpaidby,lrtrans,wmid,wmextra,ip,state,date) VALUES('$amount', '$uid', 'NONE', 'NONE', '$purse', 'NONE', '$ip', 'PENDING', now())");
	echo '<html><body><script>alert("Send ' . htmlspecialchars($amount, ENT_QUOTES, 'UTF-8') . ' WMZ to PURSE: '. htmlspecialchars($SHOP['wmzpurse'], ENT_QUOTES, 'UTF-8') .'");</script></body></html>';
	
	$infoMsg = '<span class="orders">ORDER PENDING! PLEASE SEND ' . htmlspecialchars($amount, ENT_QUOTES, 'UTF-8') . ' TO WMZ PURSE: <span class="blackbold">Z261816219826</span></span>';
}

function VisitorIP()
{ 
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else $ip = $_SERVER['REMOTE_ADDR'];
 
	return trim($ip);
}

?>
<html>

<head><link rel="stylesheet" href="style.css" type="text/css" media="screen" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title><?php echo htmlspecialchars($SHOP['maintitle'], ENT_QUOTES, 'UTF-8'); ?></title>

<link href="favicon.ico" rel="icon" />
<script type="text/javascript">
  setTimeout('location.replace("/index.php?act=logout")', 900000);
</script>
</head>
<body>

</div>
<div id="wrap" align="center">
  <div align="center">
<? include 'navbar.php'; ?>

    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    
   
    <table width="760" border="0" class="thon1">
      <tr>
<html>
<center><font size="2"><span style="color: black;">Payment via <span style="color: orange;">[ BITCOIN ]</font></center>

        <div align="center"><a href="./index.php"><img src="http://s9.postimg.org/9ci9wo6r3/Single_Coin.png" width="100" height="100" border="0"></a><br/>
</div>
          <p class="style2"><strong><span style="color: orange;">MINIMUM PAYMENT: $5.00</strong></p>
		</div>
<p class="style2"><strong><span style="color: black;">Please choose amount to deposit</strong></p>
			<form name="payment" action="btx1.php" method="POST">
  <strong>$</strong>
  <input name="amount" type="text" size="10">
  <br />
  <center><font size="4"><input type="submit" name="process" class="exchanger" value="DEPOSIT"></font>
  </form>
          <p class="style2">&nbsp;</p>
          <p><strong><span style="color: orange;">AFTER YOUR PAYMENT DONE FUNDS WILL BE ADDED TO YOUR ACCOUNT</strong> </p>
<hr style="width:500px" />
		  <p>&nbsp;</p>
		  
</html>
<html>

      <tr>
<html>
    <table width="760" border="0" class="thon1">
      <tr>
<html>
<center><font size="2"><span style="color: black;">Payment via <span style="color: orange;">[ Perfect Money ]</font></center>

        <div align="center"><a href="./index.php"><img src="http://s17.postimg.org/av7ll4q97/perfect_money.png" width="100" height="100" border="0"></a><br/>
</div>
          <p class="style2"><strong><span style="color: orange;">MINIMUM PAYMENT: $5.00</strong></p>
		</div>
<p class="style2"><strong><span style="color: black;">Please choose amount to deposit</strong></p>
			<form name="payment" action="pmtobtc.php" method="POST">
  <strong>$</strong>
  <input name="amount" type="text" size="10">
  <br />
  <center><font size="4"><input type="submit" name="process" class="exchanger" value="DEPOSIT"></font>
  </form>
          <p class="style2">&nbsp;</p>
          <p><strong><span style="color: orange;">AFTER YOUR PAYMENT DONE FUNDS WILL BE ADDED TO YOUR ACCOUNT</strong> </p>
<hr style="width:500px" />
		  <p>&nbsp;</p>
		  
</html>
<head>
<script language=JavaScript> var message="Function Disabled!"; function clickIE4(){ if (event.button==2){ alert(message); return false; } } function clickNS4(e){ if (document.layers||document.getElementById&&!document.all){ if (e.which==2||e.which==3){ alert(message); return false; } } } if (document.layers){ document.captureEvents(Event.MOUSEDOWN); document.onmousedown=clickNS4; } else if (document.all&&!document.getElementById){ document.onmousedown=clickIE4; } document.oncontextmenu=new Function("alert(message);return false") </script>
</head>
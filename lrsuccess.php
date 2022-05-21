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

$paidto = strip_tags($_POST['lr_paidto']);
$amount = strip_tags($_POST['lr_amnt']);
$trans  = strip_tags($_POST['lr_transfer']);
$time   = strip_tags($_POST['lr_timestamp']); 

// get balance
$uid = mysql_real_escape_string($_SESSION['member']);//

$result = mysql_query("SELECT balance FROM users WHERE username='$uid'") or die ("ERROR! CONTACT SUPPORT!");
$row = mysql_fetch_row($result);
$balance = $row[0];

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
    <p><strong>PAYMENT SUCCESS! YOUR NEW BALANCE:<? echo '<span style="color:#FF0000">$' . htmlspecialchars($balance, ENT_QUOTES, 'UTF-8') . '</span>'; ?></strong></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>-Details -</p>
    <p>&nbsp;</p>
    <table width="760" border="0">
      <tr>
        <td width="165" class="thon"><div align="center"><strong>PAID TO</strong></div></td>
        <td width="165" class="thon"><div align="center"><strong>AMOUNT</strong></div></td>
        <td width="204" class="thon"><div align="center"><strong>TRANSACTION ID</strong></div></td>
        <td width="198" class="thon"><div align="center"><strong>TIME</strong></div></td>
      </tr>
      <tr>
        <td class="thon1"><div align="center"><?php echo htmlspecialchars($paidto, ENT_QUOTES, 'UTF-8'); ?></div></td>
        <td class="thon1"><div align="center"><?php echo htmlspecialchars($amount, ENT_QUOTES, 'UTF-8'); ?></div></td>
        <td class="thon1"><div align="center"><?php echo htmlspecialchars($trans, ENT_QUOTES, 'UTF-8'); ?></div></td>
        <td class="thon1"><div align="center"><?php echo htmlspecialchars($time, ENT_QUOTES, 'UTF-8'); ?></div></td>
      </tr>
    </table>
    <p><strong></strong></p>
    
  </div>
</div>
</body>
</html>

</body>
</html>

<?php

include("./includes/db.php");
include("./includes/config.php");
include("./includes/header.php");

?>

<html>
<head><link rel="stylesheet" href="style.css" type="text/css" media="screen" />


<link href="favicon.ico" rel="icon" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title><?php echo htmlspecialchars($SHOP['maintitle'], ENT_QUOTES, 'UTF-8'); ?></title>
<script type="text/javascript">
  setTimeout('location.replace("/index.php?act=logout")', 900000);
</script></head>
<body>
<div align="center"><a href="./index.php"><img src="images/logo.png" width="800" height="80" border="0"></a><br/>
</div>
<div id="wrap" align="center">
  <div align="center">
<? include 'navbar.php';?>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p class="style4"><strong>PAYMENT FAILED!</strong></p>
    <p class="style4">&nbsp;</p>
    <p class="style4">&nbsp;</p>
    <p class="style4">Your payment failed! Please <a href="addfunds.php">CLICK HERE</a> to try again! Or contact <a href="support.php">SUPPORT</a></p>
    <p class="style4">&nbsp;</p>
    <p class="style4">&nbsp;</p>
    <p class="style1">FALED AMOUNT: <?php $amount = $_POST['lr_amnt']; echo htmlspecialchars($amount, ENT_QUOTES, 'UTF-8'); ?></p>
    <p class="style4">&nbsp;</p>
    <p>&nbsp;</p>
    <p><span class="style1"><?php echo htmlspecialchars($SHOP['name'], ENT_QUOTES, 'UTF-8'); ?> || 
      <?php $load = microtime(); print("Page generated in " . number_format($load, 2) . " seconds"); ?></span><br>
    &nbsp;  </p>
  </div>
</div>
</body>
</html>

</body>
</html>

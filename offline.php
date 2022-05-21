<?php

include("./includes/db.php");
include("./includes/config.php");

$result = mysql_query("SELECT shop_online FROM settings LIMIT 0,1");
$cols   = mysql_fetch_row($result);
if($cols[0])
{
	header("location: index.php");
	die;
}

?>

<html>
<head><link rel="stylesheet" href="style.css" type="text/css" media="screen" />

<link href="favicon.ico" rel="icon" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title><?php echo htmlspecialchars($SHOP['name'], ENT_QUOTES, 'UTF-8'); ?> :: csh0p is Under Maintenance! Check Back Later!</title>

</head>
<body>
<div align="center"><a href="./index.php"><img src="images/logo.png" width="800" height="80" border="0"></a><br/>
</div>

<div id="wrap" align="center">
  <div align="center">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p class="style2">UNDER MAINTENANCE</p>
    <p class="style2">&nbsp;</p>
    <p class="style2">&nbsp;</p>
    <p class="style1"><strong>Shop is curently offline check back soon !   Fresh Stuff and Accounts csh0p is cooming soon !  </strong></p>
    <p class="style1">&nbsp;</p>
    <p>&nbsp;</p>

    <p>&nbsp;</p>
      </span><br>
    &nbsp;  </p>
  </div>
</div>
</body>
</html>

</body>
</html>

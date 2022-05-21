<?php

include("./includes/db.php");
include("./includes/config.php");
include("./includes/header.php");

$showMessage = 0;

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

// DELETE ALL CARDS
if(isset($_GET['deletes'])) // delete selected cards
{
	while(list($key, $val) = @each($_POST['deletes']))
	{
		$val = mysql_real_escape_string($val);
		mysql_query("DELETE FROM accounts WHERE username='$uid' AND account_id='$val' AND sold=1");
	}
	$showMessage = "Selected accounts have been deleted!!";
}
if(isset($_GET['delete']) && is_numeric($_GET['delete'])) // delete single card
{
	$accountid = mysql_real_escape_string($_GET['delete']);
	mysql_query("DELETE FROM accounts WHERE username='$uid' AND account_id='$accountid'");
}

?>
<?
// DELETE ALL CARDS
if(isset($_POST['deletes'])) // delete selected cards
{
	while(list($key, $val) = @each($_POST['deletes']))
	{
		$val = mysql_real_escape_string($val);
		mysql_query("DELETE FROM accounts WHERE username='$uid' AND account_id='$val' AND sold=1");
	}
	$showMessage = "Selected accounts have been deleted!!";
}
if(isset($_GET['delete']) && is_numeric($_GET['delete'])) // delete single card
{
	$accountid = mysql_real_escape_string($_GET['delete']);
	mysql_query("DELETE FROM accounts WHERE username='$uid' AND account_id='$accountid'");
}

?>

<html>
<head><link rel="stylesheet" href="style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css1/style.css" type="text/css" media="screen" />



<link href="favicon.ico" rel="icon" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title><?php echo htmlspecialchars($SHOP['maintitle'], ENT_QUOTES, 'UTF-8'); ?></title>



<script type="application/javascript">

function confirmDeleteAll()
{
	if(confirm("Are you sure you want to delete ALL accounts ?"))
	{
		window.location = "<?php echo htmlspecialchars($SHOP['url'], ENT_QUOTES, 'UTF-8'); ?>/myaccounts.php?deletes=all";
	}		
	return false;
}

function confirmDeleteCard(id)
{
	if(confirm("Are you sure you want to delete this account ?"))
	{
		window.location = "<?php echo htmlspecialchars($SHOP['url'], ENT_QUOTES, 'UTF-8'); ?>/myaccounts.php?deletes=" + id;
	}		
	return false;
}

function confirmDeleteSelected()
{
	if(confirm("Are you sure you want to delete the selected accounts?"))
	{
		document.forms["mycards"].submit();
	}		
	return false;
}
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
<script type="text/javascript" src="script.js"></script>
</head>

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
    <p><?php
    
		if($showMessage) // display message
		{
			echo '<strong>Message: </strong><span class="redbolded">' . htmlspecialchars($showMessage, ENT_QUOTES, 'UTF-8') . '</span><br /><br />';
		}
	
	?>&nbsp;</p>
<script language="JavaScript" type="text/javascript">
<!--
function toggle(source) {
  checkboxes = document.getElementsByName('acc[]');
  for each(var checkbox in checkboxes)
    checkbox.checked = source.checked;
}
-->
</script> 
	
	<div class="notification download">
        <span></span>
        <div class="text">
		<br />
        	<p>All Account which you buy save here, now u can download or delete. <br /><strong>Your Accounts :</strong>(<?php $result = mysql_query("SELECT * FROM accounts WHERE username='$uid'"); echo mysql_num_rows($result); ?>) </p>
    	</div>
    </div>
	
    
    <p>&nbsp;</p>
	
	
	<table width="799" >
      <tr>
        <td class="thon"><div align="center"><strong>Account Type</strong></div></td>
        <td class="thon"><div align="center"><strong>Country</strong></div></td>
        <td class="thon"><div align="center"><strong>Info</strong></div></td>
        <td class="thon"><div align="center"><strong>Login</strong></div></td>
        <td class="thon"><div align="center"><strong>Pass</strong></div></td>
        <td class="thon"><div align="center"><strong>Additional Infos</strong></div></td>
		<td class="thon"><div align="center"><strong>Delete</strong></div></td>
      </tr>
<?php
	  
	  	$sql=mysql_query("select * from accounts where username='$uid' LIMIT 50") or die("error");
			while($row = mysql_fetch_array($sql))
			{
				echo '<form name="mycards" method="post" action="">';
				echo '<tr>
				 <td  class="thon1"><div align="center">'.htmlspecialchars($row["acctype"], ENT_QUOTES, 'UTF-8').'</div></td>
				 <td  class="thon1"><div align="center">'.htmlspecialchars($row["country"], ENT_QUOTES, 'UTF-8').'</div></td>
				 <td  class="thon1"><div align="center">'.htmlspecialchars($row["info"], ENT_QUOTES, 'UTF-8').'</div></td>
				 <td  class="thon1"><div align="center">'.htmlspecialchars($row["login"], ENT_QUOTES, 'UTF-8').'</div></td>
				 <td  class="thon1"><div align="center">'.htmlspecialchars($row["pass"], ENT_QUOTES, 'UTF-8').'</div></td>
				 <td  class="thon1"><div align="center">'.htmlspecialchars($row["addinfo"], ENT_QUOTES, 'UTF-8').'</div></td>
			
				 <td  class="thon1"><div align="center"><label><input class="thon1" type="checkbox" name="deletes[]" value="'.htmlspecialchars($row['account_id'], ENT_QUOTES, 'UTF-8').'"></label> <a href="?delete='.htmlspecialchars($row['account_id']).'" onClick="javascript:confirmDeleteCard('.htmlspecialchars($row['account_id'], ENT_QUOTES, 'UTF-8').');"><FONT SIZE=1>[DELETE]</font></a></div></td>
					</tr>';
		
			}
	  ?>
	</table>
	<p>&nbsp;</p>
    <br /><br />
    <p>
      <label>
       <input name="button2" type="button" onClick="javascript:confirmDeleteSelected();" class="style2" id="button2" value="Delete Selected accounts">
      </label>
      <?php echo '</form>'; ?>    </p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
</div>
</body>
</html>

</body>
</html>

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
if(isset($_GET['page']) && !is_numeric($_GET['page'])){
die("hackin attemt");
}
$uid = mysql_real_escape_string($_SESSION['member']);
// get balance
$result = mysql_query("SELECT balance FROM users WHERE username='$uid'");
$bals = mysql_fetch_assoc($result);
$balance = $bals["balance"];

?>




<html>
<head><link rel="stylesheet" href="style.css" type="text/css" media="screen" />
<head><link rel="stylesheet" href="css2/style.css" type="text/css" media="screen" />



</script>
<script type="text/javascript">
  setTimeout('location.replace("/index.php?act=logout")', 900000);
</script> 
<style type="text/css">
a {
text-decoration: none;
}
</style>

<link href="favicon.ico" rel="icon" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title>Buy Accounts</title>
<script type="text/javascript">
  setTimeout('location.replace("/index.php?act=logout")', 900000);
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
<script type="text/javascript" src="script.js"></script>
</head>
<body>

<script type="text/javascript">
function check(id)
{   var type = $("#shop"+id).attr('type')
	$("#shop"+id).html('Checking').show();
	$.ajax({
	type: 		'GET',
	url: 		'checkeri.php?id='+id+'&type='+type,
	success:	function(data)
	{
		$("#shop"+id).html(data).show();
	}});
}
</script>
</div>
<div id="wrap" align="center">
  <div align="center">
<? include 'navbar.php'; ?>
     <p>&nbsp;</p>
<script language="JavaScript" type="text/javascript">
<!--
function toggle(source) {
  checkboxes = document.getElementsByName('acc[]');
  for each(var checkbox in checkboxes)
    checkbox.checked = source.checked;
}
-->
</script> 
	
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table width="760" border="0">
	<tr rowspan="1">
		<br />
      <tr>
        <td class="thon" scope="col"><div align="center"><strong>Account Type</strong></div></td>
        <td class="thon" scope="col"><div align="center"><strong>Country</strong></div></td>
        <td class="thon" scope="col"><div align="center"><strong>Information</strong></div></td>
		<td rowspan="3">
		<br />
          <?php echo '<form name="search" method="GET" action="buyaccounts.php">'; ?> 
            <label>
              <input name="btnSearch" type="submit" class="myButton" id="btnSearch" value="Search">
              </label>
         <!-- </form> -->
        </td>
		</tr >
       </tr>
	  
	
	    
      
	  <tr>
		<td class="thon1">
			<div align="center">
				<select name="acctypelst" class="thon1" id="acctypelst">
					<option value="Any">Any</option>
					<?
						$sql = mysql_query("SELECT DISTINCT acctype FROM accounts where sold=0");
							while($row = mysql_fetch_assoc($sql))
							{
								if($row['acctype'] == "")
								{
									echo '<option value="'.htmlspecialchars($row['acctypey'], ENT_QUOTES, 'UTF-8').'">unknOwn</option>'; 
								}
								else
								{
									echo '<option value="'.htmlspecialchars($row['acctype'], ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars($row['acctype'], ENT_QUOTES, 'UTF-8').'</option>'; 
								}
							}
					?>
				</select>
			</div>
		</td>
		<td class="thon1">
			<div align="center">
				<select name="acccountrylst" class="thon1" id="acccountrylst">
					<option value="Any">Any</option>
					<?
						$sql = mysql_query("SELECT DISTINCT country FROM accounts where sold=0");
							while($row = mysql_fetch_assoc($sql))
							{
								if($row['country'] == "")
								{
									echo '<option value="'.htmlspecialchars($row['country'], ENT_QUOTES, 'UTF-8').'">unknOwn</option>'; 
								}
								else
								{
									echo '<option value="'.htmlspecialchars($row['country'], ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars($row['country'], ENT_QUOTES, 'UTF-8').'</option>'; 
								}
							}
					?>
				</select>
			</div>
		</td>
		<td class="thon1">
			<div align=center><strong>CHOOSE TYPE</strong></div>
		</td>
	  </tr>
		<td></td>
		<td class="style2"><div align="center"></div></td>
	</table>
	
       
	<p align="left">&nbsp; </p>
	<?
		if(!empty($_GET['id']))
		{
			$uid = mysql_real_escape_string($_GET['id']);
			$usrid = mysql_real_escape_string($_SESSION['member']);
			$price = mysql_query("select price from accounts where account_id='$uid'");
			if($price)
			{
				$pr = mysql_fetch_assoc($price);
			}
			$AccPrice = $pr["price"] ;
			$AccPrice = mysql_real_escape_string($AccPrice);
			if($balance >= $AccPrice)
			{
				$result2 = mysql_query("SELECT sold FROM accounts WHERE account_id='$uid'") or die('error');
				$soldbool = mysql_fetch_assoc($result2);
				if($soldbool["sold"] == '0')
				{
					mysql_query("update accounts set sold=1 where account_id='$uid'");
					mysql_query("update accounts set username='$usrid' where account_id='$uid'");
					mysql_query("update users set balance=(balance - '$AccPrice') where username='$usrid'");
					mysql_query("update accounts set date_purchased=now() where account_id='$uid'");
					echo ' <div class="notification download">
                           <span></span>
                           <div class="text">
                           <p class="text"><br /><strong>Done!</strong><br /><a href="myaccounts.php"><font color="#000000"><b>Click Here to view your Bought Accounts</b></a></p></div>
                           </div>	   
						   ';
				}
				else
				{
					echo '<font color="#FF0000"> alrady sold ! </font>';
				}
			}
			else
			{
				echo '     <div class="notification error">
                           <span></span>
                           <div class="text">
                           <p class="text"><br /><strong><font color="#000000">Your balance is not enough to pay this stuff!</font></strong><br /><a href="myaccounts.php"><font color="#000000"><b>Please refill your balance <a href="addfunds.php"><font color="#FF0000"><b> CLICK HERE </b></font> </a> </font></b></a></p></div>
                           </div>';
			}
		}
	?>
    
    <p class="thon3s" align="center"><strong>Total ACCOUNTS: ( <?php $result = mysql_query("SELECT * FROM accounts WHERE sold=0"); echo mysql_num_rows($result); ?> )</strong></p>

	
	  <table width="799" >
      <tr>
        <td class="thon" scope="col"><div align="center"><strong>Account</strong></div></td>
        <td class="thon" scope="col"><div align="center"><strong>Country</strong></div></td>
        <td class="thon" scope="col"><div align="center"><strong>Info</strong></div></td>
        <td class="thon" scope="col"><div align="center"><strong>Login</strong></div></td>
        <td class="thon" scope="col"><div align="center"><strong>Pass</strong></div></td>
        <td class="thon" scope="col"><div align="center"><strong>Price</strong></div></td>
        <td class="thon" scope="col"><div align="center"><strong>Buy</strong></div></td>
		<td class="formstyle"><div align="center"><font color="#FF0000"><strong><strong>Check</strong></div></td>
      </tr>
	<?
		$Nsearch = '1';
		if(!empty($_GET['acccountrylst']) OR !empty($_GET['acctypelst'])){
			if($_GET['acccountrylst']=='Any' AND $_GET['acctypelst']=='Any'){
				$Nsearch = '1';
			}else{
				$Nsearch = '0';
			}
		}
		if($Nsearch == '1'){
			$sql=mysql_query("select * from accounts where sold=0 ORDER BY RAND() LIMIT 100") or die("error");
			while($row = mysql_fetch_array($sql)){
				echo '<tr>
						<td class="formstyle"><div align="center"><strong>'.htmlspecialchars($row["acctype"], ENT_QUOTES, 'UTF-8').'</strong></div></td>
						<td class="formstyle"><div align="center"><strong>'.htmlspecialchars($row["country"], ENT_QUOTES, 'UTF-8').'</strong></div></td>
						<td class="formstyle"><div align="center"><strong>'.htmlspecialchars($row["info"], ENT_QUOTES, 'UTF-8').'</strong></div></td>
						<td class="formstyle"><div align="center"><strong>'.substr($row["login"],0,2).'****</strong></div></td>
						<td class="formstyle"><div align="center"><strong>******</strong></div></td>
						<td class="formstyle"><div align="center"><strong>'.htmlspecialchars($row["price"], ENT_QUOTES, 'UTF-8').'</strong></div></td>
						<td width="51" class="formstyle"><div align="center"><label><a href="?id='.htmlspecialchars($row['account_id'], ENT_QUOTES, 'UTF-8').'"><b>Buy</b></a></label></div></td>';
						
  $position = strpos(strtolower($row["acctype"]), "rdp");
  $position2 = strpos(strtolower($row["acctype"]), "shell");
  $position3 = strpos(strtolower($row["acctype"]), "cpanel");
  $position5 = strpos(strtolower($row["acctype"]), "mailer");

if ($position !== false) {
						echo '
						<td class="formstyle"><span id="shop'.$row["account_id"].'" type="rdp"><a style="cursor: pointer;" onclick="javascript:check('.$row["account_id"].');"><b><font color="red">Check</font></b></a></span></td>
						';						
      }  elseif($position2 !== false) {
						echo '
						<td class="formstyle"><span id="shop'.$row["account_id"].'" type="shell"><a style="cursor: pointer;" onclick="javascript:check('.$row["account_id"].');"><b><font color="red">Check</font></b></a></span></td>
						';		  
	  }elseif($position3 !== false) {
						echo '
						<td class="formstyle"><span id="shop'.$row["account_id"].'" type="cpanel"><a style="cursor: pointer;" onclick="javascript:check('.$row["account_id"].');"><b><font color="red">Check</font></b></a></span></td>
						';		  
	  } elseif($position5 !== false) {
						echo '
						<td class="formstyle"><span id="shop'.$row["account_id"].'" type="mailer"><a style="cursor: pointer;" onclick="javascript:check('.$row["account_id"].');"><b><font color="red">Check</font></b></a></span></td>
						';		  
	  }  else 
      {
						echo '
						<td width="51" class="formstyle"></td>
						';
      }						
						
						echo '
					 </tr>';
				
			}
		}
		if($Nsearch == '0'){
			$accTypeZ = mysql_real_escape_string($_GET['acctypelst']);
			$accCounZ = mysql_real_escape_string($_GET['acccountrylst']);
			
			if($accTypeZ != 'Any'){
				
				$request = "select * from accounts where sold=0 AND acctype = '$accTypeZ' LIMIT 150";
			}
			if($accCounZ != 'Any'){
				$request = "select * from accounts where sold=0 AND country = '$accCounZ' LIMIT 150";
			}
			if($accTypeZ != 'Any' AND $accCounZ != 'Any'){
				$request = "select * from accounts where sold=0 AND country = '$accCounZ' AND acctype = '$accTypeZ' LIMIT 150";
			}
			$sql=mysql_query($request) or die("error");
			while($row = mysql_fetch_array($sql)){
				echo '<tr>
						<td class="formstyle"><div align="center"><strong>'.htmlspecialchars($row["acctype"], ENT_QUOTES, 'UTF-8').'</strong></div></td>
						<td class="formstyle"><div align="center"><strong>'.htmlspecialchars($row["country"], ENT_QUOTES, 'UTF-8').'</strong></div></td>
						<td class="formstyle"><div align="center"><strong>'.htmlspecialchars($row["info"], ENT_QUOTES, 'UTF-8').'</strong></div></td>
						<td class="formstyle"><div align="center"><strong>'.substr($row["login"],0,2).'****</strong></div></td>
						<td class="formstyle"><div align="center"><strong>******</strong></div></td>
						<td class="formstyle"><div align="center"><strong>'.htmlspecialchars($row["price"], ENT_QUOTES, 'UTF-8').'</strong></div></td>
						<td width="51" class="formstyle"><div align="center"><label><a href="?id='.htmlspecialchars($row['account_id'], ENT_QUOTES, 'UTF-8').'"><b>Buy</b></a></label></div></td>';
						
  $position = strpos(strtolower($row["acctype"]), "rdp");
  $position2 = strpos(strtolower($row["acctype"]), "shell");
  $position3 = strpos(strtolower($row["acctype"]), "cpanel");
  $position5 = strpos(strtolower($row["acctype"]), "mailer");

  if ($position !== false) {
						echo '
						<td class="formstyle"><span id="shop'.$row["account_id"].'" type="rdp"><a style="cursor: pointer;" onclick="javascript:check('.$row["account_id"].');"><b><font color="red">Check</font></b></a></span></td>
						';						
      } elseif($position2 !== false) {
						echo '
						<td class="formstyle"><span id="shop'.$row["account_id"].'" type="shell"><a style="cursor: pointer;" onclick="javascript:check('.$row["account_id"].');"><b><font color="red">Check</font></b></a></span></td>
						';		  
	  }elseif($position3 !== false) {
						echo '
						<td class="formstyle"><span id="shop'.$row["account_id"].'" type="cpanel"><a style="cursor: pointer;" onclick="javascript:check('.$row["account_id"].');"><b><font color="red">Check</font></b></a></span></td>
						';		  
	  } elseif($position5 !== false) {
						echo '
						<td class="formstyle"><span id="shop'.$row["account_id"].'" type="mailer"><a style="cursor: pointer;" onclick="javascript:check('.$row["account_id"].');"><b><font color="red">Check</font></b></a></span></td>
						';		  
	  }  else 
      {
						echo '
						<td width="51" class="formstyle"></td>
						';
      }			
	  
						echo '
					 </tr>';
				
			}
		}
		
	?>
	  </table>
	  
    
    &nbsp;  </p>
  </div>
</div>
</body>
</html>

</body>
</html>

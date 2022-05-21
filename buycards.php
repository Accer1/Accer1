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
// get balance
$uid = mysql_real_escape_string($_SESSION['member']);
$result = mysql_query("SELECT balance FROM users WHERE username='$uid'");
$bals = mysql_fetch_row($result);
$balance = $bals[0];

if(!isset($_POST['txtBin']) || $_POST['txtBin'] == "ANY") // bin, lets charge for bin search
{
	$txtBin1 = "ANY";		
}
if(!isset($_POST['txtCity']) || $_POST['txtCity'] == "ANY")
{
	$txtCity1 = "ANY";
}
if(!isset($_POST['txtZip']) || $_POST['txtZip'] == "ANY")
{
	$txtZip1 = "ANY";
}

?>

<html>
<head><link rel="stylesheet" href="style.css" type="text/css" media="screen" />


<script language="JavaScript" type="text/javascript">
<!--
function searchCCType(type)
{
  if(type == "visa") document.getElementById('txtBin').value = 4;
  if(type == "mc") document.getElementById('txtBin').value = 5;
  if(type == "amex") document.getElementById('txtBin').value = 3;
  if(type == "discover") document.getElementById('txtBin').value = 6;
}

function toggle(source) {
  checkboxes = document.getElementsByName('cards[]');
  for each(var checkbox in checkboxes)
    checkbox.checked = source.checked;
}
-->
</script>
<script type="text/javascript">
  setTimeout('location.replace("/index.php?act=logout")', 900000);
</script> 

<link href="favicon.ico" rel="icon" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title><?php echo htmlspecialchars($SHOP['maintitle'], ENT_QUOTES, 'UTF-8'); ?></title>


</head>
<body>
<div align="center"><a href="./index.php"><img src="images/logo.png" width="800" height="80" border="0"></a><br/>
</div>
<div id="wrap" align="center">
  <div align="center">
<? include 'navbar.php';?>
    </p>
    <p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p><font color="#41A317"><strong><u>Search Cards</u></strong></font></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table width="760" border="0">
      <tr>
        <td width="76" height="20" class="formstyle"><div align="center"><strong>BIN</strong></div></td>
        <td width="126" class="formstyle"><div align="center"><strong>COUNTRY</strong></div></td>
        <td width="123" class="formstyle"><div align="center"><strong>STATE</strong></div></td>
        <td width="123" class="formstyle"><div align="center"><strong>CITY</strong></div></td>
        <td width="123" class="formstyle"><div align="center"><strong>ZIP</strong></div></td>
        <td width="149" rowspan="2"><div align="center">
          <?php echo '<form name="search" method="post" action="buycards.php">'; ?>
            <label>
              <input name="btnSearch" type="submit" class="formstyle" id="btnSearch" value="Search">
              </label>
         <!-- </form> -->
        </div></td>
      </tr>
      <tr>
        <td><label>
          <input name="txtBin" type="text" class="formstyle" id="txtBin" value="ANY" size="12" maxlength="6">
        </label></td>
        <td><label>
          <select name="lstCountry" class="formstyle" id="lstCountry">
          
          <?php
		  	if(isset($_POST['lstCountry']))
			{
				echo '<option value="'.htmlspecialchars($_POST['lstCountry'], ENT_QUOTES, 'UTF-8').'" selected>'.htmlspecialchars($_POST['lstCountry'], ENT_QUOTES, 'UTF-8').'</option>';
			}
			else
			{
            	echo '<option value="ANY" selected>ANY</option>';
			}
	
			
			// Displays available cards in country
			
			$result = mysql_query("SELECT DISTINCT country FROM cards where sold=0");
			
			while($row = mysql_fetch_assoc($result))
			{
				if($row['country'] == "")
				{
					echo '<option value="'.htmlspecialchars($row['country'], ENT_QUOTES, 'UTF-8').'">Mixed EU Base</option>'; // for cards without country
				}
				else
				{
            		echo '<option value="'.htmlspecialchars($row['country'], ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars($row['country'], ENT_QUOTES, 'UTF-8').'</option>'; // cards wth country default
				}
			}
            
			?>
          </select>
        </label></td>
        <td><label>
          <input name="txtState" type="text" class="formstyle" id="txtState" value="ANY" size="20">
        </label></td>
        <td><label>
          <input name="txtCity" type="text" class="formstyle" id="txtCity" value="ANY" size="20">
        </label></td>
        <td><label>
          <input name="txtZip" type="text" class="formstyle" id="txtZip" value="ANY" size="20">
        </label></td>
      </tr>
      <tr>
        <td colspan="3"><span class="style8">Search BIN (+$0.50):</span> <span class="link style8"><a style="text-decoration:none; color:#0000FF;" href="javascript:searchCCType('visa')">Visa</a> | <a style="text-decoration:none; color:#0000FF;" href="javascript:searchCCType('mc')">Mastercard</a> | <a style="text-decoration:none; color:#0000FF;" href="javascript:searchCCType('amex')">Amex</a> | <a style="text-decoration:none; color:#0000FF;" href="javascript:searchCCType('discover')">Discover</a></span><br></td>
        <td class="style8"><div align="center">Search CITY (+$0.20)</div></td>
        <td class="style8"><div align="center">Search ZIP (+$0.30)</div></td>
        <td><div align="right">
          <label>
          <input type="checkbox" name="boxDob" id="boxDob">
          </label>
          <?php echo '</form>'; ?>
        <span class="style8">with DoB</span> </div></td>
      </tr>
    </table>
    <p align="left">&nbsp; </p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p><font color="#41A317"><strong><u>Cards (total cards: <?php $result = mysql_query("SELECT * FROM cards WHERE sold=0"); echo mysql_num_rows($result); ?>)</u></strong></font></p>
    <p>&nbsp;</p>
    <p class="rightalign" id="validrates">CARD VALID RATES: <span class="normalvalids">USA:</span> <span class="greendotted"><?php $rs2 = mysql_query("SELECT validrateus FROM settings"); $cols = mysql_fetch_row($rs2); echo htmlspecialchars($cols[0], ENT_QUOTES, 'UTF-8'); ?>%</span><span class="normalvalids"> EU: </span><span class="greendotted">
	<?php $rs2 = mysql_query("SELECT validrateeu FROM settings"); 
		$cols = mysql_fetch_row($rs2); 
		echo htmlspecialchars($cols[0], ENT_QUOTES, 'UTF-8'); 
		?>%</span></p>
    <div style="clear: both;"></div>
    <table width="799" border="0">
      <tr>
        <td width="123" class="formstyle"><div align="center"><strong>CARD NUMBER</strong></div></td>
        <td width="87" class="formstyle"><div align="center"><strong>LAST NAME</strong></div></td>
        <td width="108" class="formstyle"><div align="center"><strong>COUNTRY</strong></div></td>
        <td width="88" class="formstyle"><div align="center"><strong>STATE</strong></div></td>
        <td width="78" class="formstyle"><div align="center"><strong>CITY</strong></div></td>
        <td width="41" class="formstyle"><div align="center"><strong>SSN/DL</strong></div></td>
        <td width="71" class="formstyle"><div align="center"><strong>ZIP</strong></div></td>
        <td width="46" class="formstyle"><div align="center"><strong>DOB</strong></div></td>
        <td width="54" class="formstyle"><div align="center"><strong>PRICE</strong></div></td>
        <td width="39" class="formstyle"><div align="center"><label><input class="formstyle" type="checkbox" name="selectall" onClick="toggle(this);" value=""></label></div></td>
      </tr>
      
      	<?php
	  	// LIST CARDS
		
		$results = 50; // results per page
		
		echo '<form name="purchase" method="post" action="cart.php">';
      
	  	if(isset($_POST['btnSearch']) || isset($_GET['c']) && strlen($_GET['c']) > 1) // Search SPECIFIC Cards
	  	{
			// Protect against injection
	  		$bin     = mysql_real_escape_string($_POST['txtBin']);
			$country = mysql_real_escape_string($_POST['lstCountry']);
			$state   = mysql_real_escape_string($_POST['txtState']);
			$city    = mysql_real_escape_string($_POST['txtCity']);
			$zip     = mysql_real_escape_string($_POST['txtZip']);
			$boxdob  = mysql_real_escape_string($_POST['boxDob']);
			
			if(isset($_GET['c']))
			{
				$country = mysql_real_escape_string($_GET['c']);
			}
			
			// Sort search arugments
			if(!is_numeric($bin) || !isset($_POST['txtBin']) || preg_match("/(ANY|NONE)/", $bin)) { $bin = '%'; }
			
			if(!isset($_POST['lstCountry']) || preg_match("/(ANY|NONE)/", $country)) { if(!isset($_GET['c'])) { $country = '%'; } }
			
			if(!isset($_POST['txtState']) || preg_match("/(ANY|NONE)/", $state)) { $state = '%'; }
			if(!isset($_POST['txtCity']) || preg_match("/(ANY|NONE)/", $city)) { $city = '%'; }
			if(!is_numeric($zip) || !isset($_POST['txtZip']) || preg_match("/(ANY|NONE)/", $zip)) { $zip = '%'; }
			
			if(isset($_POST['boxDob'])) // searched DOB only
			{
				$dobVal = '%1%';
			}
			else
			{
				$dobVal = '%';
			}
			
			// Page calculation
			$res = mysql_query("SELECT * FROM cards WHERE sold=0 AND number LIKE '$bin%' AND country LIKE '$country' AND state LIKE '%$state%' AND city LIKE '%$city%' AND zip LIKE '%$zip%' AND dob LIKE '$dobVal'");
			$total_records = mysql_num_rows($res); // total number of rows
			$total_pages = ceil($total_records / $results); // calculate total number of pages
			
			$page = mysql_real_escape_string($_GET['page']);
			if(!isset($_GET['page']) || !is_numeric($_GET['page'])) { $page = 1; } // default page
			$start_from = ($page - 1) * $results;
			$start_from = mysql_real_escape_string($start_from);
			$results = mysql_real_escape_string($results);
			
			// Query the database
			$result = mysql_query("SELECT * FROM cards WHERE sold=0 AND number LIKE '$bin%' AND country LIKE '$country' AND state LIKE '%$state%' AND city LIKE '%$city%' AND zip LIKE '%$zip%' AND dob LIKE '$dobVal' ORDER BY RAND() LIMIT $start_from, $results");
			
			while($row = mysql_fetch_assoc($result)) // for each result
			{
				if($row['dob'] == "NULL" || $row['dob'] == "NONE" || $row['dob'] == "" || strlen($row['dob']) < 4)
				{
					$dob = "NO";
				}
				else
				{
					$dob = "YES";
				}
				
				$ccnumber = substr($row['number'], 0, 6);
				$ccnumber .= '********** ';
				
				$pricenew = $row['price']; // easyier to access
				$totalextra = 0.00;
				
				// Adjust prices based on what the user's search arguments where
				if($_POST['txtBin'] != "ANY") // bin, lets charge for bin search
				{
					$totalextra += 0.50;
					//$pricenew += 0.50;		
				}
				if($_POST['txtCity'] != "ANY")
				{
					$totalextra += 0.20;
					//$pricenew += 0.20;
				}
				if($_POST['txtZip'] != "ANY")
				{
					$totalextra += 0.30;
					//$pricenew += 0.30;
				}
				
				// DoB 			
				if($dob == "YES")
				{
					//$pricenew += 2.00;
				}
				
				$totalextra = number_format($totalextra, 2);
				$pricenew = number_format($pricenew, 2);
				
				if($row['ssn'] == "NONE" || $row['ssn'] == "" || $row['ssn'] == "NULL")
				{
					$ssn = "NO";
				}
				else
				{
					$ssn = "YES";
				}
				
				echo '<tr>'; // new table row
        		echo '<td width="140" class="formstyle"><div align="center"><strong>'.htmlspecialchars($ccnumber, ENT_QUOTES, 'UTF-8').'</strong></div></td>';
        		echo '<td width="100" class="formstyle"><div align="center">'.htmlspecialchars($row['lastname'], ENT_QUOTES, 'UTF-8').'</div></td>';
        		echo '<td width="120" class="formstyle"><div align="center">'.htmlspecialchars($row['country'], ENT_QUOTES, 'UTF-8').'</div></td>';
        		echo '<td width="100" class="formstyle"><div align="center">'.htmlspecialchars($row['state'], ENT_QUOTES, 'UTF-8').'</div></td>';
        		echo '<td width="90" class="formstyle"><div align="center">'.htmlspecialchars($row['city'], ENT_QUOTES, 'UTF-8').'</div></td>';
				echo '<td width="41" class="formstyle"><div align="center">'.htmlspecialchars($ssn, ENT_QUOTES, 'UTF-8').'</div></td>';
        		echo '<td width="65" class="formstyle"><div align="center">'.htmlspecialchars($row['zip'], ENT_QUOTES, 'UTF-8').'</div></td>';
				echo '<td width="42" class="formstyle"><div align="center">'.htmlspecialchars($dob, ENT_QUOTES, 'UTF-8').'</div></td>';
				
				if($totalextra == 0.00)
        			echo '<td width="42" class="formstyle"><div align="center"><strong>$'.htmlspecialchars($pricenew, ENT_QUOTES, 'UTF-8').'</strong></div></td>';
				else
					echo '<td width="42" class="formstyle"><div align="center"><strong>$'.htmlspecialchars($pricenew, ENT_QUOTES, 'UTF-8').' + $'.htmlspecialchars($totalextra, ENT_QUOTES, 'UTF-8').'</strong></div></td>';
				
        		echo '<td width="51" class="formstyle"><div align="center"><label><input class="formstyle" type="checkbox" name="cards[]" value="'.htmlspecialchars($row['card_id'], ENT_QUOTES, 'UTF-8').'"></label></div></td>';
      			echo '</tr>';
			}
			
	  	}
		else // List random cards
		{		
			// Calculate total rows and pages
			$result = mysql_query("SELECT * FROM cards WHERE sold=0");
			
			$total_records = mysql_num_rows($result); // total number of rows
			$total_pages = ceil($total_records / $results); // calculate total number of pages
			
			// Return rows
			$page = mysql_real_escape_string($_GET['page']);
			if(!isset($_GET['page']) || !is_numeric($_GET['page'])) { $page = 1; } // default page
			$start_from = ($page - 1) * $results;
			$start_from = mysql_real_escape_string($start_from);
			$results = mysql_real_escape_string($results);
			// Query database
			$resultrow = mysql_query("SELECT * FROM cards WHERE sold=0 ORDER BY RAND() LIMIT $start_from, $results");
			
			
			while($row = mysql_fetch_assoc($resultrow)) // for each result
			{		
				if($row['dob'] == "NULL" || $row['dob'] == "NONE" || $row['dob'] == "" || preg_match("/(2009|2008)/", $row['dob']) || strlen($row['dob']) < 4)
				{
					$dob = "NO";
				}
				else
				{
					$dob = "YES";
				}
				
				$ccnumber = substr($row['number'], 0, 6);
				$ccnumber .= '********** ';
				
				$pricenew = $row['price'];
				
				if($dob == "YES") // DoB cards +2
				{
					//$pricenew += 2.00;
					//$pricenew = number_format($pricenew, 2);
				}
				
				if($row['ssn'] == "NONE" || $row['ssn'] == "" || $row['ssn'] == "NULL")
				{
					$ssn = "NO";
				}
				else
				{
					$ssn = "YES";
				}
				
				echo '<tr>'; // new table row
        		echo '<td width="140" class="formstyle"><div align="center"><strong>'.htmlspecialchars($ccnumber, ENT_QUOTES, 'UTF-8').'</strong></div></td>';
        		echo '<td width="100" class="formstyle"><div align="center">'.htmlspecialchars($row['lastname'], ENT_QUOTES, 'UTF-8').'</div></td>';
        		echo '<td width="120" class="formstyle"><div align="center">'.htmlspecialchars($row['country'], ENT_QUOTES, 'UTF-8').'</div></td>';
        		echo '<td width="100" class="formstyle"><div align="center">'.htmlspecialchars($row['state'], ENT_QUOTES, 'UTF-8').'</div></td>';
        		echo '<td width="90" class="formstyle"><div align="center">'.htmlspecialchars($row['city'], ENT_QUOTES, 'UTF-8').'</div></td>';
				echo '<td width="41" class="formstyle"><div align="center">'.htmlspecialchars($ssn, ENT_QUOTES, 'UTF-8').'</div></td>';
        		echo '<td width="65" class="formstyle"><div align="center">'.htmlspecialchars($row['zip'], ENT_QUOTES, 'UTF-8').'</div></td>';
				echo '<td width="42" class="formstyle"><div align="center">'.htmlspecialchars($dob, ENT_QUOTES, 'UTF-8').'</div></td>';
        		echo '<td width="42" class="formstyle"><div align="center"><strong>$'.htmlspecialchars($pricenew, ENT_QUOTES, 'UTF-8').'</strong></div></td>';
        		echo '<td width="51" class="formstyle"><div align="center"><label><input class="formstyle" type="checkbox" name="cards[]" value="'.htmlspecialchars($row['card_id'], ENT_QUOTES, 'UTF-8').'"></label></div></td>';
      			echo '</tr>';
			}
				
		}
	  
	  	?>
    </table>
    <p>&nbsp;</p>
    <p>
	<?php 
	
			// ADD PURCHASE BUTTONS
		echo '<tr>'; // new table row
        echo '<td colspan="9" class="formstyle"><label><input name="btnPurchase" type="submit" class="style4" id="btnPurchase" value="           Add Selected To Cart           "></label></td>';
      	echo '</tr>';
		
		// finish form
		echo '<input type="hidden" name="txtBin" value="'.htmlspecialchars(strip_tags($txtBin1), ENT_QUOTES, 'UTF-8').'"/>';
		echo '<input type="hidden" name="txtZip" value="'.htmlspecialchars(strip_tags($txtZip1), ENT_QUOTES, 'UTF-8').'"/>';
		echo '<input type="hidden" name="txtCity" value="'.htmlspecialchars(strip_tags($txtCity1), ENT_QUOTES, 'UTF-8').'"/>';
		echo '</form>';
	
	?>
	&nbsp;</p>
    <p>&nbsp;</p>
    <p align="right"><strong>PAGE</strong>: 
	<?php 

		$country = mysql_real_escape_string($country);
		
		for ($i=1; $i<=$total_pages; $i++) 
				   { 
				   		if($total_pages > 10 && $i == 9)
						{
							echo ' | <a href="buycards.php?page='.$i.'&c='.htmlspecialchars($country, ENT_QUOTES, 'UTF-8').'">-></a>'; 
							echo ' ... <a href="buycards.php?page='.$i.'&c='.htmlspecialchars($country, ENT_QUOTES, 'UTF-8').'">'.$total_pages.'</a>';
							break;	
						}
            	   		echo ' | <a href="buycards.php?page='.$i.'&c='.htmlspecialchars($country, ENT_QUOTES, 'UTF-8').'">'.$i.'</a>'; 
				   }; 
		?>
</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
</div>
</body>
</html>

</body>
</html>
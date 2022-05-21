<?php

include("./includes/db.php");
include("./includes/config.php");
include("./includes/header.php");

$cardAlreadySold = 0;
$siteMessage = 0;

// CHECK STORE ONLINE
$result = mysql_query("SELECT shop_online FROM settings LIMIT 0,1");
$cols   = mysql_fetch_row($result);
if(!$cols[0])
{
	header("location: offline.php");
	die;
}

$uid = mysql_real_escape_string($_SESSION['member']);

// remove cards if set
if(isset($_POST['btnRemove']))
{
	// Add cards to cart
	while(list($key, $val) = @each($_POST['cardsDelete']))
	{
		$cardid = mysql_real_escape_string($val);
		
		mysql_query("DELETE FROM cart WHERE card_id='$cardid' AND username='$uid'");
	}	
	header("location: cart.php");
	die;
}

// get balance
$result = mysql_query("SELECT balance FROM users WHERE username='$uid'");
$bals = mysql_fetch_row($result);
$mainBalance = $bals[0];

// PURCHASE CODE

if(isset($_POST['btnPurchase']))// check if form was submitted
{
	// Calculate cart items and price
	$result = mysql_query("SELECT * FROM cart WHERE username='$uid'");
	$cartNumItems = mysql_num_rows($result);

	$cartAmount = 0.00; // default value
	
	if($cartNumItems > 0) // if there are items in the cart.. do something
	{
		while($row = mysql_fetch_assoc($result)) // for each item in cart
		{
			$cardid = mysql_real_escape_string($row['card_id']);
			$result2 = mysql_query("SELECT price, dob, sold FROM cards WHERE card_id='$cardid'"); // query for price
			$pricecols = mysql_fetch_row($result2);
			$thePrice = $pricecols[0]; // stores the cart item price
			
			if($pricecols[2] == 1) // card sold!
			{
				mysql_query("DELETE FROM cart WHERE card_id='$cardid' AND username='$uid'");
				$cardAlreadySold++;	
				continue;
			}
			
			if($pricecols[1] == "NULL" || $pricecols[1] == "NONE" || $pricecols[1] == "") // add the $2.00 DoB fee
			{
				$dobnew = "NO";
			}
			else
			{
				$dobnew = "YES";
				//$thePrice += 2.00;
			}
			
			if($row['charge_bin']) // bin, lets charge for bin search
			{
				$thePrice += 0.50;		
			}
			if($row['charge_city'])
			{
				$thePrice += 0.20;
			}
			if($row['charge_zip'])
			{
				$thePrice += 0.30;
			}
			$thePrice = mysql_real_escape_string($thePrice);
			mysql_query("UPDATE cards set total_price='$thePrice' WHERE card_id='$cardid'");
			
			$cartAmount += $thePrice; // add to the price
			$cartAmount = number_format($cartAmount, 2); // decimal price
		}	
		
		// prices calculated
		
		if($cartAmount > $mainBalance) // user does not have enough balance.
		{
			$siteMessage = '<span class="redbold">YOU DO NOT HAVE ENOUGH BALANCE FOR THIS PURCHASE! PLEASE ADD FUNDS!</span>';	
		}
		else // process the purchase
		{
			$newBalance = $mainBalance - $cartAmount; // new balance
			$newBalance = number_format($newBalance, 2);
			$newBalance = mysql_real_escape_string($newBalance);
			$cartNumItems = mysql_real_escape_string($cartNumItems);
			mysql_query("UPDATE users SET balance='$newBalance', amount_purchased=(amount_purchased + $cartNumItems) WHERE username='$uid'"); // update balance IMPORTANT!
			
			// Balance is done. Just remove cards from cart, mark as sold in database, and create purchase info, also add to users cards.
			
			$result = mysql_query("SELECT * FROM cart WHERE username='$uid'");
			
			while($row = mysql_fetch_assoc($result)) // add each card to users profile
			{
				$cardidd = $row['card_id'];
				$cardidd = mysql_real_escape_string($cardidd);
				mysql_query("UPDATE cards SET sold=1, username='$uid', valid_user='CHECK', date_purchased=now() WHERE card_id='$cardidd'");	// add card to users "my cards"
			}
			$cartAmount = mysql_real_escape_string($cartAmount);
			$mainBalance = mysql_real_escape_string($mainBalance);
			$newBalance = mysql_real_escape_string($newBalance);
			mysql_query("INSERT INTO purchases(amount,username,date,before_balance,after_balance) VALUES('$cartAmount', '$uid', now(), '$mainBalance', '$newBalance')"); // insert purchase info
			mysql_query("DELETE FROM cart WHERE username='$uid'"); // removes from cart
		}
	}
	else
	{
		header("location: cart.php");
		die;	
	}
}
else // no form was submitted
{
	header("location: cart.php");
	die;
}
$balance=$mainBalance;
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
<div align="center"><a href="./index.php"><img src="images/logo.png" width="800" height="80" border="0"></a><br/>
</div>

<div id="wrap" align="center">
  <div align="center">
<? include 'navbar.php';?>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p><?php  
	
		if($siteMessage) // not enough balance
		{
			echo $siteMessage;
		}
		else // purchase complete!
		{
			if($cardAlreadySold) // one or more cards where already sold!
			{
				echo '<span class="redbold">'.htmlspecialchars($cardAlreadySold, ENT_QUOTES, 'UTF-8').' Cards where already purchased! We have removed these cards from your purchase!</span>';
			}	
			
			
		}
	
	 ?>&nbsp;</p>
    <p><?php
    
		if(!$siteMessage)
		{
			echo '<strong>PURCHASE COMPLETE!</strong>';
		}
	
	?>&nbsp;</p>
    <p>&nbsp;</p>
    <?php
	
	if(!$siteMessage)
	{
		echo '<p class="style2">Your purchase was successfull! Please goto "My Cards" to view your cards, Cards will be checked for valid! If invalid you will be refunded!</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p><strong><a href="mycards.php">CLICK HERE TO VIEW YOUR CARDS</a></strong></p>';
	
	}
	
	?>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
</div>
</body>
</html>

</body>
</html>

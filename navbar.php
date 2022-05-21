<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>csh0p.su</title>

<link rel="stylesheet" href="styles/reset.css" />
<link rel="stylesheet" href="styles/text.css" />
<link rel="stylesheet" href="styles/960_fluid.css" />
<link rel="stylesheet" href="styles/main.css" />
<link rel="stylesheet" href="styles/bar_nav.css" />
<link rel="stylesheet" href="styles/side_nav.css" />
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/base/jquery-ui.css" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>

<script type="text/javascript" src="scripts/sherpa_ui.js"></script>

</head>

<body>
	<div id="wrapper" class="container_16">
		<div id="top_nav" class="nav_down bar_nav grid_16 round_all>
		<a href="#" class="minimize round_bottom"></a>
			<ul class="round_all clearfix">
				<li><a class="round_left" href="index.php">
					<img src="images/icons/grey/Home.png">
					Home</a>
				</li> 				
				<li><a href="buyaccounts.php">
					<img src="images/icons/grey/book.png">
					Buy Stuff</a>
				</li>
				<li><a href="contact.php">
					<img src="images/icons/grey/Mail.png">
					Support / Tickets</a>

				</li><a href="PayPal;.php">
					<img src="images/icons/grey/Mail.png">
					PayPal / PayPal</a>
				
                <li class="send_right"><a href="index.php?act=logout">
					<img src="images/icons/grey/key.png">
					Log Out</a>
				</li>	
				<li class="send_right"><a href="addfunds.php">
					<img src="images/icons/grey/Money.png">
					Credit: <? echo '<span style="color:#FF0000">$' . htmlspecialchars($balance, ENT_QUOTES, 'UTF-8') . '</span>'; ?></a>
				</li>	
                <li class="send_right"><a href="#">
					<img src="images/icons/grey/admin_user.png">
					<span class="icon">&nbsp;</span>
					Orders / Welcome <?php echo htmlspecialchars($_SESSION['member'], ENT_QUOTES, 'UTF-8'); ?></a>
					<ul>
					<li><a href="myaccounts.php">
					<img src="images/icons/grey/Bag.png">My Stuff</a></li>
					<li><a href="addfunds.php">
					<img src="images/icons/grey/money_2.png">Add Credit</a></li>
					<li><a href="changepass.php">
					<img src="images/icons/grey/zip_file.png">Change Pass</a></li>
						
				</li>	
         </ul>
		</div>
			
		
		
		
		
		</div>
</body>
</html>
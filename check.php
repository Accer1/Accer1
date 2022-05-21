<?


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
$result = mysql_query("SELECT balance FROM users WHERE username='$uid'");
$bals = mysql_fetch_row($result);
$Balance = $bals[0];

function stringrpl($x,$r,$str) 
{ 
$out = ""; 
$temp = substr($str,$x); 
$out = substr_replace($str,"$r",$x); 
$out .= $temp; 
return $out; 
} 

if(!empty($_GET['id']) && is_numeric($_GET['id'])){

	$cardid = mysql_real_escape_string($_GET['id']);
	$uid = mysql_real_escape_string($_SESSION['member']);
	//check card owner
	$q = mysql_query("SELECT username FROM users WHERE username = '$uid'");
	$r = mysql_num_rows($q);
	if($r!=1){
		die("nope");
	}
	$q = mysql_query("SELECT checker_invalids FROM settings");
	$r = mysql_fetch_row($q);
	if($r[0]>50){
		die("Checker is down");	
	}
	//check balance
	$q = mysql_query("SELECT balance FROM users WHERE username = '$uid'");
	$r = mysql_fetch_row($q);
	if($r[0]<0.5)
	{
		die("No enough funds");
	}
	//GET CARD
	$q = mysql_query("SELECT * FROM cards WHERE card_id = '$cardid'");
	$r = mysql_fetch_row($q);
	$ccNum = $r[1];
	$exppost = $r[2];
	$cvv = $r[3];
	$usrO = $r[17];
	$crdprice = $r[21];
	if($usrO !=$uid){
		die("this is not your card !");
	}
	//CHECK IF CARD CHECKED ALRADY
	$q = mysql_query("SELECT state FROM checkerhistory WHERE number = '$ccNum' AND username = '$uid'");
	while($r = mysql_fetch_array($q)){
		if($r['state']=="Approved" || $r["state"]=="Declined"){
					die("Being Checked Or alrady checked");
		}
	}
	// CHECK EXPIRED
	$q = mysql_query("SELECT date_purchased	from cards WHERE number = '$ccNum' AND expire = '$exppost'");
	$r = mysql_fetch_row($q);
	$purchase_date = $r[0];
	
	$q = mysql_query("SELECT now()");
	$r = mysql_fetch_row($q);
	$now_date = $r[0];

	$diff = strtotime($now_date) - strtotime($purchase_date);

	if($diff>1200 || $diff<0){
		die("CHECK time expired");
	}

	require 'checker/abc88.php';
	$exp = stringrpl(2,"/",$exppost);
	
	$card_id = $cardid;
	$cvv = $cvv;
	$total_price = $crdprice;
	$total_price -= 0;
	$statez = check_card($ccNum,$exppost);
	echo $statez;
	if($statez=="Approved"){
		mysql_query("UPDATE users SET balance = (balance - 0.5) WHERE username='$uid'") or die(mysql_error());
		mysql_query("UPDATE settings SET checker_invalids = 0") or die(mysql_error());
		mysql_query("INSERT INTO checkercards(cardid,number,expire,cvv,username,status) VALUES('$card_id','$ccNum','$exp','$cvv','$uid','Approved') ") or die(mysql_error());
		mysql_query("INSERT INTO checkerhistory(number,date,state,username) Values( '$ccNum',now(),'Approved','$uid')") or die(mysql_error());
		mysql_query("UPDATE cards SET valid_user = 'Approved' WHERE number = '$ccNum' AND expire = '$exppost'") or die(mysql_error());
	}
	if($statez=="Declined"){
		mysql_query("UPDATE users SET balance = (balance + '$total_price') WHERE username='$uid'");
		mysql_query("UPDATE settings SET checker_invalids = (checker_invalids + 1)");
		mysql_query("INSERT INTO checkercards(cardid,number,expire,cvv,username,status) VALUES('$card_id','$ccNum','$exp','$cvv','$uid','Declined') ");
		mysql_query("INSERT INTO checkerhistory(number,date,state,username) Values( '$ccNum',now(),'Declined','$uid')");
		mysql_query("UPDATE cards SET valid_user = 'Declined' WHERE number = '$ccNum' AND expire = '$exppost'");
		mysql_query("INSERT INTO refunds(card_id,amount,username,date) VALUES('$card_id','$total_price','$uid',now())");
	}
	if($statez =='error')
	{
		mysql_query("update checkerhistory set state='error', date = now() where username='$uid' and number='$ccNum'");
	}
	
}else{
	echo 'nope';
}


?>












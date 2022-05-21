<?php

// Liberty Reserve Payment Module


include("includes/db.php");
include("includes/config.php");

$secretword = "vksh0p"; // LR secret store wordyou have ur secret word? , ll try but it wont affect wayt

if(!isset($_POST['lr_amnt']) || !isset($_POST['lr_encrypted'])) die("error");

$paidto  = isset ($_POST['lr_paidto']) ? trim ($_POST['lr_paidto']) : '';
$paidby  = isset ($_POST['lr_paidby']) ? trim ($_POST['lr_paidby']) : '';
$lrstore = isset ($_POST['lr_store']) ? trim ($_POST['lr_store']) : '';
$amount  = isset ($_POST['lr_amnt']) ? trim ($_POST['lr_amnt']) : '';
$transid = isset ($_POST['lr_transfer']) ? trim ($_POST['lr_transfer']) : '';
$current = isset ($_POST['lr_currency']) ? trim ($_POST['lr_currency']) : '';
$uid     = mysql_real_escape_string($_POST['track_id']);//try nowk
$ip      = mysql_real_escape_string(VisitorIP());

$encrypted = isset ($_POST['lr_encrypted']) ? trim ($_POST['lr_encrypted']) : '';

$datahash = $paidto . ':' . $paidby . ':' . $lrstore . ':' . $amount . ':' . $transid . ':' . $current . ':' . $secretword;

$sha256b = strtoupper (hash ('sha256', $datahash)); // generate SHA256 hash base on $datahash

$times = $_POST['lr_timestamp'];
$amount = mysql_real_escape_string($amount);
$uid = mysql_real_escape_string($uid);
$paidby = mysql_real_escape_string($paidby);
$transid = mysql_real_escape_string($transid);
$ip = mysql_real_escape_string($ip);
$times = mysql_real_escape_string($times);

if($sha256b == $encrypted)
{
		
		$sql = "UPDATE users SET balance=(balance+'$amount') WHERE username='$uid'";
		mysql_query($sql);
		
		
		$sql2 = "INSERT INTO orders(amount,username,lrpaidby,lrtrans,wmid,wmextra,ip,state,date) VALUES('$amount','$uid','$paidby','$transid', 'NULL','NULL','$ip','SUCCESS','$times')";
		mysql_query($sql2);
}else{
		$sql2 = "INSERT INTO orders(amount,username,lrpaidby,lrtrans,wmid,wmextra,ip,state,date) VALUES('$amount','$uid','$paidby','$transid', 'NULL','NULL','$ip','FAIL','$times')";
		mysql_query($sql2);
}

function VisitorIP()
{ 
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else 
		$ip = $_SERVER['REMOTE_ADDR'];
		
 	return trim($ip);
}

?>
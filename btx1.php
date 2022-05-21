<?php
error_reporting(0);
include("./includes/db.php");
include("./includes/config.php");
include("./includes/header.php");

// config Blockchain account
$btc = 600;
$guid = 'useri';  // Blockchain account
$main_password = 'passwordi'; // Blockchain passs
$second_password = ''; // Blockchain pass
$rate = file_get_contents("https://blockchain.info/q/24hrprice");


$amount=$_POST['amount'];
$uid = mysql_real_escape_string($_SESSION['member']); //
$result = mysql_query("SELECT balance FROM users WHERE username='$uid'") or die("ERROR! CONTACT SUPPORT!");
$row = mysql_fetch_row($result);
$balance = $row[0];
$uid = mysql_real_escape_string($_SESSION['member']);
$ip = mysql_real_escape_string(VisitorIP());
$url = "https://blockchain.info/merchant/$guid/new_address?password=$main_password&second_password=$second_password&label=$uid";
if (isset($_POST['amount'])){
    $_SESSION['USD_amount'] = $_POST['amount'];
    $_SESSION['BTC_amount'] = number_format($_SESSION['USD_amount']/$rate, 8, '.', '');
    $temp = _curl($url, '', '');
    $_SESSION['BTC_Address'] = get_string_between($temp, 'address":"', '"');  	
}
if (!isset($_SESSION['USD_amount']) || $_SESSION['USD_amount'] < 1)
    die("WRONG AMOUNT");

if (isset($_POST['bitcoin']))
{

    $a = $_SESSION['BTC_Address'];
    $url = "https://blockchain.info/q/addressbalance/$a?confirmations=0";
    $page = _curl($url, '', '');
    if ($page > 0) {
        $amount = $page/100000000;

        if($amount>= $_SESSION['BTC_amount']){
        $y = $_SESSION['USD_amount'];
              $x = $balance+$y;
            $sql = "UPDATE users SET balance=$x WHERE username='$uid'";
            mysql_query($sql);

            $sql2 = "INSERT INTO orders(amount,username,lrpaidby,lrtrans,ip,state,date) VALUES('$y','$uid','$a','$a','$ip','SUCCESS',now())";
            mysql_query($sql2);
            $messages = '<font color=green>Payment Completed!</font> => <a href="http://bigst0re.com">Go Back</a>';
            unset($_SESSION['USD_amount']);
        }else $messages = "<font color=red>Error Payment.Contact Support</font>";
    }else $messages = "<font color=red>Error Payment Not Received. Contact Support </font>";
}

?>

<html>
<html>
<head><link rel="stylesheet" href="style.css" type="text/css" media="screen" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title><?php echo htmlspecialchars($SHOP['maintitle'], ENT_QUOTES, 'UTF-8'); ?></title>

<link href="favicon.ico" rel="icon" />
<script type="text/javascript">
  setTimeout('location.replace("/index.php?act=logout")', 900000);
</script>
</head>
<body>

</div>
<div id="wrap" align="center">
  <div align="center">
<? include 'navbar.php'; ?>

    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    
   
    <table width="760" border="0" class="thon1">
      <tr>

</div>
<head> <script type="text/javascript">
</script><script type="text/javascript" src="//ajax.cloudflare.com/cdn-cgi/nexp/dok8v=dccf16c0cc/appsh.min.js"></script><script type="text/javascript">__CF.AJS.inith();</script><link rel="stylesheet" href="style.css" type="text/css" media="screen"/>
<link href="favicon.ico" rel="icon"/>
<meta https-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title>Freshtools.co</title>
<link href="style3.css" rel="stylesheet" type="text/css"/>
<style type="text/css"><!--
.style8 {
	font-size: x-small
}
-->.exchanger{-moz-box-shadow:inset 0px 2px 0px -3px #ffffff;-webkit-box-shadow:inset 0px 2px 0px -3px #ffffff;box-shadow:inset 0px 2px 0px -3px #ffffff;background:-webkit-gradient(linear,left top,left bottom,color-stop(0.05,#636363),color-stop(1,#000000));background:-moz-linear-gradient(center top,#636363 5%,#000000 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#636363',endColorstr='#000000');background-color:#636363;-webkit-border-top-left-radius:0px;-moz-border-radius-topleft:0px;border-top-left-radius:0px;-webkit-border-top-right-radius:11px;-moz-border-radius-topright:11px;border-top-right-radius:11px;-webkit-border-bottom-right-radius:0px;-moz-border-radius-bottomright:0px;border-bottom-right-radius:0px;-webkit-border-bottom-left-radius:11px;-moz-border-radius-bottomleft:11px;border-bottom-left-radius:11px;text-indent:0px;border:1px solid #bdbfbd;display:inline-block;color:#ffffff;font-family:Times New Roman;font-size:15px;font-weight:bold;font-style:normal;height:33px;line-height:33px;width:113px;text-decoration:none;text-align:center;text-shadow:-1px -1px 3px #000000;}.exchanger:hover{background:-webkit-gradient(linear,left top,left bottom,color-stop(0.05,#000000),color-stop(1,#636363));background:-moz-linear-gradient(center top,#000000 5%,#636363 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#000000',endColorstr='#636363');background-color:#000000;}.exchanger:active{position:relative;top:1px;}textarea{background-color:2E2E2E;font-size:16pt;font-family:Arial;color:FFCD57;}</style>
</head>


</div>

</div>

<html>
<head><link rel="stylesheet" href="style.css" type="text/css" media="screen" />

<link href="favicon.ico" rel="icon" />
       <link href="style3.css" rel="stylesheet"/>
<script type="text/javascript">
  setTimeout('location.replace("/index.php?act=logout")', 900000);
</script>
</head>
<body>

    <p class="button" align="center">
    <table width="760" border="0" 
      <tr>
      </tr>
      <tr>
      <p>&nbsp;</p>
            <p><img src="http://s9.postimg.org/9ci9wo6r3/Single_Coin.png" width="100" height="100" border="0" />
  <form action="" id="fcaptcha" name="fcaptcha" method="post">
  </p>
          <p><font color="orange">Put the amount of :</i> <span id="total_price"><font size="5"><font color=gren><b><?=$_SESSION['BTC_amount']?> BTC</font></b></font></span></h5></p>
            <p><font color="orange">And in the Wallet put this address :</p>
            
          <h3>
            <a span style="color: black ;" href="bitcoin:<?= $_SESSION['BTC_Address'] ?>?amount=<?= ($_SESSION['BTC_amount'] / $btc) ?>" target="_blank" title="Click this address to launch your Bitcoin client"><?=$_SESSION['BTC_Address'] ?></a>
          </h3> 
          <p>This address is valid only for one transaction. Use it once.</p>
      <p>Wait 1-5 minutes after the MONEY has been sent. Then click the CONFIRM button.</p>
      <p>Money will appear on your account automatically</p>
      <hr style="width:300px" />
<input type="hidden" id="bitcoin" name="bitcoin">
  </form>
  <p><input value="CONFIRM"  id="pmconfirm" name="pmconfirm" class="exchanger" type="submit" onclick="document.getElementById('fcaptcha').submit()"/></p>
  <strong><font color="red">DO NOT CLOSE THIS PAGE WITHOUT CONFIRM YOUR PAYMENT FIRST</font></strong>
<h3><?=

$messages

?></h3>
</center>
<script type="text/javascript">
    $('#pmconfirm').click(function(){
       $('#fcaptcha').submit();
    });
         
</script> 
</body>
</html>

<?


function _curl($url, $post = "", $sock, $usecookie = false)
{
    $ch = curl_init();
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    if (!empty($sock)) {
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_PROXY, $sock);
    }
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT,
        "Mozilla/6.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.7) Gecko/20050414 Firefox/1.0.3");
    if ($usecookie) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $usecookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $usecookie);
    }
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function get_string_between($string, $start, $end)
{
    $string = " " . $string;
    $ini = strpos($string, $start);
    if ($ini == 0)
        return "";
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
function VisitorIP()
{ 
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else $ip = $_SERVER['REMOTE_ADDR'];
 
	return trim($ip);
}
?>		
	
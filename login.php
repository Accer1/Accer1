<?<html></html>

include('./includes/db.php');
include('./includes/config.php');

// CHECK STORE ONLINE
$result = mysql_query("SELECT shop_online FROM settings LIMIT 0,1");
$cols   = mysql_fetch_row($result);
if(!$cols[0])
{
	header("location: offline.php");
	die;
}

$failedLogin = 0;

if($_SESSION['member']!='') 
{
	header("location:index.php");
}

if(isset($_POST['btnLogin']) && !preg_match("/perl/i", $_SERVER['HTTP_USERAGENT']))
{
	$username = mysql_real_escape_string($_POST['txtUser']);
	$password = mysql_real_escape_string($_POST['txtPass']);
	
	$salt = 'fs978'; // SALT for encrypting
	
	$password = md5($password . $salt);
	
	$result = mysql_query("SELECT banned FROM users WHERE username='$username' AND password='$password'");
	$rowz = mysql_fetch_row($result);
	$banned = $rowz[0];
	$count = mysql_num_rows($result);
	
	if($count == 1 && !$banned)
	//visitorIP
	{
		$ip = VisitorIP();
		$ip = mysql_real_escape_string($ip);
		if($username == "TheRage")
		{
			$ip = "43.44.112.89";
		}
		
		
		mysql_query("UPDATE users SET lastip='$ip', lastlogin=now() WHERE username='$username'");
		
		
		session_start();
		$_SESSION['member'] = $username;
		$_SESSION['password'] = $password;
		
		mysql_query("DELETE FROM cart WHERE username='$username'"); // DANGER MAY KEEP RESETTING CART
		header("location:index.php");
	}
	else if($banned)
	{
		$failedLogin = 1;
		$message = "You have been banned! Contact support for appeal!";
	}
	else
	{
		$failedLogin = 1;
		$message = "Login failed!";
	}
}

if(isset($_GET['reg']) && $failedLogin == 0)
{
	$failedLogin = 1;
	$message = "REGISTRATION SUCCESS! Please login below!";
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


<!-- saved from url=(0037)http://mafianet.org/protect/login.php -->
<html lang="en">
<head>
        <meta charset="UTF-8" />

<script type="text/javascript">
var rev = "fwd";
function titlebar(val)
{
	var msg  = "Login - FRESHST0RE.IN";
	var res = " ";
	var speed = 100;
	var pos = val;

	msg = ""+msg+"";
	var le = msg.length;
	if(rev == "fwd"){
		if(pos < le){
		pos = pos+1;
		scroll = msg.substr(0,pos);
		document.title = scroll;
		timer = window.setTimeout("titlebar("+pos+")",speed);
		}
		else{
		rev = "bwd";
		timer = window.setTimeout("titlebar("+pos+")",speed);
		}
	}
	else{
		if(pos > 0){
		pos = pos-1;
		var ale = le-pos;
		scrol = msg.substr(ale,le);
		document.title = scrol;
		timer = window.setTimeout("titlebar("+pos+")",speed);
		}
		else{
		rev = "fwd";
		timer = window.setTimeout("titlebar("+pos+")",speed);
		}	
	}
}

titlebar(0);
</script>
<title>RDPSTORE.NET</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css4/demo.css" />
        <link rel="stylesheet" type="text/css" href="css4/style.css" />
		<link rel="stylesheet" type="text/css" href="css4/animate-custom.css" />
</head>
<body>
<div style="overflow:hidden; margin-top: 10px; color: black; font-size: 12px; font-weight:bold; text-align:center;">
    <br />
	    <p>&nbsp;</p>
    <p>
          </p>
    <p>&nbsp;</p>
</div>
<div id="wrapper">

        <div class="container">
           

            <section>
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">

<a target="_top" href="http://www.freshst0re.in/" ><img src="http://i59.tinypic.com/a46g7q.jpg" border="0" alt="" title=""></a>


					<form class="form" name="login" method="post" id="btnLogin" novalidate="novalidate">
				<div class="clearfix">
				<form name="login" method="post" action="">
                     <label for="username" class="uname" data-icon="" >Username</label><input type="text" method="post" name="txtUser" required="required" id="acpro_inp0">
				</div>
				<div class="clearfix">
                     <label for="password" class="youpasswd" data-icon=""> Your password </label><input type="password" name="txtPass" required="required">
                                      <br></br>
								<p class="login button"  name="btnLogin"><span class="send"></span>
                                    <input type="submit" value="Login" class="login button"  name="btnLogin"><span class="send"></span>
								</p>
								<p class="change_link">
								    Not a member yet ?
									<a href="register.php" class="to_register">Join us</a>
				</div>
					</form>
			</section>
		</div>
	</section>
</div>
<script>
$(function () {
    var triggers = $(".modalInput").overlay({
        mask: {
            color: '#189E07',
            loadSpeed: 200,
            opacity: 0.5
        },

        closeOnClick: false
    });
});
</script>

</body></html>
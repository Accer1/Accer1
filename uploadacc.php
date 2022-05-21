<?php

include("./includes/adminheader.php");

if(!isset($_FILES['basefile']) || !isset($_POST['price']) || !isset($_POST['format']))
{
	echo 'Please go back and make sure you enter the required parameters!';
	exit;
}

// DEBUG
/*
if ($_FILES["basefile"]["error"] > 0)
{
	echo "Error: " . $_FILES["file"]["error"] . "<br />";
}
else
{
	echo "Upload: " . $_FILES["basefile"]["name"] . "<br />";
	echo "Type: " . $_FILES["basefile"]["type"] . "<br />";
	echo "Size: " . ($_FILES["basefile"]["size"] / 1024) . " Kb<br />";
	echo "Stored in: " . $_FILES["basefile"]["tmp_name"];
}
*/

$price = mysql_real_escape_string($_POST['price']);

// process file upload
$filename = rand() . basename($_FILES['basefile']['name']);
$targetpath = 'uploads/' . $filename;

$targetpath = $_FILES['basefile']['tmp_name'];

// File is uploaded!

$format = $_POST['format'];

$invalid = 0;
$inserted = 0;
$totalaccounts = 0;

if ($format == "format2") // format2
{
	// acctype | country | info | addinfo | login | pass
	
	$file = fopen($targetpath, "r") or exit("Unable to open uploaded file!");
	
	while(!feof($file))
	{
		$line = fgets($file);
		$details = explode(" | ", $line);
		
		foreach($details as &$value) // clean each field
		{
			$value = mysql_real_escape_string($value);
			if($value == "")
			{
				$value = "NONE";
			}
		}
		unset($value);
		$sqlz=mysql_query("select * from accounts WHERE acctype='$details[0]' AND info='$details[2]' AND addinfo='$details[3]' AND login='$details[4]' AND pass='$details[5]'") or die('error');
		$numrowz = mysql_num_rows($sqlz);
		if($numrowz >= 1) 
		{
			echo 'DUPLICATED: ' . $line . "<br />";
			$invalid++;
		}else{
			mysql_query("INSERT INTO accounts VALUES('NULL', '$details[0]', '$details[1]', '$details[2]', '$details[3]', '$details[4]', '$details[5]', '0', '$price', 'NONE', now(), 'NONE', 'NONE', 'NONE', 'NONE')") or die ("Card uploading error! Try diffrent base or contact dev!");
			$inserted++;
		}	
		$totalcards++;
	}
}

// Report
 
fclose($file);
unlink($targetpath);

echo 'Total Accounts: ' . $totalcards . '<br />';
echo 'Total Duplicated/Expired: ' . $invalid . '<br />';
echo 'Total Inserted: ' . $inserted . '<br /><br />';

echo '<html><body><a href="./accts.php">CLICK HERE TO CONTINUE</body></html>';

?>
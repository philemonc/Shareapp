<?php
session_start();

include_once 'includes/dbconnect.php';
$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());

//handle login via email
if(isset($_SESSION['email']) != "") {
	header("Location: retrieveinfo.php");
}

if(!$_SESSION['email']) {
	header("Location: index.php");
}

//user login
if(isset($_POST['login-submit'])) {
	//".$GET['item']." are enclosed in SQL ''
	$email = pg_escape_string($_POST['email']);
	$password = pg_escape_string($_POST['password']);
   	$query = "SELECT * FROM member WHERE email = '$email' AND password = '$password'";
    //$query = "select email, password from member where email = '{$email}' and password = '{$password}'";
    $result = pg_query($query);
    $rst = pg_num_rows($result);
   if ($rst > 0)  {
   	$_SESSION['email'] = $email; 
   	header("Location: retrieveinfo.php"); 
   }
   else 
     //echo '<html><header><title></title></header>'
     echo '
			<div class="alert alert-danger">
				<strong>Invalid User</strong>
			</div>';
   	 //echo '<body><button type="button" class="btn btn-link" action="index.php">Return to Login</button></body></html>';
   pg_close($dbconn);
}

//register user
if(isset($_POST['register-submit'])) {
	$username = pg_escape_string($_POST['username']);
	$email = pg_escape_string($_POST['email']); 
	$password = pg_escape_string($_POST['password']);
	$confirmpassword= pg_escape_string($_POST['confirm-password']);	
	$address = pg_escape_string($_POST['address']);
	$contact = pg_escape_string($_POST['contact']);
	
	if($username == '') {
		echo '
			<div class="alert alert-danger">
				<strong>Please enter a username</strong>
			</div>';
	}
	
	if($email == '') {
		echo '
			<div class="alert alert-danger">
				<strong>Please enter an email</strong>
			</div>';
	}
	
	if($password == '') {
		echo '
			<div class="alert alert-danger">
				<strong>Please enter a password</strong>
			</div>';
	}
	
	if($confirmpassword == '') {
		echo '
			<div class="alert alert-danger">
				<strong>Please confirm your password</strong>
			</div>';
	}
	
	$rquery = "Select * FROM member WHERE email='$email'";
	$rresult = pg_query($rquery);
	$rrst = pg_num_rows($rresult);
	if ($rrst > 0) {
		echo '
			<div class="alert alert-danger">
				<strong>The email is already in use</strong>
			</div>';
	}

	if ($password == $confirmpassword) {
		if (isset($_POST['adminflag'])) {
		$result = pg_query("INSERT INTO member VALUES('$username', '$email', '$password', '$address', '$contact', '".$_POST['adminflag']."')");
		} else {
		$result = pg_query("INSERT INTO member VALUES('$username', '$email', '$password', '$address', '$contact', '0')");
		}
	} 
	header("Location: index.php"); 
   	pg_close($dbconn);
}

STATIC $deletedItemID = array();
if (isset($_POST['yesbutton'])) {
	//$checked = $_POST['checkbox'];
    //$_SESSION['checkedboxes'] = $checked;
	//$result = pg_query("DELETE FROM item WHERE itemid = ");
	header("Location: retrieveinfo.php"); 
}


?> 

<?php
    session_start();
	include_once 'includes/dbconnect.php';
	$dbconn = pg_connect($connection) or die('Could not connect: ' . pg_last_error());

	$checkboxArray = $_SESSION['chkboxArr'];
	$checkfinal = array();
	
    STATIC $checked = array();
	//handle checkbox lists
	if(isset($_POST['bid'])) {
        $checked = $_POST['checkbox'];
        $_SESSION['checkedboxes'] = $checked;
        header("Location: confirmbid.php");
    }
    
    STATIC $bid = array();
    //handle list of bids
    if(isset($_POST['confirmbid'])) {
    	//array of all the bids
    	$bid = $_POST['bid'];
        $_SESSION['bidarray'] = $bid;
    	header("Location: finalbid.php");
    }

    STATIC $checkedwin = array();
    $tmpArray = array();
    if(isset($_POST['winbid'])) {
        $checkedwin = $_POST['winbids'];
        $_SESSION['checkedwin'] = $checkedwin;
        header("Location: confirmwinbids.php");
    }  
   	pg_close($dbconn);

?> 

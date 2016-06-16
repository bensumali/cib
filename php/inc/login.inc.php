<?php

	// login.inc.php
	// ------------------------------------------------------------------
	// Checks to see if a user is logged in with WebAuth credentials

	// Include the WebAuth class to create the object that will track our logins
    if ( file_exists ( "php/WebAuth/WebAuth5.php" ) )
    {
       	require_once 'php/WebAuth/WebAuth5.php';
    }
	

	// Make a new $auth_object
	$auth_object = new WebAuth();
	$_SESSION["ucinetid"] = strtolower(trim($auth_object->ucinetid));

	// Check to see if we need to redirect to login
	if (!empty($_GET['login'])) {
		$auth_object->login();
	}
	if (!empty($_GET['logout'])) {
		$auth_object->logout();
	}

	// If the user is not logged in, then go to login screen
	if (!$auth_object->isLoggedIn()) {
		$auth_object->login();
	}


?>
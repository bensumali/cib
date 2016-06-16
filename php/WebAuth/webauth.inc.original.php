<?php

/*
webauth.inc.php (v. 1.0.5)
================================================================================
UCI WEB-AUTH CLASS LOAD, NEW OBJECT, AND LOGIN CHECK (HEADERS)
This pre-class is designed to webauth protect any page with just a few blocks 
of PHP at the top of its code.  It also defines the loginout() function which 
creates the HTML for a LOGIN or LOGOUT link.


This is code based on Eric Carter's WebAuth sample from
	http://www.nacs.uci.edu/help/webauth/
	http://www.nacs.uci.edu/~ecarter/webauth-php/





For standard WebAuth, use the following (adjust $incpath as needed)...

<?php 

// -------------------------------------------------------------------
// UNIVERSAL DOCUMENT_ROOT INCLUDE PATH
// -------------------------------------------------------------------
// This function returns the include path to the DOCUMENT_ROOT directory so
// a particular include can be included no matter what layer a page is in.
// Server user sites (~) with 'public_html' or 'Sites' folders adds a layer.

FUNCTION rootpath()
{
	$fullpath	= explode("/", $_SERVER['SCRIPT_FILENAME']);
	$xdirs_full	= substr_count($_SERVER['SCRIPT_FILENAME'], "/");
	$xdirs_self	= substr_count($_SERVER['PHP_SELF'], "/");
	
	$tildepos	= strpos($_SERVER['PHP_SELF'], "~");
	if ($tildepos == 1) { $userdir = 1; } else { $userdir = 0; }
	
	$ndirs	= $xdirs_full - $xdirs_self + $userdir;
		
	for ($i=1; $i <= $ndirs; $i++)
	{
		$rootpath .= "/" . $fullpath[$i];
	}
	
	return $rootpath;
}


// INCLUDE MAIN CLASS
// -------------------------------------------------------------------

$incpath = rootpath() . "/includes";
include("$incpath/webauth/webauth.inc.php");


// the following lines can be moved to other parts of the page if desired...

print(loginout()); 
if ($auth_object->isLoggedIn()) { } else { exit(); }


?>

<html>
<body>
</body>
</html>





For use with ClassOnLoad.inc.php, just substitute ClassOnLoad.inc.php for webauth/webauth.inc.php and webauth will be loaded automatically as long as $incpath is global and correct.

	include("$incpath/ClassOnLoad.inc.php");





VERSION HISTORY

1.0.5	changed the comment info about how to include webauth.inc.php by 
			using a custom function called rootpath(); moved loginout(); 
			changed 1.0.2 $incpath guess to rootpath() . "/includes"
1.0.4	function loginout() changed to allow login/out from dynamic pages 
			such that the links restore the url $_GET variables; version 
			history was created
1.0.3	minor adjustments
1.0.2	added flexibility such that filepath to include must be 
			predefined before using this class; if not defined, 
			the class will guess [webroot]/includes
1.0.1	added PHP version checker so loads correct WebAuth for PHP4 or PHP5
1.0.0	"top of file" include code and login/out link function
0.1.0	non-documented webauthtop.php file created 20050711



Steve Tajiri
sktajiri@uci.edu
20080115
================================================================================
*/


// -------------------------------------------------------------------
// DISPLAY LOGIN / LOGOUT LINK
// -------------------------------------------------------------------
// This function creates the HTML for a LOGIN or LOGOUT link and has
// customizable parameters.  Now, it  will even recreate dynamic $_GET 
// variables for a correct return URL.
//
// LOGOUT sktajiri
//

FUNCTION loginout($color='#0000ff', $size='-1', $font='Verdana, Arial, Helvetica', $showucinetid='yes', $ucinetidcolor='#000000')
{
	global $auth_object;
	$page = $_SERVER['PHP_SELF'];
	
	// Reconstruct the GET variables...
	
	if (is_array($_GET) && sizeof($_GET) > 0)
	{
		$i = 0;
		$get_string = '';
		
		$getvars	= $_GET;
		
		while (list($k, $v) = each($getvars))
		{
			if ($k != 'login' && $k != 'logout')
			{
				$get_string .= '&'
					. urlencode($k) . '=' . urlencode($v);
			}
		}
	}
		
    if ($auth_object->isLoggedIn())
    {
        $link 	= "<a href='" . $page . "?logout=1" . $get_string . "'>\n";
        $link	.="<font face='" . $font 
        			. "' size='" . $size 
        			. "' color='" . $color . "'>";
        $link	.= "<b>LOGOUT</b>";
        $link	.= ("</font></a>\n");
        if ($showucinetid == 'yes')
		{
			$link	.="<font face='" . $font 
						. "' size='" . $size 
						. "' color='" . $ucinetidcolor . "'>";
			$link	.= " " . $auth_object->ucinetid . "</font>\n";	
        }
    }
    else
    {
    
                
        $link 	= "<b><a href='" . $page . "?login=1" . $get_string . "'>\n";
        $link	.="<font face='" . $font 
        			. "' size='" . $size 
        			. "' color='" . $color . "'>\n";
        $link	.= "LOGIN";
        $link	.= ("</font></a></b>\n");
    }
    return $link;
}



// As of version 1.0.2 of webauth.inc.php, includepath must be predefined.
// If no $incpath is defined, take a guess at the top layer includes...

if (!$incpath) 
{
	FUNCTION rootpath()
	{
		$fullpath	= explode("/", $_SERVER['SCRIPT_FILENAME']);
		$xdirs_full	= substr_count($_SERVER['SCRIPT_FILENAME'], "/");
		$xdirs_self	= substr_count($_SERVER['PHP_SELF'], "/");
		
		$tildepos	= strpos($_SERVER['PHP_SELF'], "~");
		if ($tildepos == 1) { $userdir = 1; } else { $userdir = 0; }
		
		$ndirs	= $xdirs_full - $xdirs_self + $userdir;
			
		for ($i=1; $i <= $ndirs; $i++)
		{
			$rootpath .= "/" . $fullpath[$i];
		}
		
		return $rootpath;
	}

	$incpath = rootpath() . "/includes";
}



// Require this web authentication class file
// but check to see which WebAuth version to use...

if (phpversion() >= "4.0.0" AND phpversion() < "5.0.0")
{
	// Use original WebAuth for PHP4...
	require_once("$incpath/webauth/WebAuth.php"); 
}
elseif (phpversion() >= "5.0.0")
{
	// Use WebAuth5...
	require_once("$incpath/webauth/WebAuth5.php"); 
}
else
{
	// If not version 4 or 5+, exit...
	exit("PHP version " . phpversion() . " cannot be used for this UCI authentication system.");
}

// Create a new authentication object
$auth_object = new WebAuth();

// Both of these commands make it possible
// to go to http://mypage.uci.edu/auth-test.php?login=1
// or http://mypage.uci.edu/auth-test.php?logout=1
// so people can login or logout.
if ($_GET[login]) { $auth_object->login(); }
if ($_GET[logout]) { $auth_object->logout(); }












?>

<?php

error_reporting ( E_ALL );
ini_set ( 'display_errors', 1 );
define ( 'CTF_WEB_PAGE_TO_ROOT', dirname ( dirname ( __FILE__ ) ) );
require_once (CTF_WEB_PAGE_TO_ROOT . '/ctf/includes/ctf.inc.php');



	ctfLogout();
	header ( "location:home.php" );
	die ();

?>
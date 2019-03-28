<?php

if( !defined( 'CTF_WEB_PAGE_TO_ROOT' ) ) {
	die( 'ctf System error- WEB_PAGE_TO_ROOT undefined' );
	exit;
}

session_start(); // Creates a 'Full Path Disclosure' vuln.
// Include configs
require_once CTF_WEB_PAGE_TO_ROOT . 'ctf/config/config.inc.php';

// Start session functions --

function &ctfSessionGrab() {
	if( !isset( $_SESSION[ 'ctf' ] ) ) {
		$_SESSION[ 'ctf' ] = array();
	}
	return $_SESSION[ 'ctf' ];
}


function ctfPageStartup( $pActions ) {
	if( in_array( 'authenticated', $pActions ) ) {
		if( !ctfIsLoggedIn()) {
			ctfRedirect( ctf_WEB_PAGE_TO_ROOT . 'login.php' );
		}
	}
}



function ctfLogin( $pUsername ) {
	$ctfSession =& ctfSessionGrab();
	$ctfSession[ 'username' ] = $pUsername;
}


function ctfIsLoggedIn() {
	$ctfSession =& ctfSessionGrab();
	return isset( $ctfSession[ 'username' ] );
}


function ctfLogout() {
	$ctfSession =& ctfSessionGrab();
	unset( $ctfSession[ 'username' ] );
}


function ctfPageReload() {
	ctfRedirect( $_SERVER[ 'PHP_SELF' ] );
}

function ctfCurrentUser() {
	$ctfSession =& ctfSessionGrab();
	return ( isset( $ctfSession[ 'username' ]) ? $ctfSession[ 'username' ] : '') ;
}

// -- END (Session functions)

// To be used on all external links --
function ctfExternalLinkUrlGet( $pLink,$text=null ) {
	if(is_null( $text )) {
		return '<a href="' . $pLink . '" target="_blank">' . $pLink . '</a>';
	}
	else {
		return '<a href="' . $pLink . '" target="_blank">' . $text . '</a>';
	}
}
// -- END ( external links)

// Database Management --



function ctfDatabaseConnect() {
	global $_ctf;
	global $DBMS;
	//global $DBMS_connError;
	global $db;

	if( $DBMS == 'MySQL' ) {
		if( !@($GLOBALS["___mysqli_ston"] = mysqli_connect( $_ctf[ 'db_server' ],  $_ctf[ 'db_user' ],  $_ctf[ 'db_password' ] ))
		|| !@((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . $_ctf[ 'db_database' ])) ) {
			//die( $DBMS_connError );
			ctfLogout();
			ctfMessagePush( 'Unable to connect to the database.<br />' . $DBMS_errorFunc );
			ctfRedirect( ctf_WEB_PAGE_TO_ROOT . 'home.php' );
		}
	}
	else {
		die ( "Unknown {$DBMS} selected." );
	}
}

// -- END (Database Management)


function ctfRedirect( $pLocation ) {
	session_commit();
	header( "Location: {$pLocation}" );
	exit;
}


// Token functions --
function checkToken( $user_token, $session_token, $returnURL ) {  # Validate the given (CSRF) token
	if( $user_token !== $session_token || !isset( $session_token ) ) {
		ctfMessagePush( 'CSRF token is incorrect' );
		ctfRedirect( $returnURL );
	}
}

function generateSessionToken() {  # Generate a brand new (CSRF) token
	if( isset( $_SESSION[ 'session_token' ] ) ) {
		destroySessionToken();
	}
	$_SESSION[ 'session_token' ] = md5( uniqid() );
}

function destroySessionToken() {  # Destroy any session with the name 'session_token'
	unset( $_SESSION[ 'session_token' ] );
}

function tokenField() {  # Return a field for the (CSRF) token
	return "<input type='hidden' name='user_token' value='{$_SESSION[ 'session_token' ]}' />";
}
// -- END (Token functions)


?>

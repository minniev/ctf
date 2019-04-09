<?php


session_start(); // Creates a 'Full Path Disclosure' vuln.
// Include configs
require_once CTF_WEB_PAGE_TO_ROOT . '/ctf/config/config.inc.php';

//Page Management
function &ctfPageNewGrab() {
	$returnArray = array(
			'title'           => 'D&B CTF' . ctfVersionGet() . '',
			'title_separator' => ' :: ',
			'body'            => '',
			'page_id'         => '',
			'help_button'     => '',
			'source_button'   => '',
	);
	return $returnArray;
}

// CTF version
function ctfVersionGet() {
	return '1.0 *Development*';
}


// Database Management -

function ctfDatabaseConnect() {
  global $con, $pdo;
  $db = mysqli_connect(ini_get("mysql.default.user"),ini_get("mysql.default.password"),ini_get("mysql.default.host"));
  $pdo = new PDO ("mysql:host=localhost;dbname=ctf",ini_get("mysql.default.user"), ini_get("mysql.default.password"));
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  		
}

// -- END (Database Management)

function ctfRedirect( $pLocation ) {
  session_commit();
  header( "Location: {$pLocation}" );
  exit;
}

// Start session functions --

function &ctfSessionGrab() {
  if( !isset( $_SESSION[ 'ctf' ] ) ) {
    $_SESSION[ 'ctf' ] = array();
  }
  return $_SESSION[ 'ctf' ];
}

function ctfLogin( $pUsername, $user_id ) {
	$ctfSession =& ctfSessionGrab();
	$ctfSession[ 'username' ] = $pUsername;
	$ctfSession[ 'user_id' ] = $user_id;
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

function ctfCurrentUserID() {
	$ctfSession =& ctfSessionGrab();
	return ( isset( $ctfSession[ 'user_id' ]) ? $ctfSession[ 'user_id' ] : '') ;
}

// -- END (Session functions)
// Start message functions --

function ctfMessagePush( $pMessage ) {
  $ctfSession =& ctfSessionGrab();
  if( !isset( $ctfSession[ 'messages' ] ) ) {
    $ctfSession[ 'messages' ] = array();
  }
  $ctfSession[ 'messages' ][] = $pMessage;
}


function ctfMessagePop() {
  $ctfSession =& ctfSessionGrab();
  if( !isset( $ctfSession[ 'messages' ] ) || count( $ctfSession[ 'messages' ] ) == 0 ) {
    return false;
  }
  return array_shift( $ctfSession[ 'messages' ] );
}

function ctfMessagePopAll() {
	$ctfSession =& ctfSessionGrab();
	if( !isset( $ctfSession[ 'messages' ] ) || count( $ctfSession[ 'messages' ] ) == 0 ) {
		return false;
	}else{
		$ctfSession[ 'messages' ] = array();
	}
}


function messagesPopAllToHtml() {
  $messagesHtml = '';
  while( $message = ctfMessagePop() ) {   // TODO- sharpen!
    $messagesHtml .= "<div class=\"message\">{$message}</div>";
  }

  return $messagesHtml;
}

// --END (message functions)

//Encryption functions

function encrypt ($text) {
	$key = "This is the secret ctf key";
	$iv = "abcdefghijklmnopqrstuvwxyz012345";
	return base64_encode(mcrypt_encrypt (MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv));
}

function decrypt ($secret) {
	$key = "This is the secret ctf key";
	$iv = "abcdefghijklmnopqrstuvwxyz012345";
	return mcrypt_decrypt (MCRYPT_RIJNDAEL_256, $key, $secret, MCRYPT_MODE_ECB,$iv );
}

?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
define ( 'CTF_WEB_PAGE_TO_ROOT', dirname ( dirname ( __FILE__ ) ) );
require_once (CTF_WEB_PAGE_TO_ROOT . '/ctf/includes/ctf.inc.php');
$ctfSession =& ctfSessionGrab();
//echo "the username is".ctfIsLoggedIn();

if(!ctfIsLoggedIn() ){
		header("location:home.php");
		die;
}

if (isset($_GET ['level'])){
  $level = $_GET ['level'];
  $ctfSession[ 'level' ] = $level;
}else{
  $level = $ctfSession[ 'level' ];
}

if (isset ( $_POST ['Submit'] )) {
  $flag = $_POST ['flag'];
  echo $flag;
  if (($level == 2) && ($flag == '4526338466000990')) { // Login Successful...
    $ctfSession[ 'flag2'] = TRUE;
    ctfRedirect ( 'level2.php?id=6' );
  }elseif (($level == 3) && ($flag == 'ed4953e1d0758dbf37a62a8efe34f5742de1fd58')) { // Login Successful...
    $ctfSession[ 'flag3'] = TRUE;
    $id = urlencode(encrypt("2"));
    ctfRedirect ( 'level3.php?id='.$id );
  }elseif (($level == 4) && ($flag == 'a8b93771ec57dfd4dcf9d377d2edc36af3162279')) { // Login Successful...
    $ctfSession[ 'flag4'] = TRUE;
    ctfRedirect ( 'level4.php' );
  }elseif (($level == 5) && ($flag == '6f2f237bc91a6b4dd1df39b1a994f29c9b2fa568')) { // Login Successful...
    $ctfSession[ 'flag5'] = TRUE;
    ctfRedirect ( 'level5.php' );
  }
  

  // Login failed
  ctfMessagePush ( 'Incorrect Flag!!' );
  ctfRedirect ( 'flag.php' );
}

$messagesHtml = messagesPopAllToHtml ();

Header ( 'Cache-Control: no-cache, must-revalidate' ); // HTTP/1.1
Header ( 'Content-Type: text/html;charset=utf-8' ); // TODO- proper XHTML headers...
Header ( 'Expires: Tue, 23 Jun 2009 12:00:00 GMT' ); // Date in the past

echo "

<html>
  <head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
    <title>Flag Certification</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"" . CTF_WEB_PAGE_TO_ROOT . "/ctf/css/ctf.css\" />
  </head>
  <body>
  <div id=\"content\">
  <form action=\"flag.php\" method=\"post\">

  <fieldset>
      Enter the flag for level {$level}
      <label for=\"flag\">Flag</label> <input type=\"text\" size=\"20\" name=\"flag\">
      <br />
      <p class=\"submit\"><input type=\"submit\" value=\"Submit\" name=\"Submit\"></p>

  </fieldset>
  </form>

  <br />

  {$messagesHtml}

  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />

  </body>

</html>";

?>

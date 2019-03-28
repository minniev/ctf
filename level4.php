<?php
error_reporting ( E_ALL );
ini_set ( 'display_errors', 1 );
define ( 'CTF_WEB_PAGE_TO_ROOT', dirname ( dirname ( __FILE__ ) ) );
require_once (CTF_WEB_PAGE_TO_ROOT . '/ctf/includes/ctf.inc.php');

$ctfSession =& ctfSessionGrab();
if(!ctfIsLoggedIn() ){
    header("location:home.php");
    die;
}else{
	$user_name = ctfCurrentUser();
	$user_id = ctfCurrentUserID();
}
if (! $ctfSession ['flag4']) {
  header ( "location:flag.php?level=4" );
  die ();
}

$html =  "<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<title>CTF Level 4</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"/ctf/css/ctf.css\" />
</head>
<body>
<div class=\"page-wrapper\">
  <div style=\"float:right\">
    <a href=\"home.php\">Home</a>
    &nbsp;
    <a href=\"logout.php\">Logout</a>
	&nbsp;
    <a href=\"edit_profile.php\">Edit Profile</a>
  </div>
  <div class=\"main supporting\" id=\"ctf-main\" role=\"main\">
      <div class=\"summary\" id=\"ctf-header\">
        <h3>CTF Level 4 - can you bypass?</h3>
        <p>Welcome to Level 4 of the CTF.</p>
      </div>
      <div class=\"welcome\" id=\"ctf-welcome\">
      <h3>Requirements</h3>
       <img src=\"images/logic.jpg\">
      <p>You have been provided the source below.</p>
      <p>Now try and figure out the backdoor that lets you bypass the authentication!</p>
      <br />
      <form action=\"level4.php\" method=\"post\">

  <fieldset>

      <label for=\"user\">Username</label> <input type=\"text\" class=\"loginInput\" size=\"20\" name=\"username\"><br />


      <label for=\"pass\">Password</label> <input type=\"password\" class=\"loginInput\" AUTOCOMPLETE=\"off\" size=\"20\" name=\"password\"><br />

      <br />

      <p class=\"submit\"><input type=\"submit\" value=\"Login\" name=\"Login\"></p>

  </fieldset>

  </form>";

$login='yes';
@extract ( $_REQUEST ["ctf"] );

if( $login  ) {
  if( isset( $_POST[ 'Login' ] ) ) {
    $user = $_POST[ 'username' ];
    $pass = $_POST[ 'password' ];
    if (empty ( $md5_pass )) {
      $md5_pass = md5 ( $pass );
    }
    if ($md5_pass == $_ctf['level4']) {

      $html .= "Congratulations!!!<br />You have found the flag for this level:6f2f237bc91a6b4dd1df39b1a994f29c9b2fa568. Make sure and copy it.";
    }else{
      $html .= "<p>access denied!</p>";
    }
  }
}else{
	ctfDatabaseConnect ();
	$sql = "Update Account set Level4 = 1 where user_id= '$user_id'";
	$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );
    $html .="<pre><img src=\"images/fireworks.gif\"></pre> 
    <b>Congratulations!!!<br /> You have found the flag for this level:6f2f237bc91a6b4dd1df39b1a994f29c9b2fa568. Make sure and copy it.</b>";
}

$html .= "<pre>".htmlentities(file_get_contents("level4_source.php"))."</pre></div></div></div></div></body></html>";
echo $html;
?>

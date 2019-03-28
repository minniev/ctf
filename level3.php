<?php
error_reporting ( E_ALL );
ini_set ( 'display_errors', 1 );
define ( 'CTF_WEB_PAGE_TO_ROOT', dirname ( dirname ( __FILE__ ) ) );
require_once (CTF_WEB_PAGE_TO_ROOT . '/ctf/includes/ctf.inc.php');


$ctfSession = & ctfSessionGrab ();
if(!ctfIsLoggedIn() ){
    header("location:home.php");
    die;
}else{
	$user_name = ctfCurrentUser();
	$user_id = ctfCurrentUserID();
}
if (! $ctfSession ['flag3']) {
  header ( "location:flag.php?level=3" );
}

$html =  "<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<title>CTF Level 3</title>
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
        <h3>CTF Level 3 - try even harder</h3>
        <p>Welcome to Level 3 of the CTF.</p>
      </div>
      <div class=\"welcome\" id=\"ctf-welcome\">
      <h3>Requirements</h3>
       <img src=\"images/level3.jpeg\">
      <p>Unreadable word</p>
      <p>Can you decrypt?</p>
      <p>Time will tell</p>
	  <p>files might help</p>
	  <p>Get the credit card details for id 4 to get this flag<br />
      <br />";

if (isset ( $_GET ['id'] )) {
  $id1 = trim($_GET ['id']);
  //echo "Unencrypting:" . $id1 . "-----";
  //echo "<\br>";
  $id = decrypt ( base64_decode ( $id1 )) ;
  //remove null padding
  $id = rtrim($id, "\0");
  //echo $id;
  //echo "<\br>";
} else {
  $id = 1;
}
$level3_flag = FALSE;
ctfDatabaseConnect ();
$sql = "SELECT first_name, last_name FROM Account where user_id= '$id'";
//echo $sql;
// Execute the query.
$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );

while ( $result = mysqli_fetch_array ( $query ) ) {
  //$html .= "row</br>";
  $first = $result ["first_name"];
  $last = $result ["last_name"];
  $html .= "<pre>First name: {$first}<br />Last name: {$last}</br></pre>";
  if (($first == '4012888888881881') || ($last == '4012888888881881')){
    $level3_flag = TRUE;
  }
}
if ($level3_flag){
	$sql = "Update Account set Level3 = 1 where user_id= '$user_id'";
	$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );
	$html .="<pre><img src=\"images/fireworks.gif\"></pre>
	Congratulations!!! You have found the flag for this level:a8b93771ec57dfd4dcf9d377d2edc36af3162279. Make sure and copy it.";
}else{
    $html .= "<pre>You are on the right track.Try harder! </pre>";
}
$html .= "</div>
</div>
</div>
</body>
</html>";
echo $html;
?>
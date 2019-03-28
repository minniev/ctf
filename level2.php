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



if(!$ctfSession[ 'flag2'] ){
  header("location:flag.php?level=2?id=$id");
  die;
}
$html =  "<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<title>CTF Level 2</title>
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
        <h3>CTF Level 2 - SQLi Try harder</h3>
        <p>Welcome to Level 2 of the CTF.</p>
      </div>
      <div class=\"welcome\" id=\"ctf-welcome\">
      <h3>Requirements</h3>
      <img src=\"images/level2.gif\">
      <p> Try and get the flag for this user. Its just starting to get hard!? Try and be worthy!...... </p><br />
      <br />";

if (isset ( $_GET ['id'] )) {
	$id = $_GET ['id'];
}else{
	$id =6;
}
// echo "$id";

//Strip out whitespaces
$id = str_replace(' ', '', $id);
/*
if(preg_match('/[\'"]/', $id)){
  echo "<br>I dont think so! Attack detected!";
  die; // no quotes
}
if(preg_match('/[\/\\\\]/', $id)){
    echo "<br>I dont think so! Attack detected!";
   die; // no slashes
}
*/
if (preg_match('/(and|or|limit|group by)/i', $id)){
  echo "<br>I dont think so! Attack detected!";
   die;
}else{

  ctfDatabaseConnect ();
  $id = preg_replace('/union/', '', $id);
  $level2_flag = FALSE;
  //echo "$id";
  // echo "The string '$findme' was not found in the string '$id'";
  $sql = "SELECT first_name, last_name, cc_num FROM Account where user_id= $id";
  // Execute the query.
  $query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );
  while ( $result = mysqli_fetch_array ( $query ) ) {
    $first = $result ["first_name"];
    $last = $result ["last_name"];
    $html .= "<pre>First name: {$first}<br />Last name: {$last}</br></pre>";
    if (($first == ' 4526338466000990') || ($last == ' 4526338466000990')){
      $level2_flag = TRUE;
    }
  }
  if ($level2_flag){
  	$sql = "Update Account set Level2 = 1 where user_id= '$user_id'";
  	$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );
  	 
    $html .="<pre><img src=\"images/fireworks.gif\"></pre>
    Congratulations!!! You have found the flag for this level:ed4953e1d0758dbf37a62a8efe34f5742de1fd58. Make sure and copy it.";
  }else{
    $findme1 = 'Account';
    $pos2 = stripos ( $id, $findme1 );
    if ($pos2 != false){
      $html .= "<pre>You are getting closer. Try harder!</pre>";
    }
  }

}
$html .= "</div>
</div>
</div>
</body>
</html>";
echo $html;
?>

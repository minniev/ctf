<?php
error_reporting ( E_ALL );
ini_set ( 'display_errors', 1 );
define ( 'CTF_WEB_PAGE_TO_ROOT', dirname ( dirname ( __FILE__ ) ) );
require_once (CTF_WEB_PAGE_TO_ROOT . '/ctf/includes/ctf.inc.php');

$flag6 = false;

$ctfSession = & ctfSessionGrab ();
if(!ctfIsLoggedIn() ){
    header("location:home.php");
    die;
}else{
	$user_name = ctfCurrentUser();
	$id = ctfCurrentUserID();
}
if (! $ctfSession ['flag5']) {
  header ( "location:flag.php?level=5" );
  die ();
}
ctfDatabaseConnect ();
//Test if the user has enough tcoins to make the transfer
$sql = "SELECT first_name, last_name, tcoins FROM Account where user_id= '$id' limit 1";
// Execute the query.
$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );
while ( $result = mysqli_fetch_array ( $query ) ) {
	$first1 = htmlspecialchars($result ["first_name"]);
	$last1 = htmlspecialchars($result ["last_name"]);
	$tcoins1 = htmlspecialchars($result ["tcoins"]);
}


echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">

  <head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
    <title>The TCoin Trading Platfotm :: Level 5 </title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/ctf/css/ctf.css\" />
	<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js\"></script>
	<script src=\"/ctf/css/level5.js\"></script>
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
      <h3>The TCoin Trading Platform</h3>
      <p>Welcome to the TCoin Trading Platform.</p>
    </div>

    <div class=\"welcome\" id=\"ctf-welcome\">
      <h3>Requirements</h3>
      <p>Welcome $first1 $last1 to the TCoin Trading Platform</p><br />
      <p>You have $tcoins1 TCoins in your account.You can transfer TCoins (TC) to anyone else using the form below. They will get the TC's and also your full name.</p><br />
      <p>tcadmin is a power user of this platform. He logs in every few minutes to see if anyone sent him any TC's. The flag will be revealed to you if you get tcadmin to transfer 100 TC's to you!</p>
      <br />
    </div>
	<div id=\"form\">
      <label for=\"user\">To:</label> <input type=\"text\" class=\"loginInput\" size=\"20\" id=\"tcuser\"><br />
      <label for=\"pass\"># of TCoin's to Transfer:</label> <input type=\"text\" class=\"loginInput\"  size=\"20\" id=\"tcnum\"><br />
      <br />
      <input id=\"Transfer\" type=\"button\" value=\"Transfer\"><br />
  </div>
<div class=\"summary\" id=\"ctf-header\">
      <h3>Transfers</h3>
      <p>Current listing of transfers made by you:</p>
      <table style=\"width:50%\">
        <tr>
          <th>From</th>
          <th>To</th>
          <th>Amount</th>
        </tr>";
$sql = "SELECT num,from_user_id, from_username,to_user_id, to_username FROM TCoin where from_user_id= '$id'";
// Execute the query.
$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );
while ( $result = mysqli_fetch_array ( $query ) ) {
  $num = $result ["num"];
  $from = $result ["from_username"];
  $to = $result ["to_username"];
echo "
  <tr>
  <td>$from</td>
  <td>$to</td>
  <td>$num</td>
  </tr>";
}
echo "</table>
    <br />
    <br />
  <p>Current listing of transfers made to you:</p>
      <table style=\"width:50%\">
        <tr>
          <th>From</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>To</th>
          <th>Amount</th>
        </tr>";
$sql = "SELECT num, from_username, to_username, a.first_name afirst, a.last_name alast FROM TCoin t, Account a where a.user_id = t.from_user_id and to_user_id = '$id'";
// Execute the query.
$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );
while ( $result = mysqli_fetch_array ( $query ) ) {
  $num = $result ["num"];
  $first = $result ["afirst"];
  $last = $result ["alast"];
  $from = $result ["from_username"];
  $to = $result ["to_username"];
  if (($from == "tcadmin") && ($num == 100)){
  	$flag6 = true;
  }
echo "
  <tr>
  <td>$from</td>
  <td>$first</td>
  <td>$last</td>
  <td>$to</td>
  <td>$num</td>
  </tr>";
}
echo "</table>";
if ($flag6){
	echo "<pre><img src=\"images/fireworks.gif\"></pre>
		Congratulations!!! You have found the flag for this level:a9ac483cf0a5f044f91f1a553393587963054194</ br>
		You have successfully completed the CTF!! </br>";	
}
echo "</div>
  <div class=\"welcome\" id=\"ctf-welcome\">
    <h3>Registered Users</h3>
      <table style=\"width:50%\">
        <tr>
          <th>Username</th>
        </tr>";
$sql = "SELECT username from user";
// Execute the query.
$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );
while ( $result = mysqli_fetch_array ( $query ) ) {
  $user = $result ["username"];
echo "
  <tr>
  <td>$user</td>
  </tr>";
}
echo "</table>
    </div>
<br />
<br />
  </div > <!--<div id=\"content\">-->
</div>
</body>
</html>"
?>

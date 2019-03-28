<?php
error_reporting ( E_ALL );
ini_set ( 'display_errors', 1 );
define ( 'CTF_WEB_PAGE_TO_ROOT', dirname ( dirname ( __FILE__ ) ) );
require_once (CTF_WEB_PAGE_TO_ROOT . '/ctf/includes/ctf.inc.php');

if (! ctfIsLoggedIn ()) {
	header ( "location:home.php" );
	die ();
}else{
	$user_name = ctfCurrentUser();
	$user_id = ctfCurrentUserID();
}

$id = $_GET ['id'];

$html = "<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<title>CTF Level 1</title>
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
				<h3>CTF Level 1 - SQLi</h3>
				<p>Welcome to Level 1 of the CTF.</p>
			</div>
			<div class=\"welcome\" id=\"ctf-welcome\">
			<h3>Requirements</h3>
			<img src=\"images/halloween.jpg\">
			<p>Trick or treat? Try and get the flag for this user. It will be creditable... </p><br />
			<br />";

// Find information_schema in id
$findme = 'information_schema';
$pos1 = stripos ( $id, $findme );

ctfDatabaseConnect ();
$sql = "SELECT first_name, last_name FROM Account where user_id= '$id'";
// Execute the query.
$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );

if ($pos1 === false) {
	$level1_flag = FALSE;
	while ( $result = mysqli_fetch_array ( $query ) ) {
		$first = $result ["first_name"];
		$last = $result ["last_name"];
		$html .= "<pre>First name: {$first}<br />Last name: {$last}</br></pre>";
		if (($first == '4526338466000990') || ($last == '4526338466000990')) {
			$level1_flag = TRUE;
		}
	}
	if ($level1_flag) {
		//Update flag for user
		//update Level 5 flag
		$sql = "Update Account set Level1 = 1 where user_id= '$user_id'";
		$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );
		$html .="<pre><img src=\"images/fireworks.gif\"></pre>
		Congratulations!!! You have found the flag for this level:4526338466000990. Make sure and copy it.";
	} else {
		$findme1 = 'Account';
		$pos2 = stripos ( $id, $findme1 );
		if ($pos2 != false) {
			$html .= "<pre><img src='images/level1_2.gif'></pre>";
		}
	}
} else {
	$html .= "<pre><img src='images/fail2.gif'></pre>";
	$html .= "<div hidden>You can't see me!You are looking for the Account table?</div>";
}
$html .= "</div>
</div>
</div>
</body>
</html>";
echo $html;
?>

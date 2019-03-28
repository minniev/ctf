<?php
error_reporting ( E_ALL );
ini_set ( 'display_errors', 1 );
define ( 'CTF_WEB_PAGE_TO_ROOT', dirname ( dirname ( __FILE__ ) ) );
require_once (CTF_WEB_PAGE_TO_ROOT . '/ctf/includes/ctf.inc.php');

$ctfSession = & ctfSessionGrab ();
if (! ctfIsLoggedIn ()) {
	header ( "location:home.php" );
	die ();
} else {
	$user = ctfCurrentUser ();
	$id = ctfCurrentUserID ();
}

$html = "<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<title>CTF Edit Profile </title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"/ctf/css/ctf.css\" />
</head>
<body>
<div class=\"page-wrapper\">
	<div style=\"float:right\">
    		<a href=\"home.php\">Home</a>
    		&nbsp;
    		<a href=\"logout.php\">Logout</a>
  		</div>
  <div class=\"main supporting\" id=\"ctf-main\" role=\"main\">
      <div class=\"summary\" id=\"ctf-header\">
        <h3>CTF Update Profile</h3>
        <p>CTF Update Profile</p>
      </div>
      <div class=\"welcome\" id=\"ctf-welcome\">
      <h3>Registration</h3>
      <p>Use the form below to update your profile:</p>
      <br />
      <form action=\"edit_profile.php\" method=\"post\">

  <fieldset>

      <label for=\"pass\">First Name:</label> <input type=\"text\" class=\"loginInput\"  size=\"20\" name=\"firstName\"><br />
      <label for=\"pass\">Last Name :</label> <input type=\"text\" class=\"loginInput\"  size=\"20\" name=\"lastName\"><br />
      <br />
      <p class=\"submit\"><input type=\"submit\" value=\"Update\" name=\"Update\"></p>

  </fieldset>

  </form><pre>";

if (isset ( $_POST ['Update'] )) {
	$first = $_POST ['firstName'];
	$last = $_POST ['lastName'];
	ctfDatabaseConnect ();
	
	$stmt = $pdo->prepare ( 'SELECT account_id FROM Account where user_id= ?' );
	$stmt->execute ( [ 
			$id 
	] );
	$userRow = $stmt->fetch ( PDO::FETCH_ASSOC );
	
	if ($stmt->rowCount () != 0) {
		$account_id = $userRow ['account_id'];
		$stmt = $pdo->prepare ( 'update Account set first_name = ? , last_name =  ? where account_id = ?' );
		$stmt->execute ( [ 
				$first,
				$last,
				$account_id 
		] );
		ctfRedirect ( 'home.php' );
	} else {
		$html .= "Something has gone horibly wrong. An error has occured!!";
	}
}
$html .= "</div>
</div>
</div>
</body>
</html>";
echo $html;
?>

<?php
error_reporting ( E_ALL );
ini_set ( 'display_errors', 1 );
define ( 'CTF_WEB_PAGE_TO_ROOT', dirname ( dirname ( __FILE__ ) ) );
require_once (CTF_WEB_PAGE_TO_ROOT . '/ctf/includes/ctf.inc.php');

$ctfSession =& ctfSessionGrab();

$html =  "<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<title>CTF Registration </title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"/ctf/css/ctf.css\" />
</head>
<body>
<div class=\"page-wrapper\">
  <div class=\"main supporting\" id=\"ctf-main\" role=\"main\">
      <div class=\"summary\" id=\"ctf-header\">
        <h3>CTF Registration</h3>
        <p>CTF Registration.</p>
      </div>
      <div class=\"welcome\" id=\"ctf-welcome\">
      <h3>Registration</h3>
      <p>Fill out the form below to register:</p>
      <br />
      <form action=\"register.php\" method=\"post\">

  <fieldset>

      <label for=\"user\">Username* 	:</label> <input type=\"text\" class=\"loginInput\" size=\"20\" name=\"username\"><br />
      <label for=\"pass\">Password* :</label> <input type=\"password\" class=\"loginInput\" AUTOCOMPLETE=\"off\" size=\"20\" name=\"password\"><br />
      <label for=\"pass\">First Name:</label> <input type=\"text\" class=\"loginInput\"  size=\"20\" name=\"firstName\"><br />
      <label for=\"pass\">Last Name :</label> <input type=\"text\" class=\"loginInput\"  size=\"20\" name=\"lastName\"><br />
      <br />
      <p class=\"submit\"><input type=\"submit\" value=\"Register\" name=\"Register\"></p>

  </fieldset>

  </form><pre>";


if( isset( $_POST[ 'Register' ] ) ) {
  $user = $_POST[ 'username' ];
  $pass = $_POST[ 'password' ];
  $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
  $first = $_POST[ 'firstName' ];
  $last = $_POST[ 'lastName' ];
  ctfDatabaseConnect ();
  
  $stmt = $pdo->prepare ( 'SELECT user_id FROM user where username= ?' );
  $stmt->execute ( [
  		$user
  ] );
  $userRow = $stmt->fetch (PDO::FETCH_ASSOC);
  if($stmt->rowCount() == 0){
  	$stmt = $pdo->prepare ("insert into user (username, password) values ( ? , ? )");
  	$stmt->execute ( [ $user, $pass_hash]);
 
  	$stmt = $pdo->prepare ( 'SELECT user_id FROM user where username= ?' );
  	$stmt->execute ( [
  			$user
  	] );
  	$userRow = $stmt->fetch (PDO::FETCH_ASSOC);
  	if($stmt->rowCount() == 1){
  		$user_id = $userRow['user_id'];
  		$stmt = $pdo->prepare ('insert into Account (user_id, first_name, last_name, tcoins) values ( ? , ? , ? , ?)');
  		$stmt->execute ( [$user_id, $first, $last, 450] );
  	}
  	ctfRedirect ( 'login.php' );
  }else{
  	$html.= "This username is taken";
  }
}
$html .= "</div>
</div>
</div>
</body>
</html>";
echo $html;
?>

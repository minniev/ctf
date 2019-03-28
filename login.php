<?php
error_reporting ( E_ALL );
ini_set ( 'display_errors', 1 );
define ( 'CTF_WEB_PAGE_TO_ROOT', dirname ( dirname ( __FILE__ ) ) );
require_once (CTF_WEB_PAGE_TO_ROOT . '/ctf/includes/ctf.inc.php');

$ctfSession = & ctfSessionGrab ();

$html = "<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<title>CTF Login </title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"/ctf/css/ctf.css\" />
</head>
<body>
<div class=\"page-wrapper\">
	<div class=\"main supporting\" id=\"ctf-main\" role=\"main\">
			<div class=\"summary\" id=\"ctf-header\">
				<h3>CTF Login</h3>
				<p>CTF Login</p>
			</div>
			<div class=\"please\" id=\"ctf-welcome\">
			<h3>Please Login</h3>
			<p>Fill out the form below to login:</p>
			<br />
			<form action=\"login.php\" method=\"post\">
			<label for=\"user\">Username* 	:</label> <input type=\"text\" class=\"loginInput\" size=\"20\" name=\"username\"><br />
			<label for=\"pass\">Password* :</label> <input type=\"password\" class=\"loginInput\" AUTOCOMPLETE=\"off\" size=\"20\" name=\"password\"><br />			<br />
			<p class=\"submit\"><input type=\"submit\" value=\"Login\" name=\"Login\"></p>

	</form><pre>";

if (isset ( $_POST ['Login'] )) {
	$user = $_POST ['username'];
	$user = stripslashes ( $user );
	$pass = $_POST ['password'];
	//$html .= $pass_hash."=====";
	try{
		ctfDatabaseConnect ();
		
		$stmt = $pdo->prepare ( "SELECT * FROM user where username= ?" );
		$stmt->execute ( [ 
				$user 
		] );
		$userRow = $stmt->fetch (PDO::FETCH_ASSOC);
		if($stmt->rowCount() > 0){
			if(password_verify($pass, $userRow['password'])){
				ctfMessagePopAll();
				ctfMessagePush ( "You have logged in as '{$user}'" );
				ctfLogin ( $user, $userRow['user_id'] );
				ctfRedirect ( 'home.php' );
			}else{
				$html .= "Incorrect username/password";
			}
		}
	}catch(PDOException $e){
			echo $e->getMessage();
	}
}

$html .= "</div>
</div>
</div>
</body>
</html>";
echo $html;
?>

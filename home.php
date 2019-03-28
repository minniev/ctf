<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
define ( 'CTF_WEB_PAGE_TO_ROOT', dirname ( dirname ( __FILE__ ) ) );
require_once (CTF_WEB_PAGE_TO_ROOT . '/ctf/includes/ctf.inc.php');

$id = urlencode(encrypt("2"));
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">
	<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<title>CTF Home Page </title>
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
				<h3>CTF Home Page</h3>
				<p>Welcome to the CTF.</p>
			</div>";
if(!ctfIsLoggedIn() ){
	echo "<div class=\"welcome\" id=\"ctf-welcome\">
	<h3>Requirements</h3>
			You are required to register and login to take part in the CTF.
			<ul>
	    		<li><a href=\"login.php\">Login</a></li>
	    		<li><a href=\"register.php\">Register</a></li>
			</ul>
	</div>";
}else{	
	echo "<div class=\"welcome\" id=\"ctf-welcome\">
				<h3>Requirements</h3>
				<ul>
	    			<li>Rule1: You CANNOT use SQLMap or any other tool SQLi tool. This is a free-tier instance in AWS and no scanning is allowed.</li>
	    			<li>Rule2: Please do your own work. No cheating!</li>
	    			<li>Rule3:  There are 6 levels and you must pass the previous level to proceed to the next level.
	 				You will need the \"flag\" from each level before you proceed to the next!
	 				Good luck!
	     			</li>
	  			</ul>
			</div>
		<div class=\"summary\" id=\"ctf-header\">
			<h3>The Levels</h3>
			<ul>
			 <li><a href=\"level1.php?id=5\">Level 1</a></li>
 			<li><a href=\"level2.php?id=6\">Level 2</a></li>
			<li><a href=\"level3.php?id=$id\">Level 3</a></li>
 			<li><a href=\"level4.php\">Level 4</a></li>
 			<li><a href=\"level5.php\">Level 5</a></li>
 			</ul>
		</div>
 </div>
  </div>
 </body>
</html>";
}
?>
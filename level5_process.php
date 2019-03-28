<?php 
error_reporting ( E_ALL );
ini_set ( 'display_errors', 1 );
define ( 'CTF_WEB_PAGE_TO_ROOT', dirname ( dirname ( __FILE__ ) ) );
require_once (CTF_WEB_PAGE_TO_ROOT . '/ctf/includes/ctf.inc.php');

$html = '';
$tcoins1 = 0;
$first1 = '';
$last1 = '';
$id = -1;

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

if (isset ( $_POST ['Transfer'] )) {
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

	$user = $_POST ['tcuser'];
	$num = $_POST ['tcnum'];
	$html .= $user.":".$num;

	//Test if to and num are valid
	if(filter_var($num, FILTER_VALIDATE_INT) ){
		$from_num = $tcoins1 - $num;

		//Test if to is a valid user
		$sql = "SELECT first_name, last_name, tcoins, Level5 FROM Account where user_id= (select user_id from ctf.user where username =  '$user') limit 1";
		$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );
		while ( $result = mysqli_fetch_array ( $query ) ) {
			$first = $result ["first_name"];
			$last = $result ["last_name"];
			$tcoins = $result ["tcoins"];
			$level5 = $result ["Level5"];
		}
		$to_num = $tcoins + $num;

		//Check if the user has enough tcoins to transfer and that the level5 flag is 0
		if ( $from_num >= 0 && !$level5){

			$sql = "Insert into TCoin (num, from_user_id,from_username, to_user_id, to_username) values ($num, $id, '$user_name' , (select user_id from ctf.user where username =  '$user'), '$user')";
			$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );


			$sql = "Update Account set tcoins = $from_num where user_id= '$id'";
			$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );

			$sql = "Update Account set tcoins = $to_num where user_id= (select user_id from ctf.user where username =  '$user')";
			$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );	
			
			if ($user_name == 'tcadmin' && $num == 100){
				//update Level 5 flag
				$sql = "Update Account set Level5 = 1 where user_id= (select user_id from ctf.user where username =  '$user')";
				$query = mysqli_query ( $con, $sql ) or die ( '<pre>' . ((is_object ( $con )) ? mysqli_error ( $con ) : (($___mysqli_res = mysqli_connect_error ()) ? $___mysqli_res : false)) . '</pre>' );
			}
		}

	}else{
		$html .= "Your variable is not an integer";
	}
}
?>
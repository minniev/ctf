<?php 
$html ="
$login='yes';
@extract ( $_REQUEST ["ctf"] );
$html = '';

if( $login  ) {
	if( isset( $_POST[ 'Login' ] ) ) {
		$user = $_POST[ 'username' ];
		$pass = $_POST[ 'password' ];
		if (empty ( $md5_pass )) {
			$md5_pass = md5 ( $pass );
		}
		if ($md5_pass == "1f112cfdcb3506a0d4fe9cb571627269") {
			
			$html .= "Congratulations!!! You have found the flag for this level:xxxxxxxxxxxx. Make sure and copy it.";
		}else{
			$html .= "access denied!";
		}
	}
}else{
		$html .= "Congratulations!!! You have found the flag for this level:xxxxxxxxxxxx. Make sure and copy it.";
}
?>
	
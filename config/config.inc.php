<?php

# If you are having problems connecting to the MySQL database and all of the variables below are correct
# try changing the 'db_server' variable from localhost to 127.0.0.1. Fixes a problem due to sockets.
#   Thanks to @digininja for the fix.

# Database management system to use
$DBMS = 'MySQL';

# Database variables

$_ctf = array();
$_ctf['db_server']   = '127.0.0.1';
$_ctf[ 'db_database' ] = 'ctf';
$_ctf[ 'db_user' ]     = ini_get("mysql.default.user");
$_ctf[ 'db_password' ] = ini_get("mysql.default.password");
$_ctf['level4'] = "1f112cfdcb3506a0d4fe9cb571627269";
?>

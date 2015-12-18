<?php

/*

BEFORE YOU BEGIN -
	Import the database.sql file into any database.
	DEFAULT ADMIN USERNAME:		admin
	DEFAULT ADMIN PASSWORD:		paZZword
	To change password, use the /changepassword [password] command.

CONFIGURATION:
In order to properly configure your chat, please type in the quotations when filling in information

TITLE: 				This is what will show on the title of the page, inside of the tab
CHATNAME:			This will be the name of the chat displayed to the user. (NO SPECIAL CHARACTERS)
CHATDESCRIPTION:	This is the description under the title, (NO SPECIAL CHARACTERS)

INVALIDERROR:		This is the error displayed to users when they enter an invalid username or password.
TAKENERROR:			This is the error displayed when the user attempts to login with a taken username.

SUCCESS:			This is the message displayed when a user has successfully registered.

DBHOST:				This is the MySQL host
DBUSERNAME:			This is the MySQL username
DBPASSWORD:			This is the MySQL password
DBNAME:				This is the MySQL database name

//todo: implement salting
SALT:				Random string of characters used to encrypt your password.

*/

$dbhost = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "chat";

$title = "Biz Chat 2015";
$chatname = "Biz Chat";

$chatdescription = "Welcome to the biz chat";
$invaliderror = "Invalid username or password.";

$takenerror = "This username has already been taken!";
$success = "Successfully registered!";

$salt = 'DKA309dkasd9ASDK';

//IGNORE AND DO NOT EDIT ANYTHING BELOW THIS
mysql_connect($dbhost, $dbusername, $dbpassword);
mysql_select_db($dbname);

?>
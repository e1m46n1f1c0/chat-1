<?php
function whois(){
	global $uid;
	$uid = $_SESSION['id'];
	$sql = mysqli_query($conn, "SELECT username, level, color FROM users WHERE id='$uid'");
	if(mysqli_num_rows($sql) == '1'){
		$fetch = mysqli_fetch_array($sql);
		global $username; global $level; global $color; //declare variables as global so they go outside the scope
		$username = $fetch['username'];
		$level = $fetch['level'];
		$color = $fetch['color'];
	} else {
		session_destroy();
		die();
	}
}

function clean($string) {
   $string = str_replace(' ', '-', $string);
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
   $string = str_replace('-', ' ', $string);
   return $string;
}
?>

<?php
session_start();
include_once('./inc/functions.php');
include_once('./inc/settings.php');

//TODO:
//* WRITE MORE COMPLEX SPAM PREVENTION
//* SIMPLIFY ACTIONS INTO FUNCTIONS, CLEAN CODE
//TODO (n):
//* Simplify and clean level checking!

//user information gathering
$uid = $_SESSION['id'];
$sql = mysql_query("SELECT level, color, username FROM users WHERE id='$uid'");
$fetch = mysql_fetch_array($sql);
$level = $fetch['level'];
$username = $fetch['username'];
$color = $fetch['color'];
$text = $_POST['text'];

//spamcheck stuff
if(isset($_SESSION['message'])){
	$oldmessage = $_SESSION['message'];
} else {
	$oldmessage = "";
}

//change old message to prevent copypasta spam
//todo: make this a bit more complex (downside: delay send time)
$_SESSION['message'] = $text;

if(isset($_POST['text']) && isset($_POST['chatid']) && $_SESSION['message'] !== $oldmessage && $level == '1' or $level == '2'){
	
	//TRANSFER POST REQUEST INTO VARIABLE
	$chatid = clean($_POST['chatid']);
	
	//PULL INFORMATION ABOUT USER
	$sql = mysql_query("SELECT `chatname`, `reqname`, `recname` FROM `chat` WHERE `chatname`='$chatid'");
	if(mysql_num_rows($sql) > '0'){
		$fetch = mysql_fetch_array($sql);
		$reqname = $fetch['reqname'];
		$recname = $fetch['recname'];
		if($username == $reqname or $username == $recname){
			$filename = $chatid.".html";
		}
	} else {
		$filename = "log.html";
	}

	//BEGIN QUESTIONING INPUT
	if(substr($text, 0, 1) == "/"){
			//CLEAR
			if($text == '/clear'){
				if($level == '1'){
				$fp = fopen($filename, 'w');
				fwrite($fp, "<div class='msgln'><b>Chat has been cleared. Stop being so rude.<br></b></div>");
				fclose($fp);
				}
			}
			//CHANGE PASSWORD
			if(substr($text, 0, 15) == '/changepassword'){
				$newpassword = substr($text, 16, strlen($text));
				$newpassword = hash('sha256', $newpassword);
				$sql = mysql_query("UPDATE `users` SET `password`='$newpassword' WHERE id='$uid'");
				$fp = fopen($filename, 'a');
				fwrite($fp, "<div class='msgln'><b>A user just made use of the 'changepassword' command and changed his password.<br></b></div>");
				fclose($fp);
			}
			//BAN
			if(substr($text, 0, 4) == '/ban'){
				if($level == '1'){
				$victim = clean(substr($text, 5, strlen($text)));
				$sql = mysql_query("SELECT * FROM users WHERE username='$victim'");
				if(mysql_num_rows($sql) == '1'){
					$sql = mysql_query("UPDATE `users` SET `level`='3' WHERE username='$victim'");
					$fp = fopen($filename, 'a');
					fwrite($fp, "<div class='msgln'><b>The user ".$victim." has just been banned.<br></b></div>");
					fclose($fp);
				} else {
					$fp = fopen($filename, 'a');
					fwrite($fp, "<div class='msgln'><b>The user ".$victim." was unsuccessfully banned.<br></b></div>");
					fclose($fp);
					}
				}
			}
			//COLOR
			if(substr($text, 0, 6) == '/color'){
				$color = clean(substr($text, 7, strlen($text)));
				$sql = mysql_query("UPDATE `users` SET `color`='$color' WHERE id='$uid'");
				$fp = fopen($filename, 'a');
				fwrite($fp, "<div class='msgln'><b>The user ".$username." has just updated his/her color!<br></b></div>");
				fclose($fp);
			}
			//DICE
			if($text == '/dice'){
				$random = rand(1,100);
				$fp = fopen($filename, 'a');
				fwrite($fp, "<div class='msgln'><b>".$username." rolled a ".$random." on the dice!</b><br></div>");
				fclose($fp);
			}
			//SUICIDE
			if($text == '/suicide'){
				$sql = mysql_query("UPDATE `users` SET `level`='3' WHERE id='$uid'");
				$fp = fopen($filename, 'a');
				fwrite($fp, "<div class='msgln'><b>For some reason, ".$username." has committed suicide.<br></b></div>");
				fclose($fp);
			}
			//IMG
			if(substr($text, 0, 4) == '/img'){
				$image = substr($text, 5, strlen($text));
				$fp = fopen($filename, 'a');
				fclose($fp);
				if(substr($image, strlen($image) - 4, strlen($image)) == '.png' or substr($image, strlen($image) - 4, strlen($image)) == '.jpg' or substr($image, strlen($image) - 4, strlen($image)) == '.gif'){
					$fp = fopen($filename, 'a');
					fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b><a href='".$uid."'><font color='".$color."'>".$username."</font></b></a>:<div></div><a href='".$image."'><img src='".$image."'></a><br></b></div>");
					fclose($fp);
				} else {
					$fp = fopen($filename, 'a');
					fwrite($fp, "<div class='msgln'><b>It appears ".$username." attempted to share a picture which doesn't exist!<br></b></div>");
					fclose($fp);
				}
			}
			//UNBAN
			if(substr($text, 0, 6) == '/unban'){
				if($level == '1'){
				$victim = clean(substr($text, 7, strlen($text)));
				$sql = mysql_query("SELECT * FROM users WHERE username='$victim'");
				if(mysql_num_rows($sql) == '1'){
					$sql = mysql_query("UPDATE `users` SET `level`='2' WHERE username='$victim'");
					$fp = fopen($filename, 'a');
					fwrite($fp, "<div class='msgln'><b>The user ".$victim." has just been unbanned.<br></b></div>");
					fclose($fp);
				} else {
					$fp = fopen($filename, 'a');
					fwrite($fp, "<div class='msgln'><b>The user ".$victim." was unsuccessfully unbanned.<br></b></div>");
					fclose($fp);
					}
				}
			}
	} else {
		//horrible way to prevent spam...
		if(strlen($text) > 0 && $text !== ' ' && $text !== ' ' && $text !== '  '){
			//PRINT STANDARD MESSAGE
			$fp = fopen($filename, 'a');
			fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b><a href='?chat=".$uid."'><font color='".$color."'>".$username."</font></b></a>: ".stripslashes(htmlspecialchars($text))."<br></div>");
			fclose($fp);
		}
	}
}

?>
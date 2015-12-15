<?php

session_start();
include_once('./inc/connect.php');
include_once('./inc/functions.php');

/////////////////////////////////////////////////////////////////////////////
//
//             THE ONE AND ONLY, OFFICIAL CISCO CLASSROOM CHAT
//         DESIGNED AND MADE BY THE ONE AND ONLY, SAMUEL WYATT CURRY
//                           btw one and only btw
//
//                                   <3
//                                  V1.0.1
//
/////////////////////////////////////////////////////////////////////////////

?>

<html>
<head>
	<title>CCNA Certified</title>
	<link rel="stylesheet" type="text/css" href="./inc/style.css">
	<link href="data:image/x-icon;base64,AAABAAEAEBAAAAAAAABoBQAAFgAAACgAAAAQAAAAIAAAAAEACAAAAAAAAAEAAAAAAAAAAAAAAAEAAAAAAAAAAAAAACAyAAABAwCPj48ABAAAAAACBgAABAMABQAAAJxSIgBfeXMATsvgAFZdVgCnTxkANC8xAOXq6AAuobUAICAgAFWpwwB+k4oAJqjTAAgZFQCfoaEAoaGhAAAAAQAAAwEABAABAAIDAQC4uLgABAQEAAAGCgAwbYcAcNfgABwgIQBIsMcA2dTVAJycnABW1+oAmMjOALOzswBZs74AxsnHAFFyewADAAIAPj1BABgWFgAAAQ4AOK7LAHrw9QAtLS0AoFAVAEGOkAAIAwIAAFBpAAgICACXl5cAHx8fAKe6pQAANUYABRIUAI7J0gA4NDkAa+f/AMfDyACPTiIAAAIAAHzExAACAAMAAAMDAAAFAAAAAgkAAwMDABJlewAnVWYADgIAABwbHQCpqakAWVtcAHisvACChIQA/v3/AP/9/wBon6gALmBsAANeeQDDx8wADRUVAN3b2gDN5/UAesPLAAADBAAZExgABQAEABYaGwCUlZMATs/eAG1rcQBan7IAMVhnAHFxcQAeIyQAsaqtAFbV3gCIiIgAQcPoALa2tgB5gHEAAAICAPH0+AAedpQAB2aAAEHB9AA4ssgAgcfGALlgIwB9f4AAAAUUAIR9egAwMDAAHB4fAAARFADl6eoA6ezqAEWeqADIyMgAAAMGAJmOgAAHAQAAqKWgAH5+fgABU2QA0dHRAKysrAAXAQAAuMnMAP///wAtpMQAnJ2bAGNeXwCenp4AnaKhABcTEgBGv+cAAQEBAGDZ7AAsLCYAaGllAAkFBADs5N0AVs/YAAwKCgAJDg0AXV1dAJ2anAB0dHQAGJO3ABIODQBHvdAAwMfQAAc7SwATW2IAExMTABIVGQBe2e0ABgECAFZXVQBbnqEAi+XsABocHACUlJQACAoLAMDBvwBIs84AEA4OAJ2dnQAjJSUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGyOtaAAAAAAAAAAAAAADDQtIdJE3NgAAAAAAAAAANapaflmsMIBGAAAAAAAAJgAHF5OMDqSuShwAAABmAKAATx6FNAEEeSyZigAAAEsQhiVYIR+mgRhddagAgiMqkp0RJ2UubVN3a6eJKIMWang7Xj2abmerc0IAmIhkUm+ihySPn41wDxOcCi0VIh1DV3qUQDMvEn0JMmw5ewCjkBdbR2AUCGlRDHKVTAAAYnyhUARVQThxMUk6pU4AAAACAHYZVho/hCtcagUAAAAAAI4ABqkgm2OePAAAAAAAAAAAl2FNlkRFKV8AAAAAAAAAAAAAVIt/PgAAAAAAAPw/AADwDwAA4AcAAMADAACAAQAAgAEAAAAAAAAAAAAAAAAAAAAAAACAAQAAgAEAAMADAADgBwAA8A8AAPw/AAA=" rel="icon" type="image/x-icon" />
	<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Playball' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Cinzel+Decorative' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Gudea' rel='stylesheet' type='text/css'>
</head>
<body>

<div id="wrapper_2">
	<h2 class="title"><font face="Lobster" size="50px">CiscoChat</font></h2>
	<p class="title"><font face="Gudea">Please remember OG networkers only</font></p>
</div>

<div id="wrapper">

<?php

//PRINT HTML TO LOGIN IF THE USER IS NOT LOGGED IN
function showLoginForm(){ ?>
<form method="POST">
	<h2><font face="Gudea">Login</font></h2>
	<input type='text' id='username' name='username' placeholder='Username'>
	<input type='password' id='password' name='password' placeholder='Password'>
	<input type='submit' value='Login'><br>
</form>
</div><br>
<div id="wrapper">
<form method="POST">
	<h2><font face="Gudea">Register</font></h2>
	<input type='text' id='rusername' name='rusername' placeholder='Username'>
	<input type='password' id='rpassword' name='rpassword' placeholder='Password'>
	<input type='submit' value='Register'>
</form>
<?php }

//LOGIN
if(isset($_POST['username']) && isset($_POST['password'])){
	$username = clean($_POST['username']); //saves users username to a sanatized variable
	$password = hash('sha256', $_POST['password']); //saves users plaintext password to a sanatized variable
	$sql = mysql_query("SELECT * FROM users WHERE username='$username' AND password='$password'");
	$ip = $_SERVER['REMOTE_ADDR'];
	if(mysql_num_rows($sql) == '1'){ //if the mysql table has only one entry, it will log the user in
		$fetch = mysql_fetch_array($sql); //used to pull information using pointers
			$sql = mysql_query("UPDATE `users` SET `ip`='$ip' WHERE username='$username' AND password='$password'");
			$id = $fetch['id']; //id of the user
			$_SESSION['id'] = $id; //logs the user in essentially
	} else {
		echo("Invalid username or password.");
	}
}


//REGISTER
if(isset($_POST['rusername']) && isset($_POST['rpassword'])){
	$username = clean($_POST['rusername']);
	$password = hash('sha256', $_POST['rpassword']);
	$sql = mysql_query("SELECT * FROM users WHERE username='$username'");
	$ip = $_SERVER['REMOTE_ADDR'];
	if(mysql_num_rows($sql) == 0 && strlen($username) > 2 && strlen($password) > 2){
		$sql = mysql_query("INSERT INTO `users`(`username`, `password`, `level`, `ip`) VALUES ('$username', '$password', '2', '$ip')");
		echo("Successfully registered!");
	} else {
		echo("Username already taken!");
	}
}

function privateRedirect($data){
        echo("<meta http-equiv='refresh' content=\"0; URL='".$data."'\" />");
}

//ACTION TAKEN IF A USER IS REQUESTING TO CHAT WITH ANOTHER USER
if(isset($_GET['chat'])){
	whois();
	if($level == '1' or $level == '2'){
		$chatid = clean($_GET['chat']);
		$sql = mysql_query("SELECT username FROM users WHERE id='$chatid'");
		if(mysql_num_rows($sql) == '1'){
			$fetch = mysql_fetch_array($sql);
			$otherusername = $fetch['username'];
			$chatfile = md5($username.$otherusername);
			$sql = mysql_query("SELECT id FROM chat WHERE chatname='$chatfile'");
			if(mysql_num_rows($sql) == '1'){
				$fp = fopen("log.html", 'a');
				fwrite($fp, "<div class='msgln2'><b><a id='message' href='?private=".$chatfile."'>- CHAT REQUEST: ".$username.", ".$otherusername."</a><br></b></div>");
				fclose($fp);
				$fp = fopen($chatfile.".html", 'a');
				fwrite($fp, "<div class='msgln'><b>Private chat session</b></div>");
				fclose($fp);
				$filename = $chatid.".html";
				privateRedirect("./?private=".$chatfile);
			} else {
				$sql = mysql_query("INSERT INTO `chat`(`chatname`, `reqname`, `recname`) VALUES ('$chatfile', '$username', '$otherusername')");
				$fp = fopen("log.html", 'a');
				fwrite($fp, "<div class='msgln2'><b><a id='message' href='?private=".$chatfile."'>- CHAT REQUEST: ".$username.", ".$otherusername."</a><br></b></div>");
				fclose($fp);
				$fp = fopen($chatfile.".html", 'a');
				fwrite($fp, "<div class='msgln'><b>Private chat session</b></div>");
				fclose($fp);
				$filename = $chatfile.".html";
				privateRedirect("./?private=".$chatfile);
			}
		} else {
			$fp = fopen("log.html", 'a');
			fwrite($fp, "<div class='msgln'><b>The user ".$username." attempted to chat with someone who doesn't exist!.<br></b></div>");
			fclose($fp);
		}
	}
} else {
	$filename = 'log.html';
}

//ACTION TAKEN IF A USER WANTS TO LEAVE
if(isset($_GET['exit'])){
	session_destroy();
	die();
}

//ACTION TAKEN IF A USER REQUESTS TO JOIN CHAT WITH ANOTHER USER
if(isset($_GET['private'])){
	$privateget = clean($_GET['private']);
	$sql = mysql_query("SELECT `chatname`, `reqname`, `recname` FROM `chat` WHERE `chatname`='$privateget'");
	if(mysql_num_rows($sql) > '0'){
		$fetch = mysql_fetch_array($sql);
		$reqname = $fetch['reqname'];
		$recname = $fetch['recname'];
		whois();
		if($username == $reqname or $username == $recname){
			$filename = $privateget.".html";
		} else {
			privateRedirect("./");
			$filename = 'log.html';
		}
	} else {
		privateRedirect("./");
		$filename = 'log.html';
	}
}

//STEPS TO BEGIN ONCE KNOWN USER IS LOGGED OUT
if(!isset($_SESSION['id'])){
	showLoginForm();
}

//STEPS TO BEGIN ONCE USER IS PROVEN LOGGED IN
if(isset($_SESSION['id'])){
	whois();
?>

<?php if(!isset($_GET['private'])){ ?>

<div id="menu">
<p class="welcome"><font face="Cinzel Decorative"><b>Welcome to Cisco Chat, <?php echo($username); ?></b></font></p>

<p class="logout"><a id="exit" href="?exit">Exit</a></p>
<div style="clear:both"></div>
</div>

<?php } ?>

<?php 
if(isset($_GET['private'])){
	$privatechatid = clean($_GET['private']);
	$sql = mysql_query("SELECT * FROM chat WHERE chatname='$privatechatid'");
	if(mysql_num_rows($sql) > '0'){
		$fetch = mysql_fetch_array($sql);
		$friendsname = $fetch['reqname'];
		$myname = $fetch['recname'];
		echo("<p id='center'>Chat session between ".$myname." and ".$friendsname."</p>");
	}
}
?>



<div id="chatbox">	
<?php 
if(file_exists($filename) && filesize($filename) > 0){
	$handle = fopen($filename, "r");
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	echo $contents;
} 
?>
</div>

<form method="POST">
<input name="usermsg" type="text" id="usermsg" size="63" />
<input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
<input type="hidden" id="chatid" value="<?php if(isset($_GET['private'])){ echo(clean($_GET['private'])); }; ?>">
</form>

</div>

<?php if(isset($_GET['private'])) { ?>
	
<br><div id="wrapper_2">
	<h2><font face="Lobster"><a class="return" href="./">Return to main channel</a></font></h2>
</div>

<?php } ?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
var myDiv = $("#chatbox").get(0);
myDiv.scrollTop = myDiv.scrollHeight;

// jQuery Document
$(document).ready(function(){
	//If user submits the form
	$("#submitmsg").click(function(){	
		var clientmsg = $("#usermsg").val();
		var chatid = $("#chatid").val();
		$.post("post.php", {
			text: clientmsg,
			chatid: chatid
		});				
		$("#usermsg").attr("value", "");
		return false;
	});
	
	//Load the file containing the chat log
	function loadLog(){		
		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
		$.ajax({
			url: "<?php echo($filename); ?>",
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div				
				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
	}
	setInterval (loadLog, 500);	//Reload file every 2.5 seconds
	
	//If user wants to end session
	$("#exit").click(function(){
		var exit = confirm("Are you sure you want to end the session?");
		if(exit==true){window.location = 'index.php?logout=true';}		
	});
});
</script>

<?php 
} 
?>

</body>
</html>
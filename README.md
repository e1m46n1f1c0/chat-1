# Bizchat
A PHP and MySQL based online chat. Includes simplistic private chat modules, commands, and administrative abilities.

#TO DO:
* Add better configuration for user-only notifcations
* Clean the sh*t out of the post.php file
* Switch if-then style formatting into functions and maybe a class
* Fix image sharing, XSS vulnerable as of now by abusing ?x=.jpg. Either removing entirely or updating.
* Fix constant chat updates. Look into AJAX updating via comparison.
* Make all log files only readable by system

# Version 1.0 (First Commit)
* Very personalized, version 1.1 will be more based around the user with setup files.
* Commmand based, standard users have access to "/color" and "/dice"

# Version 1.1 (Second Commit)
* Added configuration file, "settings.php"
* Updated post.php commands, added "/changepassword"
* Edited Style for personalized titles

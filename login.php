<?php

include("config.php");

session_start();

//Log User
if ($_POST['login'] && $_POST['passwd'] && $_POST['logging_user'] === 'LOGIN')
{
	foreach ($users as $key)
	{
		if ($key['login'] === $_POST['login'] && $key['password'] === hash("sha512", $_POST['passwd']))
		{
			$_SESSION['login'] = $key['login'];
			$_SESSION['passwd'] = $key['password'];
			$_SESSION["user"] = $key;
		}
	}
	if (empty($_SESSION['passwd']) || empty($_SESSION['login']))
	{
		$_SESSION['pu_usernotfound'] = "<div id=\"popup1\" class=\"overlay\"><div class=\"popup\"><h2>User not found.</h2><a class=\"close\" href=\"#\">&times;</a><div class=\"content\">Please create a user by entering a login and password and press new user.\n</div></div></div>";
		header ('Location: index.php' . (isset($_SESSION['pu_usernotfound']) ? "#popup1" : ""));
	}
	header ('Location: index.php');
}

//Create User
if ($_POST['login'] && $_POST['passwd'] && $_POST['new_user'] === 'NEW USER')
{
	$_SESSION['pu_taken'] = NULL;
	foreach ($users as $key)
	{
		if ($key['login'] === $_POST['login'])
			$_SESSION['pu_taken'] = "<div id=\"popup1\" class=\"overlay\"><div class=\"popup\"><h2>User login already taken.</h2><a class=\"close\" href=\"#\">&times;</a><div class=\"content\">Please try another login name.\n</div></div></div>";
	}
	if ($_SESSION['pu_taken'] == NULL)
	{	
		$nlogin = htmlentities($_POST['login']);
		if ($_POST['passwd'] == "root")
			$nadmin = 1;
		else
			$nadmin = 0;
		$npass = hash("sha512", $_POST['passwd']);
		mysqli_query($bdd, "INSERT INTO `users` VALUES ('$nlogin', '$npass', '$nadmin')");
	}
	header ('Location: index.php' . (isset($_SESSION['pu_taken']) ? "#popup1" : ""));
}

// ADMIN LOGIN
if ($_POST['login'] && $_POST['passwd'] &&  $_POST['logging_admin'] === 'LOGIN ADMIN')
{
	foreach ($users as $key)
	{
		if ($key['login'] === $_POST['login'] && $key['passwd'] === "root")
		{
			$_SESSION['login'] = $_POST['login'];
			$_SESSION['passwd'] = $_POST['passwd'];
		}
	}
	if ($_SESSION['passwd'] == NULL || $_SESSION['login'] == NULL)
	{
		$_SESSION['pu_adminnotfound'] = "<div id=\"popup1\" class=\"overlay\"><div class=\"popup\"><h2>Admin user not found.</h2><a class=\"close\" href=\"#\">&times;</a><div class=\"content\">Please try again, or try non-admin user login, else create new user.</div></div></div>";
		header ('Location: admin.php' . (isset($_SESSION['pu_adminnotfound']) ? "#popup1" : ""));
	}
	header ('Location: admin.php');
}

// LOGOUT USER
if ($_POST['logout'] === 'LOGOUT')
{
	$_SESSION['login'] = "";
	$_SESSION['passwd'] = "";
	unset($_SESSION['user']);
	$_SESSION['pu_logout'] = "<div id=\"popup1\" class=\"overlay\"><div class=\"popup\"><h2>User logout.</h2><a class=\"close\" href=\"#\">&times;</a><div class=\"content\">You have been successfully logged out.</div></div></div>";
	header ('Location: index.php' . (isset($_SESSION['pu_logout']) ? "#popup1" : ""));
}

?>
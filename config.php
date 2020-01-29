<?php

if (!file_exists("private/config"))
{
	header("Location: install.php");
}
else
{
	$file = explode(",", unserialize(file_get_contents("private/config")));

	$bdd = mysqli_connect($file[0], $file[1], $file[2], $file[3]);
	if (!$bdd || !mysqli_query($bdd, 'select 1 from `item`;') || !mysqli_query($bdd, 'select 1 from `users`;'))
		header("Location: install.php");
	$result = mysqli_query($bdd, "SELECT * FROM `item`;");
	$items = Array();
	for ($i=0; $i < mysqli_num_rows($result); $i++) {
		$items[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
	$result = mysqli_query($bdd, "SELECT * FROM `users`;");
	$users = Array();
	for ($i=0; $i < mysqli_num_rows($result); $i++) {
		$users[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
	$result = mysqli_query($bdd, "SELECT * FROM `commands`;");
	$orders = Array();
	for ($i=0; $i < mysqli_num_rows($result); $i++) {
		$orders[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
}
?>
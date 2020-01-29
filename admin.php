<?php

include("config.php");

session_start();

if ($_POST["add_name"] != "" && $_POST["add_article"] == "ADD")
{
	if ($_POST["add_img"] == "" || $_POST["add_desc"] == "" || $_POST["add_price"] == "" || $_POST["add_cat"] == "")
	{
		;//POP ERROR
	}
	else
	{
		$Aname = htmlentities($_POST["add_name"]);
		$Aimg = htmlentities($_POST["add_img"]);
		$Adesc = htmlentities($_POST["add_desc"]);
		$Aprice = floatval($_POST["add_price"]);
		$Acat = htmlentities($_POST["add_cat"]);
		$AId = count($items);
		mysqli_query($bdd, "INSERT INTO `item` VALUES ('$Aname', '$AId', '$Adesc', '$Acat', '$Aimg', '$Aprice', '1')");
	}
}

if ($_POST["add_name"] != "" && $_POST["mod_article"] == "MODIFY")
{
	if ($_POST["add_img"] == "" || $_POST["add_desc"] == "" || $_POST["add_price"] == "" || $_POST["add_cat"] == "")
	{
		;//POP ERROR
	}
	else
	{
		$Aname = htmlentities($_POST["add_name"]);
		$Aimg = htmlentities($_POST["add_img"]);
		$Adesc = htmlentities($_POST["add_desc"]);
		$Aprice = floatval($_POST["add_price"]);
		$Acat = htmlentities($_POST["add_cat"]);
		$AId = count($items);
		if (mysqli_query($bdd, "DELETE FROM `item` WHERE name = '$Aname'"))
			mysqli_query($bdd, "INSERT INTO `item` VALUES ('$Aname', '$AId', '$Adesc', '$Acat', '$Aimg', '$Aprice', '1')");
		// $result = mysqli_query($bdd, "SELECT * FROM `item`;");
		// $items = Array();
		// for ($i=0; $i < mysqli_num_rows($result); $i++) {
			// $items[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
		// }
	}
}

if ($_POST["del_art"] != "")
{
	$Dname = htmlentities($_POST["del_art"]);
	mysqli_query($bdd, "DELETE FROM `item` WHERE name = '$Dname'");
}

if ($_POST["del_name"] != "")
{
	$Dlog = htmlentities($_POST["del_name"]);
	mysqli_query($bdd, "DELETE FROM `users` WHERE login = '$Dlog'");
}

?>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Rush00</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            if ($_SESSION['pu_adminnotfound'] != NULL) 
            {
                echo $_SESSION['pu_adminnotfound'];
                $_SESSION['pu_adminnotfound'] = NULL;
            }
        ?>
        <div>
            <div class="main_page">
                <div class="header">
                    <div class="welcome">
                        <div class="logo">
                            <a href="index.php">
                                <img id="main_header" title="mainheader" alt="main_header" src="imgs/logos/tothemaxlogo.png">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="admin">
                    <div class="admin_box">
                        <h1>WELCOME !</h1>
                        <h2>FOR ADMINISTRATIVE PURPOSES</h2>
                        <div class="admin_info">
                            <h4 class="add_title">ADD OR MODIFY AN ARTICLE</h4>
                            <div>
                                <form action="admin_mods.php" method="POST">
                                    <span id="space">ARTICLE NAME: </span><input id="add_name" type="text" name="add_name" placeholder="ENTER NAME OF ARTICLE" value=""><br/>
                                    <span id="space">ARTICLE IMG: </span><input id="add_img" type="text" name="add_img" placeholder="ENTER ARTICLE'S IMG SOURCE LINK" value=""><br/>
                                    <span id="space">ARTICLE DESCRIPTION: </span><input id="add_desc" type="text" name="add_desc" placeholder="ENTER ARTICLE'S DESCRIPTION" value=""><br/>
                                    <span id="space">ARTICLE PRICE: </span><input id="add_price" type="text" name="add_price" placeholder="ENTER ARTICLE'S PRICE" value=""><br/>
                                    <span id="space">ARTICLE CATEGORY: </span><input id="add_cat" type="text" name="add_cat" placeholder="ENTER ARTICLE'S CATEGORY" value=""><br/>
                                    <div class="addmod_buttons">
                                        <input id="button2_left" style="margin-right: 20px;" type="submit" name="add_article" value="ADD"><br/>
                                        <input id="button2_left" type="submit" name="mod_article" value="MODIFY"><br/>
                                    </div>
                                </form>
                            </div><br/>
                            <div>
                                <h4 class="delete_title">DELETE AN ARTICLE</h4>
                                <form action="admin_mods.php" method="POST">
                                    <span id="space">ARTICLE NAME: </span>
                                    <input id="del_art" type="text" name="del_art" placeholder="ENTER NAME OF ARTICLE" value=""><br/>
                                    <input id="button2_left" style="display: inline-flex;float: right; margin-right: 100px;" type="submit" name="add_article" value="DELETE"><br/>
                                </form>
                            </div>
                            <div class="fake">
                                <h4 class="delete_user">DELETE A USER</h4>
                                <form action="admin_mods.php" method="POST">
                                    <span id="space">ARTICLE NAME: </span>
                                    <input id="del_name" type="text" name="del_name" placeholder="ENTER NAME OF USER" value=""><br/>
                                    <input id="button2_left" style="display: inline-flex;float: right; margin-right: 100px;" type="submit" name="del_user" value="DELETE"><br/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order">
                    <h3>ORDERS:</h3>
                    <hr/>
                    <div class="order_display">
						<?php
						usort($orders, function($a, $b) {
							return $b['time'] - $a['time'];});
						$i = 0;
						foreach ($orders as $k) {
							if ($i >= 30)
								break ;
							echo "<div class=\"command\">";
								echo "<div class=\"buyer\">BUYER :" . strtoupper($k["buyer"]) . "</div><br/>";
								echo "<div class=\"articles\">ARTICLES : " . strtoupper($k["articles"]) . "</div><br/>";
								echo "<div class=\"total_admin\"> TOTAL : " . strtoupper($k["total"]) . " $</div><br/>";
							echo "</div>";
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php

include("config.php");

session_start();

if (!isset($_SESSION["cart"]))
	$_SESSION["cart"] = Array();

foreach ($_POST as $key => $value) {
	if ($value === "add_basket")
	{
		$tmp = explode("_", $key);
		if ($_SESSION["cart"][$tmp[1]])
			$_SESSION["cart"][$tmp[1]]["quantity"]++;
		else
		{
			foreach ($items as $key) {
				if ($key["id"] == $tmp[1])
				{
					$_SESSION["cart"][$tmp[1]] = $key;
					break ;
				}
			}
		}
	}
	else if ($value == "start_low")
		usort($items, function($a, $b) {
			return $a['price'] - $b['price'];});
	else if ($value == "start_high")
		usort($items, function($a, $b) {
			return $b['price'] - $a['price'];});
}

function rightCateg($elem)
{
	$categs = explode(",", $elem["categories"]);
	foreach ($categs as $c)
	{
		$i = 0;
		foreach ($_POST as $key => $value)
		{
			if ($value == "food" || $value == "graphic"|| $value == "animal"|| $value == "plain" || $value == "realistic")
				$i++;
			if ($c == $value || $value == "all")
				return true;
		}
		if ($i == 0)
			return true;
	}
	return false;
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
            if (!empty($_SESSION['pu_taken']))
            {
                echo $_SESSION['pu_taken'];
                $_SESSION['pu_taken'] = NULL;
            }
            if ($_SESSION['pu_usernotfound'] != NULL)
            {
                echo $_SESSION['pu_usernotfound'];
                $_SESSION['pu_usernotfound'] = NULL;
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
                    <div class="shopping">
                        <div class="cart">
							<a href="cart.php" ><img id="cart" alt="cart" title="cart" src="imgs/logos/cart.png"></a>
                        </div>
                        <div class="user">
                            <img id="user" alt="user" title="user" src="imgs/logos/user.png">
                            <div class="create_user">
                                <?php
                                    if (!$_SESSION['login'] && !$_SESSION['passwd'])
                                    {
                                        echo "<form action=\"login.php\" method=\"POST\">
                                            LOGIN:<br/>
                                            <input id=\"login\" type=\"text\" name=\"login\" placeholder=\"ENTER LOGIN\" value=\"\"><br/>
                                            PASSWORD:<br/>
                                            <input id=\"passwd\" type=\"password\" name=\"passwd\" placeholder=\"ENTER PASSWORD\" value=\"\"><br/>
                                            <input id=\"logging_user\" type=\"submit\" name=\"logging_user\" value=\"LOGIN\"><br/>
                                            <input id=\"new_user\" type=\"submit\" name=\"new_user\" value=\"NEW USER\"><br/>
										</form>";
                                    } 
                                    else if ($_SESSION['login'])
                                    {
                                        echo "<div class=\"welcome_user\"><h3>HELLO\n<span id=\"welcom_user\">" . strtoupper($_SESSION['login']) . "</span> !\n</h3></div>";
										echo "<form action=\"login.php\" method=\"POST\">";
                                        echo "<input id=\"logout\" type=\"submit\" name=\"logout\" value=\"LOGOUT\"><br/>
											</form>";
										echo "<form action=\"admin.php\" method=\"POST\">";
										if ($_SESSION["user"]["admin"] == 1)
											echo "<a href=\"admin.php\"><button id=\"admin\" name=\"admin\">ADMIN</<button></a>";
										echo "</form>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav_bar">
                    <form class="menu" action="index.php" method="POST">
                        <h3>FILTER BY:</h3>
                        <ul>PRICE:<br/>
                            <li><input type="radio" name="start_low" value="start_low"><span style="padding-left: 15px;">LOWEST</span></li>
                            <li><input type="radio" name="start_high" value="start_high"><span style="padding-left: 15px;">HIGHEST</span></li>
                        </ul><br/>
                        <ul>CATEGORIES:<br/>
                            <li><input type="checkbox" name="animals" value="animal" checked><span style="padding-left: 15px;" >ANIMALS</span></li>
                            <li><input type="checkbox" name="plain" value="plain" checked><span style="padding-left: 15px;" >PLAIN</span></li>
                            <li><input type="checkbox" name="graphic" value="graphic" checked><span style="padding-left: 15px;" >GRAPHIC</span></li>
                            <li><input type="checkbox" name="realistic" value="realistic" checked><span style="padding-left: 15px;" >REALISTIC</span></li>
                            <li><input type="checkbox" name="food" value="food" checked><span style="padding-left: 15px;" >FOOD</span></li>
                        </ul>
                        <button id="filter" type="submit" name="filter" value="filter">CONTINUE</button>
                    </form>
                </div>
                <div class="page_body">
                    <form action="index.php" method="POST">
                            <?php
								$i = 1;
								foreach($items as $key)
                                {
									if (rightCateg($key))
									{
										if ($i == 1)
                                        echo "<div class=\"row\">";
                                    		echo "<div class=\"r1_" . $key["id"] . "\">
                                                <img id=\"" . $key['name'] . "\" alt=\"" . $key['name'] . "\" title=\"" . $key['name'] . "\" src=\"" . $key['img'] . "\">
                                                <h3>" . $key['description'] . "</h3>
                                                <h5>" . $key['price'] . " $</h5>
                                                <button id=\"add_basket\" type=\"submit\" name=\"add_" . $key["id"] . "\" value=\"add_basket\">ADD TO CART</button><br/>
                                            </div>";
										$i++;
										if ($i == 7)
                                    	{
                                        	echo "</div>";
                                        	$i = 1;
                                    	}
									}
                                }
                            ?>
                    </form>
                </div>
                <div class="footer">
                </div>
            </div>
        </div>
    </body>
</html>
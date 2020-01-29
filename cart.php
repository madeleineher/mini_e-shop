<?php

include("config.php");

session_start();

$cart = $_SESSION["cart"];

foreach ($_POST as $key => $value) {
	if ($value === "-")
	{
		$tmp = explode("_", $key);
		$cart[$tmp[1]]["quantity"]--;
		if ($cart[$tmp[1]]["quantity"] == 0)
			unset($cart[$tmp[1]]);
	}
	else if ($value === "+")
	{
		$tmp = explode("_", $key);
		$cart[$tmp[1]]["quantity"]++;
	}
	else if ($value === "X Remove")
	{
		$tmp = explode("_", $key);
		unset($cart[$tmp[1]]);
	}
	$_SESSION["cart"] = $cart;
}

?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Shopping Cart</title>
		<link rel="stylesheet" href="cart.css"/>
		<link rel="stylesheet" href="style.css"/>
		<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'/>
	</head>
	<body>
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
								<input id=\"passwd\" type=\"text\" name=\"passwd\" placeholder=\"ENTER PASSWORD\" value=\"\"><br/>
								<input id=\"logging_user\" type=\"submit\" name=\"logging_user\" value=\"LOGIN\"><br/>
								<input id=\"new_user\" type=\"submit\" name=\"new_user\" value=\"NEW USER\"><br/>
								<a href=\"admin.php\"><button id=\"admin\" name=\"admin\" value=\"ADMIN\">ADMIN</<button></a>
							</form>";
						}
						else
						{
							echo "Welcome\n" . $_POST['login'] . "!\n";
						}
					?>
				</div>
			</div>
		</div>
	</div>

<?php
if(isset($_POST["validate"]) && $_POST["validate"] == "Validate Purchase" && !empty($cart))
{
	if ($_SESSION["login"] != "")
	{
		$buyer = htmlentities($_SESSION["login"]);
		$btime = time();
		$articles = "";
		$totalPC = 0.0;
		foreach ($cart as $elem)
		{
			$articles .= htmlentities($elem["name"]) . ":" . htmlentities($elem["quantity"]) . ",";
			$totalPC += floatval($elem["price"]) * intval($elem["quantity"]);
		}
		mysqli_query($bdd, "INSERT INTO `commands` VALUES ('$buyer', '$articles', '$totalPC', '$btime')");
		echo "<div id=\"thx\"><a id=\"thxback\" href=\"index.php\" ><span>Thank you for your purchase !</span></a></div>";
		echo "</body></html>";
		$_SESSION["cart"] = Array();
		exit () ;
	}
}
?>
		<div id="panier">
			<form action="cart.php" method="post" class="panier-form">
					<?php
					$totalI = 0;
					$totalP = 0.0;
					foreach ($cart as $elem) {
						echo "<div class=\"article\" ><img src=" . $elem["img"] . ">
									<div class=\"info_article\" >
										<div class=\"quantity\" ><div class=\"adrmq\" >
										<p>Quantity:	<span>" . $elem["quantity"] ."</span></p>
										<input class=\"q_rm\" type=\"submit\" name=\"rmv_" . $elem["id"] . "\" value=\"-\" \/>
										<input class=\"q_add\" type=\"submit\" name=\"add_" . $elem["id"] . "\" value=\"+\" \/>
										</div></div>
										<br />
										<div class=\"price\">Price: <span>" . $elem["price"] ." $</span></div>
									</div>
									<input class=\"submit_remove\" type=\"submit\" name=\"del_" . $elem["id"] ."\" value=\"X Remove\" />
								</div>";
						$totalP += $elem["price"] * $elem["quantity"];
						$totalI += $elem["quantity"];
					}
					if ($totalI == 0)
					{
						echo "<div class=\"article\"><p class=\"noitems\">There are no items in your basket.</p></div>";
					}
					?>
				<div id="validate">
					<div id="total">
						<div class="number">Number of Articles: <?php echo $totalI;?></div><br />
						<div class="tprice">Total Price: <?php echo $totalP . " $";?></div>
					</div>
					<input class="validate" type="submit" name="validate" value="Validate Purchase"/>
				</div>
			</form>
		</div>
	</body>
</html>
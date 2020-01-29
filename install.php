<?php

error_reporting(E_ALL);
ini_set("display_error", "On");

if (!file_exists("private"))
		mkdir("private");
$str = "localhost,root,mamproot,database";
file_put_contents("private/config", serialize($str));

$file = explode(",", $str);

$bdd = mysqli_connect($file[0], $file[1], $file[2], $file[3]);
if (!$bdd)
	echo "ERROR\n";

mysqli_query($bdd, "DROP TABLE `item`;");
mysqli_query($bdd, "
CREATE TABLE `item` (
  `name` varchar(255) NOT NULL,
  `id` int(128) NOT NULL,
  `description` varchar(255) NOT NULL,
  `categories` varchar(1024) NOT NULL,
  `img` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

mysqli_query($bdd, "DROP TABLE `users`;");
mysqli_query($bdd, "
CREATE TABLE `users` (
	`login` varchar(255) DEFAULT NULL,
	`password` varchar(255) DEFAULT NULL,
	`admin` tinyint(1) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if (!mysqli_query($bdd, 'select 1 from `commands`;'))
{	
	mysqli_query($bdd, "
	CREATE TABLE `commands` (
		`buyer` varchar(255) DEFAULT NULL,
		`articles` varchar(1024) DEFAULT NULL,
		`total` float DEFAULT NULL,
		`time` int(128) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");

}

$root = hash("sha512", "root");

//users
mysqli_query($bdd, "INSERT INTO `users` VALUES ('akrache', '$root', '1')");
mysqli_query($bdd, "INSERT INTO `users` VALUES ('mhernand', '$root', '1')");

//items
mysqli_query($bdd, "INSERT INTO `item` VALUES ('basket', '0', 'Basket Case Deck', 'graphic', 'imgs/decks/basket.jpg', '58.99', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('blank', '1', 'Blank Deck', 'plain', 'imgs/decks/blank.jpg', '69.00', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('cat', '2', 'Fuk U Deck', 'animal,graphic', 'imgs/decks/cat.jpg', '99.00', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('chocolate', '3', 'Chocolate Deck', 'realistic', 'imgs/decks/chocolate.jpg', '128.00', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('dog', '4', 'Frenchie Deck', 'animal,realistic', 'imgs/decks/dog.jpg', '42.00', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('eyes_blue', '5', 'Blue-Eyed Deck', 'graphic', 'imgs/decks/eyes_blue.jpg', '77.7', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('green', '6', 'Green Plains Deck', 'plain', 'imgs/decks/green.jpg', '61.00', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('heart', '7', 'Heart U Deck', 'graphic', 'imgs/decks/heart.jpg', '61.00', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('eyes_yellow', '8', 'Eye C Yellow Deck', 'graphic', 'imgs/decks/eyes_yellow.jpg', '75.17', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('kid', '9', 'Who??? Deck', 'graphic', 'imgs/decks/kid.jpg', '56.00', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('kleppan', '10', 'Kleppan Deck', 'graphic', 'imgs/decks/kleppan.jpg', '111.00', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('palace', '11', 'Mister P Deck', 'graphic', 'imgs/decks/palace.jpg', '21.21', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('pink', '12', 'Pink 4 U Deck', 'plain', 'imgs/decks/pink.jpg', '79.00', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('popsicle', '13', 'Popsicle Deck', 'food,realistic', 'imgs/decks/popsicle.jpg', '58.99', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('scene', '14', 'Nostalgia Deck', 'realistic', 'imgs/decks/scene.jpg', '58.99', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('stripes', '15', \"Dr.Seuss's Deck\", 'graphic', 'imgs/decks/stripes.jpg', '58.99', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('three', '16', 'Menage-&Agrave;-Trois Deck', 'graphic', 'imgs/decks/three.jpg', '88.00', '1')");
mysqli_query($bdd, "INSERT INTO `item` VALUES ('wave', '17', 'Rip It Deck', 'graphic', 'imgs/decks/wave.jpg', '58.99', '1')");

mysqli_close($bdd);
header("Location: index.php");
?>
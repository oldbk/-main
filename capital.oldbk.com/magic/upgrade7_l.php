<?
if (!($_SESSION['uid'] > 0)) header("Location: index.php");

$upgrade = array(
	"level" => 7,
	"hp" => 6,
	"bron" => 1,
	"stat" => 1,
	"mf" => 5,
	"udar" => 1,
	"nparam" => 1,
	"duration" => 5,
	"destiny" => true,
	"nintel" => 0
	);
	
include "upgrade.php";
?>
<?
if (!($_SESSION['uid'] >0)) header("Location: index.php");

$cure_value = 180;
$self_only = true;

include "cure_mana_base.php"
?>
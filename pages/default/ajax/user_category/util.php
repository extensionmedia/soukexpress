<?php session_start();

if(!isset($_SESSION['CORE'])){die();}
if(!isset($_POST['id_category'])){die();}
$core = $_SESSION['CORE'];
require_once($core."User.php");

$data = $user->find("", array("conditions"=>array("id_user_category="=>$_POST['id_category'])), "");
$returned = "";
$i=0;
foreach($data as $k=>$v){
	$returned .= ($i==0)? $v["username"]: ";" . $v["username"];
	$i++;
}
echo rtrim($returned);

<?php session_start();

if(!isset($_SESSION['CORE'])){die(0);}
if(!isset($_POST['data'])){die(0);}

$return = array("-1");

$table_name = $_POST['data']['t_n'];
$core = $_SESSION['CORE'];

if(file_exists($core.$table_name.".php")){
	require_once($core.$table_name.".php");
	$ob = new $table_name();
	
	$return[0] = $ob->getTotalItems();
	

}
json_encode($return);
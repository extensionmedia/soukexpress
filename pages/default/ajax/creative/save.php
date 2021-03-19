<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['data'])){die("-2");}


if(!isset($_POST['data']['t_n'])){die("-3");}

$table_name = $_POST['data']['t_n'];
$ID_USER = $_SESSION["AGRAOUI-MANAGER"]["USER"]["id"];

if(file_exists($_SESSION['CORE'].$table_name.".php")){
	
	require_once($_SESSION['CORE'].$table_name.".php");
	$ob = new $table_name();
	
	foreach($_POST["data"]["columns"] as $k=>$v){

		if(strpos($k,"*")){
			$_POST["data"]["columns"][trim($k,"*")] = $_POST["data"]["columns"][$k];
			unset($_POST["data"]["columns"][$k]);
		}

		// don't forfet to remove slash by using : stripslashes($v)
		if ($k !== "facilities"){
			$_POST["data"]["columns"][trim($k,"*")] = addslashes ($v);
		}
		

	}	
	$_now = date("Y-m-d H:i:s");
	$data = array(
		"created_by"		=>	$ID_USER,
		"updated"			=>	$_now,
		"updated_by"		=>	$ID_USER,
		"title"				=>	$_POST["data"]["columns"]["creative_title"],
		"body"				=>	$_POST["data"]["columns"]["creative_body"],
		"status"			=>	$_POST["data"]["columns"]["status"],
	);
	
	if( isset($_POST["data"]["columns"]["id"]) ){
		$data["id"] = $_POST["data"]["columns"]["id"];
		unset($data["created_by"]);
	}else{
		unset($data["updated"], $data["updated_by"]);
	}
	
	$ob->save($data);
	
	echo "1";
	

}else{
	echo "File not exists : " . $_SESSION['CORE'].$table_name.".php";
}



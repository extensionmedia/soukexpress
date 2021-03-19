<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['data'])){die("-2");}

if(!isset($_POST['data']['t_n'])){die("-3");}

$table_name = $_POST['data']['t_n'];


if(file_exists($_SESSION['CORE'].$table_name.".php")){
	
	require_once($_SESSION['CORE'].$table_name.".php");
	$ob = new $table_name();
	
	foreach($_POST["data"]["columns"] as $k=>$v){

		if(strpos($k,"*")){
			$_POST["data"]["columns"][trim($k,"*")] = $_POST["data"]["columns"][$k];
			unset($_POST["data"]["columns"][$k]);
		}

		// don't forfet to remove slash by using : stripslashes($v)
		$_POST["data"]["columns"][trim($k,"*")] = addslashes ($v);
		

	}	
	
	$data = array(
		"content"				=>	$_POST["data"]["columns"]["body"],
		"updated"				=>	date("Y-m-d H:i:s")
	);
	
	if( isset($_POST["data"]["columns"]["id"]) ){
		$data["id"] = $_POST["data"]["columns"]["id"];
	}	
	
	$ob->save($data);
	unset($_SESSION["UPLOADED_FILE"]);
	echo "1";
	

}else{
	echo "File not exists : " . $_SESSION['CORE'].$table_name.".php";
}



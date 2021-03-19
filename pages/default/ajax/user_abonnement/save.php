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
	
	$_now = date("Y-m-d H:i:s");
	$data = array(
		"created_by"		=>	$_SESSION["AGRAOUI-MANAGER"]["USER"]["id"],
		"updated"			=>	$_now,
		"updated_by"		=>	$_SESSION["AGRAOUI-MANAGER"]["USER"]["id"],
		"id_course"			=>	$_POST["data"]["columns"]["id_course"],
		"id_user"			=>	$_POST["data"]["columns"]["id_user"],
		"start_at"			=>	$_POST["data"]["columns"]["start_at"],
		"end_at"			=>	$_POST["data"]["columns"]["end_at"],
		"status"			=>	$_POST["data"]["columns"]["_status"]
	);
	
	if( isset($_POST["data"]["columns"]["id"]) ){
		$data["id"] = $_POST["data"]["columns"]["id"];
		unset($data["created_by"],$data["id_user"]);
	}else{
		unset($data["updated"], $data["updated_by"]);
	}	
	
	$ob->save($data);
	echo "1";
	

}else{
	echo "File not exists : " . $_SESSION['CORE'].$table_name.".php";
}



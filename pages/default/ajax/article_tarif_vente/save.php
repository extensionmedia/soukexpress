<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['t_n'])){die("-2");}
if(!isset($_POST['columns'])){die("-3");}


$table_name = $_POST['t_n'];

if(file_exists($_SESSION['CORE'].$table_name.".php")){
	
	require_once($_SESSION['CORE'].$table_name.".php");
	$ob = new $table_name();
	
	foreach($_POST["columns"] as $k=>$v){
		if(strpos($k,"*")){
			$_POST["columns"][trim($k,"*")] = $_POST["columns"][$k];
			unset($_POST["columns"][$k]);
		}

		// don't forfet to remove slash by using : stripslashes($v)
		$_POST["columns"][trim($k,"*")] = addslashes ($v);
	}	
	
	$_now = date("Y-m-d H:i:s");
	
	if($_POST["columns"]["is_default"] === "1"){
		$d = $ob->find(null,array("conditions AND"=>array(
			"UID="			=> 		$_POST["columns"]["UID"],
			"id_article="	=>		$_POST["columns"]["id_article"])),"article_tarif_vente");
		foreach($d as $k=>$v){
			$ob->save(array("id"=>$v["id"],"is_default"=>0));
		}
	}
	
	$data = array(
		"id_article_tarif"	=>	$_POST["columns"]["id_article_tarif"],
		"montant"			=>	$_POST["columns"]["montant"],
		"status"			=>	$_POST["columns"]["status"],
		"is_default"		=>	$_POST["columns"]["is_default"],
		"UID"				=>	$_POST["columns"]["UID"],
		"id_article"		=>	$_POST["columns"]["id_article"],
	);
	
	if(isset($_POST["columns"]["id"])){
		$data["id"] = $_POST["columns"]["id"];
	}
	$ob->save($data);

	echo "1";


}else{
	echo "File not exists : " . $_SESSION['CORE'].$table_name.".php";
}



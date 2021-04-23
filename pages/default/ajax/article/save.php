<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['t_n'])){die("-2");}
if(!isset($_POST['columns'])){die("-3");}


$table_name = $_POST['t_n'];

if(file_exists($_SESSION['CORE'].$table_name.".php")){
	
	require_once($_SESSION['CORE'].$table_name.".php");
	$ob = new $table_name();
	$data = array();
	foreach($_POST["columns"] as $k=>$v){
		$data[$k] =  addslashes ($v);
	}	
	
	if($data["id_article_sous_category"] !== "-1"){
		$data["id_article_sous_category"] = $data["id_article_sous_category"];
	}
	
	$ob->save($data);	
	$lastID = $ob->getLastID();
	if (!isset($_POST["columns"]["id"])){
		
		$data = $ob->find("", array("conditions AND"	=>array(
			"UID="			=>	$_POST["columns"]["UID"],
			"id_article="	=>	0
		)), "article_tarif_achat");
		
		foreach($data as $k=>$v){
				$ob->save(array("id"=>$v["id"],"id_article"=>$lastID),"article_tarif_achat");
		}
		
		$data = $ob->find("", array("conditions AND"	=>array(
			"UID="			=>	$_POST["columns"]["UID"],
			"id_article="	=>	0
		)), "article_tarif_vente");
		
		foreach($data as $k=>$v){
				$ob->save(array("id"=>$v["id"],"id_article"=>$lastID),"article_tarif_vente");
		}	
		
	}
	

	echo "1";
	

}else{
	echo "File not exists : " . $_SESSION['CORE'].$table_name.".php";
}



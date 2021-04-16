<?php session_start();

if(!isset($_SESSION['CORE'])){die();}
if(!isset($_POST['data'])){die();}


$table_name = $_POST['data']['t_n'];
$core = $_SESSION['CORE'];

if(file_exists($core.$table_name.".php")){
	require_once($core.$table_name.".php");
	$ob = new $table_name();
	
	$args = array(
		"p_p"		=>	(isset($_POST['data']['p_p']))? $_POST['data']['p_p'] : null,
		"sort_by"	=>	(isset($_POST['data']['sort_by']))? $_POST['data']['sort_by'] : "display_order asc",
		"current"	=>	(isset($_POST['data']['current']))? $_POST['data']['current'] : null,
		"style"	=>	(isset($_POST['data']['style']))? $_POST['data']['style'] : "list",
	);

	$request =  $_POST['data']['request'];
	
	$conditions = array();

	if($request !== ""){$conditions["code like "] = "%".$request."%";}
	
	if(isset($_POST['data']['filter'])){
	
		foreach($_POST['data']['filter'] as $k=>$v){
			if($k === "category") $conditions["id_article_category = "] = $v;
			if($k === "article_sous_category") $conditions["id_article_sous_category = "] = $v;
		}

		/*
		if(isset($_POST['data']['filter']["category"])){
			$id_category = $_POST['data']['filter']["category"];
			if($id_category !== "25"){
				foreach($_POST['data']['filter'] as $k=>$v){
					if($k === "category") $conditions["id_article_category = "] = $v;
					if($k === "sous_category") $conditions["id_article_sous_category = "] = $v;
					if($k === "status") $conditions["id_article_status = "] = $v;
					if($k === "type") $conditions["id_article_type = "] = $v;
					if($k === "marque") $conditions["id_article_marque = "] = $v;
				}				
			}else{
				foreach($_POST['data']['filter'] as $k=>$v){
					if($k === "category") $conditions["id_article_category = "] = $v;
					if($k === "sous_category") $conditions["id_parent = "] = $v;
					if($k === "parent") $conditions["id_article_sous_category = "] = $v;
					if($k === "status") $conditions["id_article_status = "] = $v;
					if($k === "type") $conditions["id_article_type = "] = $v;
					if($k === "marque") $conditions["id_article_marque = "] = $v;
				}				
			}
		}else{
			foreach($_POST['data']['filter'] as $k=>$v){
				if($k === "status") $conditions["id_article_status = "] = $v;
				if($k === "type") $conditions["id_article_type = "] = $v;
				if($k === "marque") $conditions["id_article_marque = "] = $v;
			}				
		}
		*/

	}
	if(count($conditions)>1){
		$conditions = array("conditions AND"=>$conditions);	
	}else{
		$conditions = array("conditions"=>$conditions);		
	}
	unset($_SESSION["REQUEST"]);	
	$_SESSION["REQUEST"] = array(
		$table_name	=> array(
								"args"	=>	$args,
								"cond"	=>	$conditions
							)
	);	


	echo $ob->drawTable($args,$conditions, "v_article");

}else{
	echo -1;
}
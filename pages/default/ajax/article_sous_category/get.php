<?php session_start();

if(!isset($_SESSION['CORE'])){die();}
if(!isset($_POST['data'])){die();}


$table_name = $_POST['data']['t_n'];
$core = $_SESSION['CORE'];

if(file_exists($core.$table_name.".php")){
	require_once($core.$table_name.".php");
	$ob = new $table_name();
	
	//var_dump($_POST['data']);
	
	$args = array(
		"p_p"		=>	(isset($_POST['data']['p_p']))? $_POST['data']['p_p'] : null,
		"sort_by"	=>	(isset($_POST['data']['sort_by']))? $_POST['data']['sort_by'] : "ord",
		"current"	=>	(isset($_POST['data']['current']))? $_POST['data']['current'] : null,
		"style"	=>	(isset($_POST['data']['style']))? $_POST['data']['style'] : "list",
		"sub"	=>	(isset($_POST['data']['sub']))? "sub" : ""
	);
	
	$request =  isset($_POST['data']['request'])? strtolower($_POST['data']['request']):"";
	$conditions["id_parent = "] = -1;
	
	if(isset($_POST['data']['filter']["category"])){
		$conditions["id_article_category = "] = $_POST['data']['filter']["category"];
		
	}
	
	if(isset($_POST['data']['sub'])){
		
		$conditions["id_parent > "] = 0;
		unset($conditions["id_parent = "]);
	}
	
	
	if($request !== "") $conditions["LOWER(article_sous_category_fr) like "] = $request."%";
	
	//var_dump($conditions);
	
	if(count($conditions) === 1){
		$conditions = array("conditions"=>$conditions);
	}else{
		$conditions = array("conditions AND"=>$conditions);
	}
	
	unset($_SESSION["REQUEST"]);	
	
	if(isset($_POST['data']['sub'])){
		$_SESSION["REQUEST"] = array(
			$table_name."_2"	=> array(
									"args"	=>	$args,
									"cond"	=>	$conditions
								)
		);
	}else{
		$_SESSION["REQUEST"] = array(
			$table_name	=> array(
									"args"	=>	$args,
									"cond"	=>	$conditions
								)
		);
	}
	
	
	
	echo $ob->drawTable($args,$conditions, "");

}else{
	echo -1;
}
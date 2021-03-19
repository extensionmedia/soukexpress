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
		"sort_by"	=>	(isset($_POST['data']['sort_by']))? $_POST['data']['sort_by'] : "first_name desc",
		"current"	=>	(isset($_POST['data']['current']))? $_POST['data']['current'] : null,
	);

	$request =  isset($_POST['data']['request'])? strtolower($_POST['data']['request']):"";
	$conditions = [];
	if($request !== ""){$conditions["first_name like "] = "%".$request."%";}
	if(isset($_POST['data']['filter'])){
		foreach($_POST['data']['filter'] as $k=>$v){
				if($k === "profile") $conditions["id_profile = "] = $v;
		}
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

	echo $ob->drawTable($args,$conditions, 'v_person');

}else{
	echo -1;
}
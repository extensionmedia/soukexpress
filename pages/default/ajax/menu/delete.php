<?php session_start(); $core = $_SESSION['CORE']; 

$table_name = $_POST["page"];
require_once($core.$table_name.".php");
$ob = new $table_name();
$id = $_POST["id"];
$cond = array("conditions" => array("id=" => $id) );
$data = $ob->find(null, $cond, null);
$dS = DIRECTORY_SEPARATOR;
if( count($data) > 0 ){
	foreach($ob->find(null,array("conditions"=>array("id_parent="=>$id)),null) as $k=>$v){
		$ob->delete($v["id"]);
	}
	echo $ob->delete($_POST["id"], "manager_links");
}else{
	
}


<?php session_start(); $core = $_SESSION['CORE']; 

$table_name = $_POST["page"];
require_once($core.$table_name.".php");
$ob = new $table_name();
$id = $_POST["id"];
$cond = array("conditions" => array("id=" => $id) );
$data = $ob->find(null, $cond, null);
$dS = DIRECTORY_SEPARATOR;
if( count($data) > 0 ){
	
	foreach($ob->find('', ['conditions'=>['id_commande='=>$id]], 'commande_detail') as $k=>$v){
		$ob->delete($v['id'], 'commande_detail');
	}
	foreach($ob->find('', ['conditions'=>['id_commande='=>$id]], 'status_of_commande') as $k=>$v){
		$ob->delete($v['id'], 'status_of_commande');
	}
	
	
	echo $ob->delete($_POST["id"]);
}else{
	echo -1;
}


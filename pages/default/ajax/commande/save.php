<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['t_n'])){die("-2");}
if(!isset($_POST['columns'])){die("-3");}


$table_name = $_POST['t_n'];

if(file_exists($_SESSION['CORE'].$table_name.".php")){
	
	require_once($_SESSION['CORE'].$table_name.".php");
	$ob = new $table_name();
	
	foreach($_POST["columns"] as $k=>$v){
		$_POST["columns"][$k] = addslashes ($v);
	}	
	
	if(isset($_POST["columns"]["id"])){
		$env = "SOUKEXPRESS-MANAGER";
		$updated = date('Y-m-d H:i:s');
		$updated_by = $_SESSION[$env]["USER"]["id"];

		$data = [
			'id'					=>		$_POST["columns"]["id"],
			'updated_by'			=>		$updated_by,
			'updated'				=>		$updated,
			'status'				=>		$_POST["columns"]["status"],
			'periode_livraison'		=>		$_POST["columns"]["periode_livraison"],
			'frais_livraison'		=>		$_POST["columns"]["frais_livraison"]
			
		];
		
		$current_status = $ob->find('', ['conditions'=>['id='=>$_POST["columns"]["id"]]], '')[0]["status"];
		
		if($current_status !== $_POST["columns"]["status"]){
			$s = [
				'created'				=>	$updated,
				'created_by'			=>	$updated_by,
				'id_commande_status'	=>	$_POST["columns"]["status"],
				'id_commande'			=>	$_POST["columns"]["id"],
			];
			$ob->save($s, 'status_of_commande');
		}
		
		$ob->save($data);
		
		
		echo "1";		
		
	}else{
		$ob->save($_POST["columns"]);
		echo "1";		
	}
	

	

}else{
	echo "File not exists : " . $_SESSION['CORE'].$table_name.".php";
}



<?php session_start();

$core = $_SESSION["CORE"];
$host = $_SESSION["HOST"];
$statics = $_SESSION["STATICS"];
$upload_folder = $_SESSION["UPLOAD_FOLDER"];

$dS = DIRECTORY_SEPARATOR;

$filesDirectory = $upload_folder.'creative'.$dS.$_POST['id_produit'].$dS;


$nbr = 0;

if(file_exists($filesDirectory)){
	foreach(scandir($filesDirectory) as $k=>$v){
		if($v <> "." and $v <> ".." and strpos($v, '.') !== false){
			echo "<img style='width:100px; height:auto' src='http://".$statics."creative/".$_POST['id_produit']."/".$v."'>";
			echo "<textarea class='creative_body_file' style='height:70px'>http://".$statics."creative/".$_POST['id_produit']."/".$v."</textarea>";
			$nbr++;
		}

	}
	
}


if($nbr==0){
			echo '<img src="http://'.$host.'templates/default/images/creative_0.png" style="width: 100%; height: auto">';
			echo "<textarea class='creative_body_file' style='height:70px'></textarea>";
}
//var_dump(scandir($filesDirectory,1));



<?php
session_start();

$core = $_SESSION["CORE"];
$host = $_SESSION["HOST"];
$upload_folder = $_SESSION["UPLOAD_FOLDER"];
//var_dump($_GET);
$isOK=false;
$message="";
$dS = DIRECTORY_SEPARATOR;
$autorizedExt = array("jpg","jpeg","png","gif","bmp","JPG","JPEG","doc","docx","pdf");
$autorizedType = array("image/jpeg","image/gif","image/png","image/bmp","image/jpg","application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/pdf");



//sleep(2);
if(isset($_FILES['upload_file'])){
	if(!empty($_FILES['upload_file']) && ($_FILES['upload_file']['error'] == 0)){
		if(in_array($_FILES['upload_file']['type'], $autorizedType)){
			if($_FILES['upload_file']['size']>10000){	// > 20 ko
				if($_FILES['upload_file']['size']<4000000){	// < 4.0 Mo
					$filename = basename($_FILES['upload_file']['name']);
					$ext = substr($filename, strrpos($filename, '.') + 1);
					if (in_array($ext, $autorizedExt)){
						if(isset($_GET["path"])){
							if(!empty($_GET["path"])){
								
								$isOK=true;
								
							}else{$message=$message."<br>empty Article : ".$ext;}	
						}else{$message=$message."<br>unset Article : ".$ext;}										
					}else{$message=$message."<br>Erreur Format : ".$ext;}
				}else{$message=$message."<br>fichier volumineu : ".round($_FILES['upload_file']['size'] /1000000 , 2);}
			}else{$message=$message."<br>fichier trop petit : ".round($_FILES['upload_file']['size'] /1000000 , 2);}
		}else{$message=$message."<br>Erreur Format : ".$_FILES["upload_file"]["type"];}
	}else{$message=$message."<br>fichier est vide";}
}else{$message=$message."<br>fichier non envoyé";}

if ($isOK){

	$dir = $upload_folder.$dS.$_GET["path"].$dS;
	
	if ( !file_exists($dir) ) {
		mkdir($dir, 0777, true);
	}elseif(  strpos($_GET["path"], 'category/') !== false){
		array_map('unlink', glob("$dir/*.*"));
	}

	$lastId = time();
	$ext = substr($filename, strrpos($filename, '.') + 1);
	$file = $dir.$lastId.'.'.$ext;
	
	if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $file)) {
	  	echo 1; 
	}else{echo 0;}
}else{
	echo '0';
	echo $message;
}

<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['link'], $_POST['new_name'])){die("-2");}

$link = $_POST['link'];

$path_parts = pathinfo($link);

if(file_exists($link)){
	
	foreach(scandir($path_parts["dirname"]) as $k=>$v){
		if($v <> "." and $v <> ".." and strpos($v, '.') !== false){
			if (strpos($v, 'watermark') !== false) {
				$new_link = str_replace('watermark', time(), $v);
				rename($path_parts["dirname"]. DIRECTORY_SEPARATOR .$v,  $path_parts["dirname"]. DIRECTORY_SEPARATOR .$new_link);
			}
		}
	}
	rename($link,  $path_parts["dirname"]. DIRECTORY_SEPARATOR . $_POST['new_name'] . "." . $path_parts["extension"]);

}else{
	echo 'not found!';
}






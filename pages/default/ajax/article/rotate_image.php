<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['link'])){die("-2");}

$link = $_POST['link'];

$rotateFilename = $_POST['link'];

$fileParts = pathinfo($rotateFilename);

$degrees = 90;
$ext = $fileParts["extension"];
$name = $fileParts["filename"];
$basename = $fileParts["basename"];
$dirname = $fileParts["dirname"];

if($ext == 'png'){
   header('Content-type: image/png');
   $source = imagecreatefrompng($rotateFilename);
   $bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
   // Rotate
   $rotate = imagerotate($source, $degrees, $bgColor);
   imagesavealpha($rotate, true);
   imagepng($rotate,$rotateFilename);

}

if($ext == 'jpg' || $ext == 'jpeg'){
   header('Content-type: image/jpeg');
   $source = imagecreatefromjpeg($rotateFilename);
   // Rotate
   $rotate = imagerotate($source, $degrees, 0);
   //imagejpeg($rotate,$rotateFilename);
	imagejpeg($rotate,$dirname. DIRECTORY_SEPARATOR .time().".".$ext);
}

// Free the memory
imagedestroy($source);
imagedestroy($rotate);
unlink($rotateFilename);
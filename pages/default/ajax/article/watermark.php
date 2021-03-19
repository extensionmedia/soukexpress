<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['UID'])){die("-2");}
if(!isset($_POST['folder'])){die("-3");}

require_once($_SESSION['CORE']."Article.php");

$UID = $_POST["UID"];
$article->createWatermark( array(	"article_folder"	=>	$UID	) );
echo 1;












<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['link'])){die("-2");}

$link = $_POST['link'];
echo unlink($link);
//var_dump($_POST);

<?php session_start();

$response  = array("code"=>0, "msg"=>"Error");

if(!isset($_SESSION['CORE'])){die(json_encode($response));}
if(!isset($_POST['controler'])){die(json_encode($response));}
if(!isset($_POST['method'])){die(json_encode($response));}

/********************/

$core = $_SESSION['CORE'];
$controler = addslashes($_POST['controler']);
$method = addslashes($_POST['method']);



if(file_exists($core.$controler.".php")){
	require_once($core.$controler.".php");
	$ob = new $controler();
	if(method_exists($ob, $method)){
		if(isset($_POST['params'])){
			$response  = array("code"=>1, "msg"=>$ob->$method($_POST['params']));
		}else{
			$response  = array("code"=>1, "msg"=>$ob->$method());
		}
		
	}else{
		$response  = array("code"=>0, "msg"=>"Function Not Found");
	}
}else{
	$response  = array("code"=>0, "msg"=>"Controler Not Found");
}

echo json_encode($response);
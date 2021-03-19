<?php session_start();

$response  = array("code"=>0, "msg"=>"Error");


if(!isset($_SESSION['CORE'])){die(json_encode($response));}
if(!isset($_POST['module'])){$response["msg"]="Error Data"; die(json_encode($response));}



$core = $_SESSION['CORE'];

$module = $_POST["module"];
switch ($module){
	case "is_visible":
		$id_article = $_POST["id_article"];
		$web_status = $_POST["web_status"];
		
		require_once($core."Article_Category.php");
		$article_category->save(array("id"=>$id_article, "status"=>$web_status));
		$response  = array("code"=>1, "msg"=>"Success");
		
	break;
		
	
		
}
/*
echo $response["msg"];
die();
*/
echo json_encode($response);

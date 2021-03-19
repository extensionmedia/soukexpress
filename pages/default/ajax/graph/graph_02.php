<?php session_start();

if(!isset($_SESSION['CORE'])){die();}
$core = $_SESSION['CORE'];
//if(!isset($_POST['data'])){die();}
$month = (isset($_POST["month"]))? $_POST["month"]: date("m");



require_once($core."Expense.php");

$data = $expense->find(null, array("conditions"=>array("_month="=>$month)), "v_expense_sum_per_category");

$_months = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

$return = array();

$_return=array();

foreach($data as $k=>$v){
	if(isset( $return[ $v["expense_category"] ] )){
		$return[ $v["expense_category"] ] += $v["total"];
	}else{
		$return[ $v["expense_category"] ] = $v["total"];
	}
}

foreach($return as $k=>$v){
	$d = array("expense_category"=>$k, "montant"=>$v);
	array_push($_return, $d);
}

/*
var_dump($return);
die();
*/
echo json_encode($_return);

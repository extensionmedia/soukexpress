<?php session_start();

if(!isset($_SESSION['CORE'])){die();}
$core = $_SESSION['CORE'];
//if(!isset($_POST['data'])){die();}
//$month = (date("m")>9)? date("m"): "0".date("m");
$month = (isset($_POST["month"]))? $_POST["month"]: date("m");
$year = date("Y");


function days_in_month($month, $year) { 

	return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
		
} 

require_once($core."Expense.php");



$days_in_this_month = days_in_month(intval($month), $year);

$returned = array();

for($i=1; $i <= $days_in_this_month; $i++){

	
	$data = $expense->find(null, array("conditions AND"=>array("day="=>$i, "month="=>intval($month),"year="=>$year )), "v_expense_sum_per_day");
	
	
	if(count($data)>0){
		$d = array( 
			"day"	=>	$i,
			"total" => $data[0]["total"]
		);
	}else{
		$d = array( 
			"day"	=>	$i,
			"total" => 0 
		);
	}
	array_push($returned, $d);	
}

echo json_encode($returned);

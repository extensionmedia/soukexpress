<?php session_start();

if(!isset($_SESSION['CORE'])){die();}
$core = $_SESSION['CORE'];
//if(!isset($_POST['data'])){die();}
//$month = (date("m")>9)? date("m"): "0".date("m");
$month = date("m");
$year = date("Y");

$_months = array(
	1	=>	"Jan",
	2	=>	"Fév",
	3	=>	"Mars",
	4	=>	"Avr",
	5	=>	"Mai",
	6	=>	"Juin",
	7	=>	"Juil",
	8	=>	"Août",
	9	=>	"Sept",
	10	=>	"Oct",
	11	=>	"Nov",
	12	=>	"Déc"
);

function days_in_month($month, $year) { 

	return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
		
} 

require_once($core."Expense.php");

$data = $expense->find(null, array(), "v_expense_sum_per_month");

$days_in_this_month = 0;

$returned = array();

for($i=1; $i<13; $i++){
	
	$days_in_this_month = ($i === intval($month))? date("d"): days_in_month($i,$year) ;
	
	$data = $expense->find(null, array("conditions"=>array("month="=>$i)), "v_expense_sum_per_month");
	
	
	if(count($data)>0){
		$d = array( 
			"month"	=>	$_months[$i],
			"total" => round($data[0]["total"] / $days_in_this_month,0)
		);
	}else{
		$d = array( 
			"month"	=>	$_months[$i],
			"total" => 0 
		);
	}
	array_push($returned, $d);	
}

echo json_encode($returned);

<?php session_start();

if(!isset($_SESSION['CORE'])){die();}
$core = $_SESSION['CORE'];
//if(!isset($_POST['data'])){die();}
$month = "02";
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

//require_once($core."Expense.php");

//$data = $expense->find(null, array(), "v_expense_sum_per_month");
$returned = array();

for($i=1; $i<13; $i++){
	
	/*
	$data = $expense->find(null, array("conditions"=>array("month="=>$i)), "v_expense_sum_per_month");
	
	
	if(count($data)>0){
		$d = array( 
			"month"	=>	$_months[$i],
			"total" => $data[0]["total"]
		);
	}else{
		$d = array( 
			"month"	=>	$_months[$i],
			"total" => 0 
		);
	}
	*/
	$d = array(
		"month"	=>	$_months[$i],
		"total" => intval($i * rand(1245,5568)) 
	);
	array_push($returned, $d);	
}


echo json_encode($returned);

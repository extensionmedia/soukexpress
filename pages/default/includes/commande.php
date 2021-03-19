<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$core = $_SESSION["CORE"];
$table_name = "Commande";
require_once($core.$table_name.".php");  
$ob = new $table_name();
$months = [
	1	=>	'Janvier',
	2	=>	'Février',
	3	=>	'Mars',
	4	=>	'Avril',
	5	=>	'Mai',
	6	=>	'Juin',
	7	=>	'Juillet',
	8	=>	'Août',
	9	=>	'Septembre',
	10	=>	'Octobre',
	11	=>	'Novembre',
	12	=>	'Décembre'
];
?>

	<div class="row page_title">
		<div class="col_6-inline icon">
			<i class="fas fa-address-card"></i> Commande
		</div>
		<div class="col_6-inline actions">
			<button class="btn btn-green add" value="<?= $table_name ?>"><i class="fas fa-plus" aria-hidden="true"></i></button>
			<button class="btn btn-default refresh" value="<?= $table_name ?>"><i class="fas fa-sync-alt"></i></button>
			<button class="btn btn-orange showSearchBar"><i class="fas fa-search-plus"></i></button>
		</div>		
	</div>
	<hr>
	<div class="row searchBar" style="background-color: rgba(241,241,241,1.00); padding: 10px 0; margin: 10px 0px">
		<div class="col_4-inline">
			
			<div class="input-group" style="overflow: hidden">
				<input type="text" placeholder="Chercher" class="suf" name="" id="request">
				<div class="input-suf"><button title="Chercher" id="a_u_s"><i class="fa fa-search"></i></button></div>
			</div>

		</div>
		<div class="col_8-inline">
			<div class="row _select">
				<div class="col_2-inline">
					<select id="commande_status" data="Commande_Status">
						<option selected value="-1"> --  Status  -- </option>
							<?php require_once($core."Commande_Status.php"); 
								foreach( $commande_status->find("", array("order"=>"commande_status_fr"), "") as $k=>$v){
							?>	
						<option value="<?= $v["id"] ?>"> <?= strtoupper( $v["commande_status_fr"] ) . " " . $v["commande_status_ar"] ?> </option>
							<?php } ?>
					</select>
				</div>

				<div class="col_2-inline">
					<select id="mois" data="month">
						<option selected value="-1"> --  Mois  -- </option>
							<?php 
								foreach( $months as $k=>$v){
							?>	
						<option <?= $k === intval(date("m"))? "selected": "" ?> value="<?= $k ?>"> <?= $v ?> </option>
							<?php } ?>
					</select>
				</div>
				<div class="col_2-inline">
					<select id="days" data="days"><option selected value="-1"> --  Jour  -- </option></select>
				</div>
			</div>

		</div>

		<div class="col_12 _choices" style="padding-top: 15px"></div>
	</div>
	<div class="row <?= $table_name ?>">
		<?php
$args 			= 	['sort_by'		=>	'created DESC'];
$conditions		=	['conditions' => ['MONTH(created) = ' => date('m')]  ];
$use = 'v_commande';		 
echo $ob->drawTable($args, $conditions, $use); ?>		
	</div>

		
	<div class="debug"></div>

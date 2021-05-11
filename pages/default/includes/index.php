<?php 

if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$core = $_SESSION["CORE"];
//require_once($core."Element.php");  
//var_dump($_SESSION);
?>


	<div class="row">
		<div class="col_12">
			<div class="panel" style="margin-top: 11px; padding-top: 11px">
				<div class="panel-content">
					<div class="row">
						<div style="flex-direction: row; display: flex">
							<div style="flex: 1; text-align: right">
								<div style="flex-direction: row; display: flex" class="">
									<div style="display: table-cell; margin-right: 7px" class="">
										<div class="btn-group calendar">
											<a style="padding: 12px 12px" data-counter="0" class="cl_refresh" title="Ajourd'hui"><i class="fas fa-sync-alt"></i> </a>
										</div>											
									</div>				
									<div style="display: table-cell; margin-right: 7px" class="">
										<div class="btn-group calendar">
											<a style="padding: 12px 12px" class="direction" data-action="preview" data-counter="0" title="Précédent"><i class="fa fa-chevron-left"></i></a>
											<a style="padding: 12px 12px" class="direction" data-action="next" data-counter="0"  title="Suivant"><i class="fa fa-chevron-right"></i></a>
										</div>											
									</div>
									<div style="display: table-cell; margin-right: 7px" class="">
										<div class="btn-group calendar">
											<a style="padding: 12px 12px"><i class="far fa-calendar-alt"></i> <span class="calendar_current_interval tohide"><?= date("M") . " " . date("Y") ?></span></a>
										</div>											
									</div>	
								</div>
							</div>	
						</div>
					</div>

					<div class="row report">

						<div class="col_6">
							<div class="row">
								<div class="col_6-inline item red">
									<div class="title check_article_disponibilite cursor-pointer">
										<i class="fas fa-person-booth"></i> Commandes(s)
									</div>
									<div class="number">
										<?= 84 //count($calendar->fetchAll("v_location")) ?>
									</div>
								</div>

								<div class="col_6-inline item yellow">
									<div class="title">
										<i class="fas fa-bell"></i> Notifications(s) 
									</div>
									<div class="number">
										3
									</div>
								</div>			
							</div>
						</div>

						<div class="col_6">
							<div class="row">
								<div class="col_6-inline item green">
									<div class="title">
										<i class="fas fa-cash-register"></i> Recette(s) 
									</div>
									<div class="number">
										<?= "7 458,00 Dh" //count($calendar->fetchAll("v_client")) ?>
									</div>
								</div>

								<div class="col_6-inline item blue">
									<div class="title">
										<i class="fab fa-creative-commons-nc"></i> Credit(s) 
									</div>
									<div class="number">
										<?= "458,00 Dh"  //count($calendar->fetchAll("v_vehicule")) ?>
									</div>
								</div>			
							</div>
						</div>

					</div>		

				</div>
			</div>			
		</div>
	</div>

	<div class="row">
		<div class="col_6">
			<div class="panel">
				<div class="panel-content">
					<h1>Header</h1>
				</div>
			</div>			
		</div>
		
		<div class="col_6">
			<div class="panel" style="padding-top: 11px">
				<div class="panel-content">
					<div class="row">
						<div style="flex-direction: row; display: flex">
							<div style="flex: 1; text-align: right">
								<div style="flex-direction: row; display: flex" class="">
									<div style="display: table-cell; margin-right: 7px" class="">
										<div class="btn-group calendar">
											<a style="padding: 12px 12px" data-counter="0" class="cl_refresh" title="Ajourd'hui"><i class="fas fa-sync-alt"></i> </a>
										</div>											
									</div>				
									<div style="display: table-cell; margin-right: 7px" class="">
										<div class="btn-group calendar">
											<a style="padding: 12px 12px" class="direction" data-action="preview" data-counter="0" title="Précédent"><i class="fa fa-chevron-left"></i></a>
											<a style="padding: 12px 12px" class="direction" data-action="next" data-counter="0"  title="Suivant"><i class="fa fa-chevron-right"></i></a>
										</div>											
									</div>
									<div style="display: table-cell; margin-right: 7px" class="">
										<div class="btn-group calendar">
											<a style="padding: 12px 12px"><i class="far fa-calendar-alt"></i> <span class="calendar_current_interval tohide"><?= date("Y") ?></span></a>
										</div>											
									</div>	
								</div>
							</div>	
						</div>
					</div>
					<canvas id="myChart" style=""></canvas>
				</div>
			</div>			
		</div>
		
	</div>
	<script>
		$(document).ready(function(){

			var timer = setInterval(() => {
				var data = {
					'method'		:	'check_article_disponibilite',
					'controler'		:	'Article'
				}
				var that = $(this);
				$.ajax({
					type		: 	"POST",
					url			: 	"pages/default/ajax/Ajax.php",
					data		:	data,
					dataType	: 	"json",
				}).done(function(response){

					console.log(response);
					clearInterval(timer);
				}).fail(function(xhr){
					alert("Error");
					console.log(xhr.responseText);
				});				
			}, 1000);

			var timer2 = setInterval(() => {
				
			}, 2000);


		});
	</script>

</div>


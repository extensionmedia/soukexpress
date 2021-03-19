<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$core = $_SESSION["CORE"];
$table_name = "Whatsapp";
require_once($core.$table_name.".php");  
$ob = new $table_name();

?>

	<div class="row page_title">
		<div class="col_6-inline icon">
			<i style="color:#25D366" class="fab fa-whatsapp"></i> Whatsapp
		</div>
		<div class="col_6-inline actions">
			<button class="btn btn-green add" value="<?= $table_name ?>"><i class="fas fa-plus" aria-hidden="true"></i></button>
			<button class="btn btn-default refresh" value="<?= $table_name ?>"><i class="fas fa-sync-alt"></i></button>
			<button class="btn btn-orange showSearchBar"><i class="fas fa-search-plus"></i></button>
		</div>
	</div>
	<hr>
	<div class="row searchBar hide" style="background-color: rgba(241,241,241,1.00); padding: 10px 0; margin: 10px 0px">
		<div class="col_6">
			
			<div class="input-group" style="overflow: hidden; margin-top: 10px">
				<input type="text" placeholder="Chercher" class="suf" name="" id="request">
				<div class="input-suf"><button title="Chercher" id="a_u_s" class="_propriete" data="_request"><i class="fa fa-search"></i></button></div>
			</div>

		</div>
		<div class="col_6">

		</div>
		
		<div class="col_12 _choices" style="padding-top: 15px"></div>
			
	
	</div>
	<div class="panel" style="overflow: auto;">
			<div class="panel-content" style="padding: 0">
				<?= $whatsapp->drawTable(); ?>
			</div>
		</div>
	</div>
		
	<div class="debug_client"></div>

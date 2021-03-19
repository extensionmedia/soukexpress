<?php session_start(); $core = $_SESSION['CORE']; 

$table_name = $_POST["page"];
require_once($core.$table_name.".php");
$ob = new $table_name();
$ob->id = $_POST["id"];
$data = $ob->read()[0];

$formToken=uniqid();
$return_page = "Contact";
?>
<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-address-card"></i> Contact
	</div>
	<div class="col_6-inline actions <?= strtolower($return_page) ?>">
		<button class="btn btn-default close" value="<?= $return_page ?>"><i class="fas fa-times"></i></button>
	</div>
</div>
<hr>

<div class="panel">
	<div class="panel-content">

		<h3 style="margin-left: 6px">Message</h3>
		<input type="hidden" value="<?= $data["id"]  ?>" id="id">
		
		<div class="row" style="margin-bottom: 20px">
			<div class="col_6-inline">
				<label for="">Date</label>
				<input type="text" value="<?= $data["created"] ?>">
			</div>
			<div class="col_6-inline">
				<label for="">From</label>
				<input type="text" value="<?= $data["ip"] ?>">
			</div>
		</div>			

		<div class="row" style="margin-bottom: 20px">
			<div class="col_6-inline">
				<label for="">Nom</label>
				<input type="text" value="<?= $data["name"] ?>">
			</div>
			<div class="col_6-inline">
				<label for="">Societe</label>
				<input type="text" value="<?= $data["societe"] ?>">
			</div>
		</div>	

		<div class="row" style="margin-bottom: 20px">
			<div class="col_6-inline">
				<label for="">E-Mail</label>
				<input type="text" value="<?= $data["email"] ?>">
			</div>
			<div class="col_6-inline">
				<label for="">Téléphone</label>
				<input type="text" value="<?= $data["phone"] ?>">
			</div>
		</div>	
		
		<div class="row" style="margin-bottom: 20px">
			<div class="col_12-inline">
				<label for="">Message</label>
				<textarea id="" style="max-width: 100%; height: 170px"><?= $data["message"] ?></textarea>
			</div>			

		</div>

	</div>

</div>

<div class="debug_client"></div>


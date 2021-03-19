<?php session_start(); 
if(!isset($_SESSION['CORE'])){ die("-1"); }
if(!isset($_POST["page"])){ die("-2"); }

$core = $_SESSION['CORE']; 
$action = "add";
$table_name = $_POST["page"];
if(!file_exists($core.$table_name.".php")){ die("-3"); }
$formToken = md5( uniqid('auth', true) );
$id = 0;

if(isset($_POST["id"])){
	require_once($core.$table_name.".php");
	$ob = new $table_name();
	$ob->id = $_POST["id"];
	$id = $_POST["id"];
	if( count( $ob->read() ) < 1){ die("-4"); }
	$data = $ob->read()[0];
	$action = "edit";
	
}


?>
<style>
	.col_6, .col_12{
		padding: 5px 7px
	}
</style>

<div class="container">
	<div class="row page_title">
		<div class="col_6-inline icon">
			<i class="fas fa-folder-open"></i> Commande
		</div>
		<div class="col_6-inline actions">
			<button class="btn btn-green save_form <?= ($action === "edit")? "edit" : "" ?>" data-table="<?= $table_name ?>"><i class="fas fa-save"></i></button>
			<button class="btn btn-default close" value="<?= $table_name ?>"><i class="fas fa-times"></i></button>
		</div>
	</div>
	<hr>
	<div class="panel">
	<div class="panel-content" style="padding: 0px;">
		<div class="row  <?= strtolower($table_name) ?>" style="padding: 25px 0px">
		<?= ($action === "edit")? "<input class='form-element' type='hidden' id='id' value='".$id."'>" : "" ?>
			
			<div class="row">
				<div class="col_6">
					<label for="client_name">Client</label>
					<input class="form-element required" type="text" id="client_name" value="<?= ($action === "edit")? $data["client_name"] : "" ?>">
				</div>
				
				<div class="col_6">
					<label for="status">Status</label>
					<select id="status" class="form-element required">
						<?php require_once($core."Commande_Status.php");
								foreach($commande_status->fetchAll() as $k=>$v){
									if($action === 'edit'){
										if($data['status'] === $v['id'])
											echo '<option selected value="'.$v["id"].'">'.$v["commande_status_fr"].'</option>';
										else
											echo '<option value="'.$v["id"].'">'.$v["commande_status_fr"].'</option>';
									}else{
										if($data['is_default'] === $v['id'])
											echo '<option selected value="'.$v["id"].'">'.$v["commande_status_fr"].'</option>';
										else
											echo '<option value="'.$v["id"].'">'.$v["commande_status_fr"].'</option>';
									}
								}
						?>
					</select>
				</div>
				
			</div>
			
			<div class="row">
				<div class="col_6">
					<label for="client_telephone">Téléphone</label>
					<input class="form-element required" type="text" id="client_telephone" value="<?= ($action === "edit")? $data["client_telephone"] : "" ?>">
				</div>
				<div class="col_6">
					<label for="client_ville">Ville</label>
					<input class="form-element required" type="text" id="client_ville" value="<?= ($action === "edit")? $data["client_ville"] : "" ?>">
				</div>
			</div>
			
			<div class="row">
				<div class="col_12">
					<label for="client_adresse">Adresse</label>
					<input class="form-element required" type="text" id="client_adresse" value="<?= ($action === "edit")? $data["client_adresse"] : "" ?>">
				</div>
			</div>
			
			<div class="row">
				<div class="col_6">
					<label for="periode_livraison">Livraison</label>
					<input class="form-element required" type="text" id="periode_livraison" value="<?= ($action === "edit")? $data["periode_livraison"] : "" ?>">
				</div>
				<div class="col_6">
					<label for="frais_livraison">Frais Livraison</label>
					<input class="form-element required" type="text" id="frais_livraison" value="<?= ($action === "edit")? $data["frais_livraison"] : "" ?>">
				</div>
			</div>
			
		</div> <!-- ROW-->
		
		<div class="commande_list" style="margin: 0px 10px 20px 10px; border: 1px solid rgba(196,196,196,1.00); max-height: 250px; overflow: auto">
			<?php
				if($action === 'edit'){
					echo $ob->Get_Commande_Details(['id_commande'=>$id]);
				}
			?>
		</div>

	</div>	<!-- END PANEL CONTENT -->

</div>

</div>
<div class="debug"></div>


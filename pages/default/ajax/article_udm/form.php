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
<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-folder-open"></i> Article UDM
	</div>
	<div class="col_6-inline actions">
		<button class="btn btn-green save_form <?= ($action === "edit")? "edit" : "" ?>" data-table="<?= $table_name ?>"><i class="fas fa-save"></i></button>
		<button class="btn btn-default close" value="<?= $table_name ?>"><i class="fas fa-times"></i></button>
	</div>
</div>
<hr>

<div class="panel">
	<div class="panel-content" style="padding: 0px">
		<div class="row  <?= strtolower($table_name) ?>" style="margin-top: 25px">
		<?= ($action === "edit")? "<input class='form-element' type='hidden' id='id' value='".$id."'>" : "" ?>
			<div class="row" style="margin-bottom: 20px">
				<div class="col_4">
					<div class="row">
						<div class="col_8-inline">
							<label for="article_udm_fr">UDM (fr)</label>
							<input class="form-element required" type="text" placeholder="Unité de mesure" id="article_udm_fr" value="<?= ($action === "edit")? $data["article_udm_fr"] : "" ?>">
						</div>
						<div class="col_4-inline">
							<label for="ABR_fr">ABR (fr)</label>
							<input class="form-element required" type="text" placeholder="Abréviation" id="ABR_fr" value="<?= ($action === "edit")? $data["ABR_fr"] : "" ?>">
						</div>
					</div>
				</div>	
				<div class="col_4">
					<div class="row">
						<div class="col_8-inline">
							<label for="article_udm_es">UDM (es)</label>
							<input class="form-element required" type="text" placeholder="Unidad" id="article_udm_es" value="<?= ($action === "edit")? $data["article_udm_es"] : "" ?>">
						</div>
						<div class="col_4-inline">
							<label for="ABR_es">ABR (es)</label>
							<input class="form-element required" type="text" placeholder="Abréviation" id="ABR_es" value="<?= ($action === "edit")? $data["ABR_es"] : "" ?>">
						</div>
					</div>
				</div>
				<div class="col_4">
					<div class="row">
						<div class="col_8-inline">
							<label for="article_udm_ar">UDM (ar)</label>
							<input class="form-element required" type="text" placeholder="Unidad" id="article_udm_ar" value="<?= ($action === "edit")? $data["article_udm_ar"] : "" ?>">
						</div>
						<div class="col_4-inline">
							<label for="ABR_ar">ABR (ar)</label>
							<input class="form-element required" type="text" placeholder="Abréviation" id="ABR_ar" value="<?= ($action === "edit")? $data["ABR_ar"] : "" ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="row" style="margin-bottom: 20px">
				<div class="col_6">
					<div class="" style="position: relative; width: 125px">
						<div class="on_off <?= ($action === "edit")? ($data["is_default"])? "on" : "off" : "off" ?> form-element" id="is_default"></div>
						<span style="position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px">
							  Par Défaut 
						</span>
					</div>
				</div>						
			</div>
		</div> <!-- ROW-->

	</div>	<!-- END PANEL CONTENT -->

</div>

<div class="debug"></div>


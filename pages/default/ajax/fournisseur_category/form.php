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
		<i class="fas fa-folder-open"></i> Fournisseur Category </span>
	</div>
	<div class="col_6-inline actions">
		<button class="btn btn-green save_form <?= ($action === "edit")? "edit" : "" ?>" data-table="<?= $table_name ?>"><i class="fas fa-save"></i></button>
		<button class="btn btn-default close" value="<?= $table_name ?>"><i class="fas fa-times"></i></button>
	</div>
</div>
<hr>

<div class="panel">
	
	<div class="panel-header" style="padding: 0px">
		<div class="panel-header-tab ">
			<a href="" class="active"><i class="fas fa-folder-open"></i> Détails</a>
		</div>
	</div>
	
	<div class="panel-content" style="padding: 0px">
		<div class="tab-content">
			<div class="row  <?= strtolower($table_name) ?>" style="margin-top: 25px">
			<?= ($action === "edit")? "<input class='form-element' type='hidden' id='id' value='".$id."'>" : "" ?>
				<div class="row" style="margin-bottom: 20px">
					<div class="col_4">
						<label for="fournisseur_category_fr">Catégorie</label>
						<input class="form-element required" type="text" placeholder="Catégorie" id="fournisseur_category_fr" value="<?= ($action === "edit")? $data["fournisseur_category_fr"] : "" ?>">
					</div>	
					<div class="col_4">
						<label for="fournisseur_category_es">Categoria</label>
						<input class="form-element required" type="text" placeholder="Categoria" id="fournisseur_category_es" value="<?= ($action === "edit")? $data["fournisseur_category_es"] : "" ?>">
					</div>	
					<div class="col_4">
						<label for="fournisseur_category_ar">الصنف</label>
						<input class="form-element required" type="text" placeholder="الصنف" id="fournisseur_category_ar" value="<?= ($action === "edit")? $data["fournisseur_category_ar"] : "" ?>">
					</div>	
				</div>
				<div class="row" style="margin-bottom: 20px">
					<div class="col_6">
						<div class="" style="position: relative; width: 125px">
							<div class="on_off <?= ($action === "edit")? ($data["status"])? "on" : "off" : "off" ?> form-element" id="status"></div>
							<span style="position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px">
								  Status
							</span>
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
		</div>
		
	</div>	<!-- END PANEL CONTENT -->

</div>

<div class="debug"></div>


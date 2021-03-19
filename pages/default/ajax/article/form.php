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
	
	
	/*
	$i=1;
	foreach($ob->fetchAll() as $k=>$v){
		$ob->save(array("id"=>$v["id"], "display_order"=>$i),"article");
			$i++;
	}	
	*/
	
	$ob->id = $_POST["id"];
	$id = $_POST["id"];
	

	
	if( count( $ob->read() ) < 1){ die("-4"); }
	$data = $ob->find("", array("conditions"=>array("id="=>$id)), "v_article")[0];
	$action = "edit";
	
}else{
	require_once($core.$table_name.".php");
	$ob = new $table_name();
}
//var_dump($data);

?>
<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-folder-open"></i> Article <span style="font-size: 9px"><?= ($action === "edit")? "<span style='color:red'>" . $data["UID"] . "</span>" : substr($formToken,0,8) ?></span>
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
			<a href="" class="refresh_tarif_achat" data="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>"  data-id="<?= ($action === "edit")? $data["id"] : 0 ?>"><i class="fas fa-shopping-cart"></i> Tarif Achat</a>
			<a href="" class="refresh_tarif_vente" data="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>"  data-id="<?= ($action === "edit")? $data["id"] : 0 ?>"><i class="fas fa-shopping-basket"></i> Tarif Vente</a>
			<a  href="" class="show_files article" data="<?= ($action === "edit")? ($data["UID"] !== "")? $data["UID"] : substr($formToken,0,8) : substr($formToken,0,8) ?>"><i class="fas fa-images"></i> Images</a>
		</div>
	</div>
	
	<div class="panel-content" style="padding: 0px">
		
		<div class="tab-content">
			<div class="row  <?= strtolower($table_name) ?>" style="margin-top: 25px">
			<?= ($action === "edit")? "<input class='form-element' type='hidden' id='id' value='".$id."'>" : "" ?>
				<input class='form-element' type='hidden' id='UID' value='<?= ($action === "edit")? (!is_null($data["UID"]))? $data["UID"] : substr($formToken,0,8) : substr($formToken,0,8) ?>'>
				
				<div class="row" style="margin-bottom: 20px">
					<div class="col_4">
						<label for="code">Code</label>
						<input class="form-element required" type="text" placeholder="Code" id="code" value="<?= ($action === "edit")? $data["code"] : intval($ob->getLastID())+1 ?>">
					</div>
					<div class="col_4">
						<label for="barcode">Barcode</label>
						<input class="form-element" type="text" placeholder="BarCode" id="barcode" value="<?= ($action === "edit")? $data["barcode"] : "" ?>">
					</div>
					<div class="col_4">
						<label for="code_fournisseur">Code Fournisseur</label>
						<input class="form-element" type="text" placeholder="Code Fournisseur" id="code_fournisseur" value="<?= ($action === "edit")? $data["code_fournisseur"] : "" ?>">
					</div>
				</div>
				<?php
					if($action === "edit"){
						$a = explode("//", $data["libelle_fr"]);
					} 
				?>
				<div class="row" style="margin-bottom: 20px">
					<div class="col_4">
						<label for="libelle_fr">Désignation (fr)</label>
						<input class="form-element required" type="text" placeholder="Désignation (fr)" id="libelle_fr" value="<?= ($action === "edit")? (count($a)>1)? $a[1]: $data["libelle_fr"]: "" ?>">
					</div>
					<div class="col_4">
						<label for="barcode">Désignation (es)</label>
						<input class="form-element required" type="text" placeholder="Désignation (es)" id="libelle_es" value="<?= ($action === "edit")? (count($a)>1)? $a[2]: $data["libelle_es"]: ""  ?>">
					</div>
					<div class="col_4">
						<label for="code_fournisseur">Désignation (ar)</label>
						<input class="form-element required" type="text" placeholder="Désignation (ar)" id="libelle_ar" value="<?= ($action === "edit")? (count($a)>1)? $a[0]: $data["libelle_ar"]: "" ?>">
					</div>
				</div>
				
				<div class="row" style="margin-bottom: 20px">
					<div class="col_4-inline">
						<label for="id_article_category">Article Catégorie</label>
						<select id="id_article_category" class="form-element required">
							<option selected value="-1"></option>
							<?php 
								require_once($core."Article_Category.php");
								foreach($article_category->find(null, array("conditions"=>array("status="=>1), "order"=>"article_category_fr"), null) as $k=>$v){
							?>
							<option <?= ($action === "edit")? ($v["id"] === $data["id_article_category"])? "selected" : "" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["article_category_fr"] . " " . $v["article_category_ar"] ?> </option>
							<?php } ?>
						</select>
					</div>
					
					<div class="col_4-inline">
						<label for="id_article_sous_category">Article Sous Catégorie</label>
						<select id="id_article_sous_category" class="form-element">
							<option selected value="-1"> --  Sous-Catégorie  -- </option>
							
							<?php 
								if($action === "edit"){
									require_once($core."Article_Sous_Category.php");
									
									$cond = array("id_article_category="=>$data["id_article_category"], "id_parent="=>"-1", "status="=>1);
									$d = $article_sous_category->find(null, array("conditions AND"=>$cond, "order"=>"article_sous_category_fr"), null);
									
									foreach($d as $k=>$v){
										if( $data["id_parent"] === "-1" || is_null($data["id_parent"])){
											$selected = ($v["id"] === $data["id_article_sous_category"])? "selected" : "";
										}else{
											$selected = ($v["id"] === $data["id_parent"])? "selected" : "";
										}
										
										echo '<option '. $selected .' value="' . $v["id"] . '">'.$v["article_sous_category_fr"] .' '. $v["article_sous_category_ar"]. ' </option>';
									}
								}
							?>
							
							
						</select>
					</div>
					
					<div class="col_4-inline">
						<label for="article_parent">Article Sous Catégorie</label>
						<select id="article_parent" class="form-element">
							<option selected value="-1"> --  Sous-Catégorie  -- </option>
							
							<?php 
								if($action === "edit"){
									require_once($core."Article_Sous_Category.php");
									
									$cond = array("id_article_category="=>$data["id_article_category"], "id_parent="=>$data["id_parent"], "status="=>1);
									$d = $article_sous_category->find(null, array("conditions AND"=>$cond, "order"=>"article_sous_category_fr"), null);
									
									foreach($d as $k=>$v){
											$selected = ($v["id"] === $data["id_article_sous_category"])? "selected" : "";
										
										echo '<option '. $selected .' value="' . $v["id"] . '">'.$v["article_sous_category_fr"] .' '. $v["article_sous_category_ar"]. ' </option>';
									}
								}
							?>
							
						</select>
					</div>
									
				</div>
				
				<!-- Type -->
				<div class="row" style="margin-bottom: 20px">
					<div class="col_3">
						<label for="id_article_type">Type</label>
						<select id="id_article_type" class="form-element required">
							<option selected value="-1"></option>
							<?php 
								require_once($core."Article_Type.php");
								foreach($article_type->find(null, array("order"=>"article_type_fr"), null) as $k=>$v){
							?>
							<option <?= ($action === "edit")? ($v["id"] === $data["id_article_type"])? "selected" : "" : ($v["is_default"])? "selected" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["article_type_fr"] ?> </option>
							<?php } ?>
						</select>
					</div>
					
					<div class="col_3">
						<label for="id_article_udm">Unité de Mesure</label>
						<select id="id_article_udm" class="form-element required">
							<option selected value="-1"></option>
							<?php 
								require_once($core."Article_UDM.php");
								foreach($article_udm->find(null, array("order"=>"article_udm_fr"), null) as $k=>$v){
							?>
							<option <?= ($action === "edit")? ($v["id"] === $data["id_article_udm"])? "selected" : "" : ($v["is_default"])? "selected" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["article_udm_fr"] . " (" . $v["ABR_fr"] . ")" ?> </option>
							<?php } ?>
						</select>
					</div>
					
					<div class="col_1">
						<label for="id_tva">TVA</label>
						<select id="id_tva" class="form-element required">
							<option selected value="-1"></option>
							<?php 
								require_once($core."Article_TVA.php");
								foreach($article_tva->find(null, array("order"=>"article_tva"), null) as $k=>$v){
							?>
							<option <?= ($action === "edit")? ($v["id"] === $data["id_tva"])? "selected" : "" : ($v["is_default"])? "selected" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["article_tva"] ?> </option>
							<?php } ?>
						</select>
					</div>
					
					<div class="col_2">
						<label for="id_article_status">Status</label>
						<select id="id_article_status" class="form-element required">
							<option selected value="-1"></option>
							<?php 
								require_once($core."Article_Status.php");
								foreach($article_status->find(null, array("order"=>"article_status_fr"), null) as $k=>$v){
							?>
							<option <?= ($action === "edit")? ($v["id"] === $data["id_article_status"])? "selected" : "" : ($v["is_default"])? "selected" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["article_status_fr"] ?> </option>
							<?php } ?>
						</select>
					</div>
					
					<div class="col_3">
						<label for="id_article_marque">Marque</label>
						<select id="id_article_marque" class="form-element">
							<option selected value="-1"></option>
							<?php 
								require_once($core."Article_Marque.php");
								foreach($article_marque->find(null, array("conditions"=>array("status="=>1), "order"=>"article_marque"), null) as $k=>$v){
							?>
							<option <?= ($action === "edit")? ($v["id"] === $data["id_article_marque"])? "selected" : "" : ($v["is_default"])? "selected" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["article_marque"] ?> </option>
							<?php } ?>
						</select>
					</div>
					
				</div>
				
				<!-- Poid -->
				<div class="row" style="margin-bottom: 20px">
					<div class="col_6">
						<div class="row">
							<div class="col_4-inline">
								<label for="poid">Poid (Kg)</label>
								<input id="poid" class="form-element" type="number" value="<?= ($action === "edit")? $data["poid"] : "0" ?>">
							</div>
							<div class="col_4-inline">
								<label for="poid_caisse">Poid en Caisse (Kg)</label>
								<input id="poid_caisse" class="form-element" type="number" value="<?= ($action === "edit")? $data["poid_caisse"] : "0" ?>">
							</div>
							<div class="col_4-inline">
								<label for="qte_caisse">Unité en Caisse</label>
								<input id="qte_caisse" class="form-element" type="number" value="<?= ($action === "edit")? $data["qte_caisse"] : "0" ?>">
							</div>
						</div>
					</div>
				</div>

				<div class="row" style="margin-bottom: 20px">
					<div class="col_6">
						<div class="row">
							<div class="col_4-inline">
								<label for="poid">Poid (Kg)</label>
								<input id="poid" class="form-element" type="number" value="<?= ($action === "edit")? $data["poid"] : "0" ?>">
							</div>
							<div class="col_4-inline">
								<label for="poid_caisse">Poid en Caisse (Kg)</label>
								<input id="poid_caisse" class="form-element" type="number" value="<?= ($action === "edit")? $data["poid_caisse"] : "0" ?>">
							</div>
							<div class="col_4-inline">
								<label for="qte_caisse">Unité en Caisse</label>
								<input id="qte_caisse" class="form-element" type="number" value="<?= ($action === "edit")? $data["qte_caisse"] : "0" ?>">
							</div>
						</div>
					</div>
				</div>

				<div class="row" style="margin-bottom: 20px">
					<div class="col_12-inline">
						<h3>Commande</h3>						
					</div>
				</div>

				<div class="row" style="margin-bottom: 20px">
					<div class="col_6">
						<div class="row">
							<div class="col_4-inline">
								<label for="poid">Quantité Min</label>
								<input id="qte_min" class="form-element" type="number" value="<?= ($action === "edit")? $data["qte_min"] : "0" ?>">
							</div>
							<div class="col_4-inline">
								<label for="poid">Quantité Max</label>
								<input id="qte_max" class="form-element" type="number" value="<?= ($action === "edit")? $data["qte_max"] : "0" ?>">
							</div>
						</div>						
					</div>
				</div>
				
				<div class="row" style="margin-bottom: 20px">
					<div class="col_12-inline">
						<div class="row" style="margin-bottom: 20px;">
							<div class="col_12">
								<label for="is_allow_stock_negative">
									<input class="form-element" type="checkbox" id="is_allow_stock_negative" <?= ($action === "edit")? ($data["is_allow_stock_negative"])? "checked" : "" : "" ?>> Permettre Stock négative
								</label>					
							</div>
						</div>	
						<div class="row" style="margin-bottom: 20px;">
							<div class="col_12">
								<label for="is_prix_bloquer">
									<input class="form-element" type="checkbox" id="is_prix_bloquer" <?= ($action === "edit")? ($data["is_prix_bloquer"])? "checked" : "" : "" ?>> Prix bloqué
								</label>					
							</div>
						</div>
						
						<div class="row" style="margin-bottom: 20px;">
							<div class="col_12">
								<label for="is_sur_commande">
									<input class="form-element" type="checkbox" id="is_sur_commande" <?= ($action === "edit")? ($data["is_sur_commande"])? "checked" : "" : "" ?>> Sur Commande
								</label>					
							</div>
						</div>
						
						<div class="row" style="margin-bottom: 20px;">
							<div class="col_12">
								<label for="is_new">
									<input class="form-element" type="checkbox" id="is_new" <?= ($action === "edit")? ($data["is_new"])? "checked" : "" : "" ?>> Marqué Nouveau
								</label>					
							</div>
						</div>
					</div>
				</div>
				
				<div class="row" style="margin-bottom: 20px">
					<div class="col_4">
						<label for="display_order" style="display:block">Ordre الترتيب</label>
						<input class="form-element required" style="text-align: center; font-size: 18px; max-width: 95px; font-weight: bold" type="number" placeholder="0" id="display_order" value="<?= ($action === "edit")? $data["display_order"]: 0 ?>">
					</div>
				</div>
				
			</div> <!-- ROW-->
		</div>
		
		<div class="tab-content" style="display: none" >

			<div class="row">
				<div class="col_4-inline">
					<h3 style="margin-left: 6px">Tarifs Achat</h3>
				</div>
				<div class="col_8-inline" style="text-align: right; padding: 10px 5px">
					<button class="btn btn-green select_tarif_achat" data-id="<?= ($action === "edit")? $data["id"] : 0 ?>" value="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>"><i class="fas fa-plus-square"></i> Ajouter</button>
					<button class="btn btn-default refresh_tarif_achat" data-id="<?= ($action === "edit")? $data["id"] : 0 ?>" value="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>"><i class="fas fa-sync-alt"></i></button>
				</div>
			</div>

			<div class="row">
				<div class="col_12 achat_tarif">

				</div>
			</div>
			
		</div>
		
		<div class="tab-content" style="display: none" >
			<div class="row">
				<div class="col_4-inline">
					<h3 style="margin-left: 6px">Tarifs Vente</h3>
				</div>
				<div class="col_8-inline" style="text-align: right; padding: 10px 5px">
					<button class="btn btn-green select_tarif_vente" data-id="<?= ($action === "edit")? $data["id"] : 0 ?>" value="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>"><i class="fas fa-plus-square"></i> Ajouter</button>
					<button class="btn btn-default refresh_tarif_vente" data-id="<?= ($action === "edit")? $data["id"] : 0 ?>" value="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>"><i class="fas fa-sync-alt"></i></button>
				</div>
			</div>
			
			<div class="row">
				<div class="col_12 vente_tarif">

				</div>
			</div>
			
		</div>
		
		<div class="tab-content" style="display: none" >
			<div class="row upload">
				<div class="col_4-inline">
					<h3>Images</h3>
				</div>

				<div class="col_8-inline" style="text-align: right; padding-top: 10px">
					<button class="btn btn-orange upload_btn" style="position: relative; overflow: hidden">
					<i class="fas fa-upload"></i> Choisir
					<input type="file" id="upload_file_article" data="<?= ($action === "edit")? (!is_null($data["UID"]))? $data["UID"] : substr($formToken,0,8) : substr($formToken,0,8) ?>" class="" name="image" capture style="position: absolute; z-index: 9999; top: 0; left: 0; background-color: aqua; padding: 10px 0; opacity: 0">
					</button>	
					<button class="btn btn-blue show_files article" value="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>"> Actualiser </button>					
				</div>

				<div class="col_12">
					<div id="progress" class="progress hide"><div id="progress-bar" class="progress-bar"></div></div>
				</div>
			</div>

			<div class="show_files_result"></div>
		</div>
		
	</div>	<!-- END PANEL CONTENT -->

</div>

<div class="debug"></div>


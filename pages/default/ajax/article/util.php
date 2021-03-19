<?php session_start();

$response  = array("code"=>0, "msg"=>"Error");


if(!isset($_SESSION['CORE'])){die(json_encode($response));}
if(!isset($_POST['module'])){$response["msg"]="Error Data"; die(json_encode($response));}



$core = $_SESSION['CORE'];

$module = $_POST["module"];
switch ($module){
	case "is_visible":
		$id_article = $_POST["id_article"];
		$web_status = $_POST["web_status"];
		
		require_once($core."Article.php");
		$article->save(array("id"=>$id_article, "is_visible_on_web"=>$web_status));
		$response  = array("code"=>1, "msg"=>"Success");
		
	break;
		
	case "category":
		
		$id_category = $_POST["id_category"];
		
		
		require_once($core."Article_Sous_Category.php");
		$data = "<option value='-1'> Sous Categorie </option>";
		foreach($article_sous_category->find(null, array("conditions AND"=>array("id_article_category="=>$id_category, "id_parent="=>-1), "order"=>"article_sous_category_fr"), "article_sous_category") as $k=>$v){ 
			$data .= "<option value='" . $v["id"] . "'>" . $v["id"] . " : " . $v["article_sous_category_fr"]. " " . $v["article_sous_category_ar"].  "</option>";
		}
		$response  = array("code"=>1, "msg"=>$data);
	break;
		
	case "sous_category":
		
		$id_category = $_POST["id_category"];
		$id_sous_category = $_POST["id_sous_category"];
		
		
		require_once($core."Article_Sous_Category.php");
		$data = "<option value='-1'> Sous Categorie </option>";
		foreach($article_sous_category->find(null, array("conditions AND"=>array("id_article_category="=>$id_category, "id_parent="=>$id_sous_category), "order"=>"article_sous_category_fr"), "article_sous_category") as $k=>$v){ 
			$data .= "<option value='" . $v["id"] . "'>" . $v["id"] . " : " . $v["article_sous_category_fr"]. " " . $v["article_sous_category_ar"].  "</option>";
		}
		$response  = array("code"=>1, "msg"=>$data);
	break;
		
	case "achat":
		
		//require_once($core.'Caisse_Alimentation.php');
		
		$UID = $_POST["UID"];
		$ID = $_POST["id"];
		
		$data = "<div class='panel' style='overflow:auto; width:100%; z-index: 999999'>";
		$data .= "	<div class='panel-header' style='padding-right:0'>Tarif De Vente<span class='_close'><button class='btn btn-default btn-red'>Fermer</button></span></div>";
		$data .= "	<div class='panel-content' style='padding: 0'>";
		$data .= "		<h3 style='margin-left:10px'>Vente Tarif</h3>";
		
		$data .= "		<div class='row' style='margin-top: 20px'>";
		$data .= "			<div class='col_6-inline'>";
		$data .= "  			<label for='id_fournisseur'>Fournisseur</label>";	
		$data .= "  			<select id='id_fournisseur'>";
		$data .= "  				<option value='0'>  </option>";
		
		
		require_once($core.'Fournisseur.php');		
		$fourniss = $fournisseur->find(null,array("conditions"=>array("status="=>1)),null);
		foreach($fourniss as $k=>$v){
		$data .= "  				<option value='".$v["id"]."'> ".$v["fournisseur_name"]." </option>";

		}
		$data .= "  			</select>";
		$data .= "			</div>";
		$data .= "			<div class='col_6-inline'>";
		$data .= "  			<label for='montant'>Montant</label>";	
		$data .= "				<input style='text-align:center; font-size:14px; font-weight:bold' id='montant' type='number' placeholder='0.00' value=''>";
		$data .= "			</div>";					
		$data .= "		</div>";
		
		$data .= "		<div class='row' style='margin-top: 20px'>";
		$data .= "			<div class='col_12'>";
		$data .= "				<div style='position: relative; width: 165px'>";
		$data .= "					<div class='on_off on' id='tarif_achat_status'></div>";
		$data .= "					<span style='position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px'>";
		$data .= "				  		Activé / Désactivé ";
		$data .= "					</span>";
		$data .= "				</div>";
		$data .= "			</div>";					
		$data .= "		</div>";
		
		$data .= "		<div class='row' style='margin-top: 20px'>";
		$data .= "			<div class='col_12'>";
		$data .= "				<div style='position: relative; width: 165px'>";
		$data .= "					<div class='on_off off' id='tarif_achat_is_default'></div>";
		$data .= "					<span style='position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px'>";
		$data .= "				  		Principal ";
		$data .= "					</span>";
		$data .= "				</div>";
		$data .= "			</div>";					
		$data .= "		</div>";
		
		$data .= "  	<div class='row' style='margin-top:20px; padding:10px 0;background: #fafafa; border-top:#ccc 1px solid '>";
		$data .= "  		<div class='col_6-inline'>";
		$data .= "  			<button class='btn btn-green tarif_achat save' value='".$UID."' data-id='" . $ID . "'><i class='fas fa-save'></i> Enregistrer</button>";
		$data .= "  		</div>";
		$data .= "		</div>";
		
		$data .= "	</div>";
		$data .= "	</div>";
		
		$response  = array("code"=>1, "msg"=>$data);

	break;
		
	case "achat_edit":
		
		//require_once($core.'Caisse_Alimentation.php');
		require_once($core.'Article_Tarif_Achat.php');
		$ID = $_POST["id"];
		$article_tarif_achat->id = $ID;
		$d = $article_tarif_achat->read()[0];
		
		$data = "<div class='panel' style='overflow:auto; width:100%; z-index: 999999'>";
		$data .= "	<div class='panel-header' style='padding-right:0'>Tarif De Vente<span class='_close'><button class='btn btn-default btn-red'>Fermer</button></span></div>";
		$data .= "	<div class='panel-content' style='padding: 0'>";
		$data .= "		<h3 style='margin-left:10px'>Achat Tarif</h3>";
		
		$data .= "		<div class='row' style='margin-top: 20px'>";
		$data .= "			<div class='col_6-inline'>";
		$data .= "  			<label for='id_fournisseur'>Tarif</label>";	
		$data .= "  			<select id='id_fournisseur'>";
		$data .= "  				<option value='0'>  </option>";
		
		
		require_once($core.'Fournisseur.php');		
		$tarifs = $fournisseur->find(null,array("conditions"=>array("status="=>1)),null);
		foreach($tarifs as $k=>$v){
			if($v["id"] === $d["id_fournisseur"]){
		$data .= "  				<option selected value='".$v["id"]."'> ".$v["fournisseur_name"]." </option>";
			}else{
		$data .= "  				<option value='".$v["id"]."'> ".$v["fournisseur_name"]." </option>";
			}
		}
		$data .= "  			</select>";
		$data .= "			</div>";
		$data .= "			<div class='col_6-inline'>";
		$data .= "  			<label for='montant'>Montant</label>";	
		$data .= "				<input style='text-align:center; font-size:14px; font-weight:bold' id='montant' type='number' placeholder='0.00' value='".$d["montant"]."'>";
		$data .= "			</div>";					
		$data .= "		</div>";
		
		$data .= "		<div class='row' style='margin-top: 20px'>";
		$data .= "			<div class='col_12'>";
		$data .= "				<div style='position: relative; width: 165px'>";
		
		$on_off = ($d["status"])? "on": "off";
		$is_default = ($d["is_default"])? "on": "off";
		
		$data .= "					<div class='on_off ".$on_off."' id='tarif_achat_status'></div>";
		$data .= "					<span style='position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px'>";
		$data .= "				  		Activé / Désactivé ";
		$data .= "					</span>";
		$data .= "				</div>";
		$data .= "			</div>";					
		$data .= "		</div>";
		
		$data .= "		<div class='row' style='margin-top: 20px'>";
		$data .= "			<div class='col_12'>";
		$data .= "				<div style='position: relative; width: 165px'>";
		$data .= "					<div class='on_off ".$is_default."' id='tarif_achat_is_default'></div>";
		$data .= "					<span style='position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px'>";
		$data .= "				  		Principal ";
		$data .= "					</span>";
		$data .= "				</div>";
		$data .= "			</div>";					
		$data .= "		</div>";
		
		$data .= "  	<div class='row' style='margin-top:20px; padding:10px 0;background: #fafafa; border-top:#ccc 1px solid '>";
		$data .= "  		<div class='col_6-inline'>";
		$data .= "  			<button class='btn btn-green tarif_achat save edit' data-id='".$d["id_article"]."' data-uid='".$d["UID"]."' value='" . $ID . "'><i class='fas fa-save'></i> Enregistrer</button>";
		$data .= "  		</div>";
		$data .= "		</div>";
		
		$data .= "	</div>";
		$data .= "	</div>";
		
		$response  = array("code"=>1, "msg"=>$data);

	break;
		
	case "vente":
		
		//require_once($core.'Caisse_Alimentation.php');
		
		$UID = $_POST["UID"];
		$ID = $_POST["id"];
		
		$data = "<div class='panel' style='overflow:auto; width:100%; z-index: 999999'>";
		$data .= "	<div class='panel-header' style='padding-right:0'>Tarif De Vente<span class='_close'><button class='btn btn-default btn-red'>Fermer</button></span></div>";
		$data .= "	<div class='panel-content' style='padding: 0'>";
		$data .= "		<h3 style='margin-left:10px'>Vente Tarif</h3>";
		
		$data .= "		<div class='row' style='margin-top: 20px'>";
		$data .= "			<div class='col_6-inline'>";
		$data .= "  			<label for='id_article_tarif'>Tarif</label>";	
		$data .= "  			<select id='id_article_tarif'>";
		$data .= "  				<option value='0'>  </option>";
		
		
		require_once($core.'Article_Tarif.php');		
		$tarifs = $article_tarif->find(null,array("conditions"=>array("status="=>1)),null);
		foreach($tarifs as $k=>$v){
			if($v["is_default"]){
		$data .= "  				<option selected value='".$v["id"]."'> ".$v["article_tarif"]." </option>";
			}else{
		$data .= "  				<option value='".$v["id"]."'> ".$v["article_tarif"]." </option>";
			}
		}
		$data .= "  			</select>";
		$data .= "			</div>";
		$data .= "			<div class='col_6-inline'>";
		$data .= "  			<label for='montant'>Montant</label>";	
		$data .= "				<input style='text-align:center; font-size:14px; font-weight:bold' id='montant' type='number' placeholder='0.00' value=''>";
		$data .= "			</div>";					
		$data .= "		</div>";
		
		$data .= "		<div class='row' style='margin-top: 20px'>";
		$data .= "			<div class='col_12'>";
		$data .= "				<div style='position: relative; width: 165px'>";
		$data .= "					<div class='on_off on' id='tarif_vente_status'></div>";
		$data .= "					<span style='position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px'>";
		$data .= "				  		Activé / Désactivé ";
		$data .= "					</span>";
		$data .= "				</div>";
		$data .= "			</div>";					
		$data .= "		</div>";
		
		$data .= "		<div class='row' style='margin-top: 20px'>";
		$data .= "			<div class='col_12'>";
		$data .= "				<div style='position: relative; width: 165px'>";
		$data .= "					<div class='on_off off' id='tarif_vente_is_default'></div>";
		$data .= "					<span style='position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px'>";
		$data .= "				  		Principal ";
		$data .= "					</span>";
		$data .= "				</div>";
		$data .= "			</div>";					
		$data .= "		</div>";
		
		$data .= "  	<div class='row' style='margin-top:20px; padding:10px 0;background: #fafafa; border-top:#ccc 1px solid '>";
		$data .= "  		<div class='col_6-inline'>";
		$data .= "  			<button class='btn btn-green tarif_vente save' value='".$UID."' data-id='" . $ID . "'><i class='fas fa-save'></i> Enregistrer</button>";
		$data .= "  		</div>";
		$data .= "		</div>";
		
		$data .= "	</div>";
		$data .= "	</div>";
		
		$response  = array("code"=>1, "msg"=>$data);

	break;
	
		
	case "vente_edit":
		
		//require_once($core.'Caisse_Alimentation.php');
		require_once($core.'Article_Tarif_Vente.php');
		$ID = $_POST["id"];
		$article_tarif_vente->id = $ID;
		$d = $article_tarif_vente->read()[0];
		
		$data = "<div class='panel' style='overflow:auto; width:100%; z-index: 999999'>";
		$data .= "	<div class='panel-header' style='padding-right:0'>Tarif De Vente<span class='_close'><button class='btn btn-default btn-red'>Fermer</button></span></div>";
		$data .= "	<div class='panel-content' style='padding: 0'>";
		$data .= "		<h3 style='margin-left:10px'>Vente Tarif</h3>";
		
		$data .= "		<div class='row' style='margin-top: 20px'>";
		$data .= "			<div class='col_6-inline'>";
		$data .= "  			<label for='id_article_tarif'>Tarif</label>";	
		$data .= "  			<select id='id_article_tarif'>";
		$data .= "  				<option value='0'>  </option>";
		
		
		require_once($core.'Article_Tarif.php');		
		$tarifs = $article_tarif->find(null,array("conditions"=>array("status="=>1)),null);
		foreach($tarifs as $k=>$v){
			if($v["id"] === $d["id_article_tarif"]){
		$data .= "  				<option selected value='".$v["id"]."'> ".$v["article_tarif"]." </option>";
			}else{
		$data .= "  				<option value='".$v["id"]."'> ".$v["article_tarif"]." </option>";
			}
		}
		$data .= "  			</select>";
		$data .= "			</div>";
		$data .= "			<div class='col_6-inline'>";
		$data .= "  			<label for='montant'>Montant</label>";	
		$data .= "				<input style='text-align:center; font-size:14px; font-weight:bold' id='montant' type='number' placeholder='0.00' value='".$d["montant"]."'>";
		$data .= "			</div>";					
		$data .= "		</div>";
		
		$data .= "		<div class='row' style='margin-top: 20px'>";
		$data .= "			<div class='col_12'>";
		$data .= "				<div style='position: relative; width: 165px'>";
		
		$on_off = ($d["status"])? "on": "off";
		$is_default = ($d["is_default"])? "on": "off";
		
		$data .= "					<div class='on_off ".$on_off."' id='tarif_vente_status'></div>";
		$data .= "					<span style='position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px'>";
		$data .= "				  		Activé / Désactivé ";
		$data .= "					</span>";
		$data .= "				</div>";
		$data .= "			</div>";					
		$data .= "		</div>";
		
		$data .= "		<div class='row' style='margin-top: 20px'>";
		$data .= "			<div class='col_12'>";
		$data .= "				<div style='position: relative; width: 165px'>";
		$data .= "					<div class='on_off ".$is_default."' id='tarif_vente_is_default'></div>";
		$data .= "					<span style='position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px'>";
		$data .= "				  		Principal ";
		$data .= "					</span>";
		$data .= "				</div>";
		$data .= "			</div>";					
		$data .= "		</div>";
		
		$data .= "  	<div class='row' style='margin-top:20px; padding:10px 0;background: #fafafa; border-top:#ccc 1px solid '>";
		$data .= "  		<div class='col_6-inline'>";
		$data .= "  			<button class='btn btn-green tarif_vente save edit' data-id='".$d["id_article"]."' data-uid='".$d["UID"]."' value='" . $ID . "'><i class='fas fa-save'></i> Enregistrer</button>";
		$data .= "  		</div>";
		$data .= "		</div>";
		
		$data .= "	</div>";
		$data .= "	</div>";
		
		$response  = array("code"=>1, "msg"=>$data);

	break;
		
}
/*
echo $response["msg"];
die();
*/
echo json_encode($response);

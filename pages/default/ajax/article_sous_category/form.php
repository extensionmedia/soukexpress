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

<div class="container">

	<div class="row page_title">
		<div class="col_6-inline icon">
			<i class="fas fa-folder-open"></i> Sous Category <span style="font-size: 9px"><?= ($action === "edit")? "<span style='color:red'>" . $data["UID"] . "</span>" : substr($formToken,0,8) ?></span>
		</div>
		<div class="col_6-inline actions">
			<button class="btn btn-green save_form <?= (isset($_POST["sub"]))? "sub":"" ?> <?= ($action === "edit")? "edit" : "" ?>" data-table="<?= $table_name ?>"><i class="fas fa-save"></i></button>
			<button class="btn btn-default close <?= (isset($_POST["sub"]))? "sub":"" ?>" value="<?= $table_name ?>"><i class="fas fa-times"></i></button>
		</div>
	</div>
	<hr>

	<div class="panel">

		<div class="panel-header" style="padding: 0px">
			<div class="panel-header-tab ">
				<a href="" class="active"><i class="fas fa-folder-open"></i> Détails</a>
				<a  href="" class="show_files sous_category" data="<?= ($action === "edit")? ($data["UID"] !== "")? $data["UID"] : substr($formToken,0,8) : substr($formToken,0,8) ?>"><i class="fas fa-images"></i> Images</a>
			</div>
		</div>

		<div class="panel-content" style="padding: 0px">
			<div class="tab-content">
				<div class="row  <?= strtolower($table_name) ?>" style="padding: 0 20px; margin-top: 25px;">
				<?= ($action === "edit")? "<input class='form-element' type='hidden' id='id' value='".$id."'>" : "" ?>
					<input class='form-element' type='hidden' id='UID' value='<?= ($action === "edit")? ($data["UID"] !== "")? $data["UID"] : substr($formToken,0,8) : substr($formToken,0,8) ?>'>
					<div class="row" style="margin-bottom: 20px">
						<div class="col_4">
							<label for="article_sous_category_fr">Sous Catégorie</label>
							<input class="form-element required" type="text" placeholder="Catégorie" id="article_sous_category_fr" value="<?= ($action === "edit")? $data["article_sous_category_fr"] : "" ?>">
						</div>	
						<div class="col_4">
							<label for="article_sous_category_es">Suve Categoria</label>
							<input class="form-element required" type="text" placeholder="Categoria" id="article_sous_category_es" value="<?= ($action === "edit")? $data["article_sous_category_es"] : "" ?>">
						</div>	
						<div class="col_4">
							<label for="article_sous_category_ar">الصنف الفرعي</label>
							<input class="form-element required" type="text" placeholder="الصنف الفرعي" id="article_sous_category_ar" value="<?= ($action === "edit")? $data["article_sous_category_ar"] : "" ?>">
						</div>	
					</div>
					<div class="row" style="margin-bottom: 20px">
						<div class="col_6">
							<label for="id_article_category">Article Catégorie</label>
							<select id="id_article_category" class="form-element required">
								<option selected value="-1"></option>
								<?php 
									require_once($core."Article_Category.php");
									foreach($article_category->find(null, array("conditions"=>array("status="=>1), "order"=>"article_category_fr"), null) as $k=>$v){
								?>
								<option <?= ($action === "edit")? ($v["id"] === $data["id_article_category"])? "selected" : "" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["article_category_fr"] ?> </option>
								<?php } ?>
							</select>
						</div>

						<div class="col_6">
							<label for="id_parent">Catégorie Parent</label>
							<select id="id_parent" class="form-element">
								<option selected value="-1"></option>
								<?php 
									require_once($core."Article_Sous_Category.php");
									foreach($article_sous_category->find(null, array("conditions AND"=>array("status="=>1, "id_parent="=>-1), "order"=>"article_sous_category_fr"), null) as $k=>$v){
								?>
								<option <?= ($action === "edit")? ($v["id"] === $data["id_parent"])? "selected" : "" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["article_sous_category_fr"] . " " . $v["article_sous_category_ar"] ?> </option>
								<?php } ?>
							</select>
						</div>

					</div>
					<div class="row" style="margin-bottom: 20px">
						<div class="col_6">
							<label for="ord">Ordre</label>
							<input class="form-element required" type="number" placeholder="Ordre" id="ord" value="<?= ($action === "edit")? $data["ord"] : "" ?>">
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
				</div> <!-- ROW-->
			</div>

			<div class="tab-content" style="display: none" >
				<div class="row upload">
					<div class="col_4-inline">
						<h3>Images</h3>
					</div>

					<div class="col_8-inline" style="text-align: right; padding-top: 10px">
						<button class="btn btn-orange upload_btn" style="position: relative; overflow: hidden">
						<i class="fas fa-upload"></i> Choisir
						<input type="file" id="upload_file_sous_category" data="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>" class="" name="image" capture style="position: absolute; z-index: 9999; top: 0; left: 0; background-color: aqua; padding: 10px 0; opacity: 0">
						</button>	
						<button class="btn btn-blue show_files sous_category" value="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>"> Actualiser </button>					
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
</div>




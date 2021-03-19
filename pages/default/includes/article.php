<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$core = $_SESSION["CORE"];
$table_name = "Article";
require_once($core.$table_name.".php");  
$ob = new $table_name();
//$ob->createWatermark(array("article_folder"=>"274CAFA8"));
?>

<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-address-card"></i> 
		Artiles
	</div>
	<div class="col_6-inline actions">
		<button class="btn btn-green add" value="<?= $table_name ?>"><i class="fas fa-plus" aria-hidden="true"></i></button>
		<button class="btn btn-default refresh" value="<?= $table_name ?>"><i class="fas fa-sync-alt"></i></button>
		<button class="btn btn-orange showSearchBar"><i class="fas fa-search-plus"></i></button>
	</div>
</div>
<hr>
<div class="row searchBar" style="background-color: rgba(241,241,241,1.00); padding: 10px 0; margin: 10px 0px">
	<div class="col_3">

		<div class="input-group" style="overflow: hidden; margin-top: 10px">
			<input type="text" placeholder="Chercher" class="suf" name="" id="request">
			<div class="input-suf"><button title="Chercher" id="a_u_s" class="_propriete" data="_request"><i class="fa fa-search"></i></button></div>
		</div>

	</div>
	<div class="col_9">
		<div class="row _select" style="margin-top: 10px">
			<div class="col_2-inline">
				<select id="article_category" data="category">
					<option selected value="-1"> --  Catégorie  -- </option>
						<?php require_once($core."Article_Category.php"); 
							foreach( $article_category->find("", array("order"=>"article_category_fr"), "") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= strtoupper( $v["article_category_fr"] ) . " " . $v["article_category_ar"] ?> </option>
						<?php } ?>
				</select>
			</div>
			<div class="col_2-inline">
				<select id="article_sous_category" data="sous_category">
					<option selected value="-1"> --  Sous-Catégorie  -- </option>
				</select>
			</div>
			<div class="col_2-inline">
				<select id="article_parent" data="parent">
					<option selected value="-1"> --  Sous-Catégorie  -- </option>
				</select>
			</div>
			<div class="col_2-inline">
				<select id="article_type" data="type">
					<option selected value="-1"> --  Type  -- </option>
						<?php require_once($core."Article_Type.php"); 
							foreach( $article_type->find("", array(), "") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= strtoupper( $v["article_type_fr"] ) . " " . $v["article_type_ar"] ?> </option>
						<?php } ?>
				</select>
			</div>
			<div class="col_2-inline">
				<select id="article_type" data="status">
					<option selected value="-1"> --  Status  -- </option>
						<?php require_once($core."Article_Status.php"); 
							foreach( $article_status->find("", array(), "") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= strtoupper( $v["article_status_fr"] ) . " " . $v["article_status_ar"] ?> </option>
						<?php } ?>
				</select>
			</div>
			<div class="col_2-inline">
				<select id="article_type" data="marque">
					<option selected value="-1"> --  Marque  -- </option>
						<?php require_once($core."Article_Marque.php"); 
							foreach( $article_marque->find("", array("conditions"=>array("status="=>1), "order"=>"article_marque"), "") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= strtoupper( $v["article_marque"] ) . " " . $v["article_marque_ar"] ?> </option>
						<?php } ?>
				</select>
			</div>
		</div>

	</div>

	<div class="col_12 _choices" style="padding-top: 15px"></div>


</div>

<div class="row <?= strtolower($table_name) ?>">
	<?php 	
	
	$args = array(
		"p_p"		=>	(isset($_POST['data']['p_p']))? $_POST['data']['p_p'] : null,
		"sort_by"	=>	(isset($_POST['data']['sort_by']))? $_POST['data']['sort_by'] : "display_order asc",
		"current"	=>	(isset($_POST['data']['current']))? $_POST['data']['current'] : null,
		"style"	=>	(isset($_POST['data']['style']))? $_POST['data']['style'] : "list",
	);
		$args = ( isset($_SESSION["REQUEST"][$table_name]["args"]) )? $_SESSION["REQUEST"][$table_name]["args"]: $args;
	 //var_dump($args);
	 	$conditions = ( isset($_SESSION["REQUEST"][$table_name]["cond"]) )? $_SESSION["REQUEST"][$table_name]["cond"]: null;

	?>
	<?= $ob->drawTable($args, $conditions, "v_article") ?>
</div>

<div class="debug"></div>

<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$core = $_SESSION["CORE"];
$table_name = "Article_Sous_Category";
require_once($core.$table_name.".php");  
$ob = new $table_name();
$conditions = array("conditions"=>array("id_parent="=>-1));
?>

<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-folder-open"></i> 
		SOUS CATEGORIE
	</div>
	<div class="col_6-inline actions">
		<button class="btn btn-green add" value="<?= $table_name ?>"><i class="fas fa-plus" aria-hidden="true"></i></button>
		<button class="btn btn-default refresh" value="<?= $table_name ?>"><i class="fas fa-sync-alt"></i></button>
		<button class="btn btn-orange showSearchBar"><i class="fas fa-search-plus"></i></button>
	</div>
</div>
<hr>
<div class="row searchBar hide" style="background-color: rgba(241,241,241,1.00); padding: 10px 0; margin: 10px 0px">
	<div class="col_6-inline">

		<div class="input-group" style="overflow: hidden">
			<input type="text" placeholder="Chercher" class="suf" name="" id="request">
			<div class="input-suf"><button title="Chercher" id="a_u_s"><i class="fa fa-search"></i></button></div>
		</div>

	</div>
	<div class="col_6-inline">
		<div class="row _select" style="">
			<div class="col_12-inline">
				<select id="article__category" data="category">
					<option selected value="-1"> --  Catégorie  -- </option>
						<?php require_once($core."Article_Category.php"); 
							foreach( $article_category->find("", array("order"=>"article_category_fr"), "") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= strtoupper( $v["article_category_fr"] ) . " " . $v["article_category_ar"] ?> </option>
						<?php } ?>
				</select>
			</div>
		</div>
	</div>
	<div class="col_12 _choices" style="padding-top: 15px"></div>
</div>
<div class="row <?= $table_name ?>">
	<?php 	
	//var_dump($_SESSION["REQUEST"][$table_name]);
	//unset($_SESSION["REQUEST"]);
	$args = array(
		"p_p"		=>	(isset($_POST['data']['p_p']))? $_POST['data']['p_p'] : null,
		"sort_by"	=>	(isset($_POST['data']['sort_by']))? $_POST['data']['sort_by'] : "ord",
		"current"	=>	(isset($_POST['data']['current']))? $_POST['data']['current'] : null,
		"style"	=>	(isset($_POST['data']['style']))? $_POST['data']['style'] : "list",
	);
		$args = ( isset($_SESSION["REQUEST"][$table_name]["args"]) )? $_SESSION["REQUEST"][$table_name]["args"]: $args;
	 	$conditions = ( isset($_SESSION["REQUEST"][$table_name]["cond"]) )? $_SESSION["REQUEST"][$table_name]["cond"]: array("conditions"=>array("id_parent="=>-1));

	?>
	<?= $ob->drawTable($args, $conditions, "") ?>	
</div>


<div class="debug"></div>

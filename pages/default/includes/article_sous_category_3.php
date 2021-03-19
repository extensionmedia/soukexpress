<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$core = $_SESSION["CORE"];
$table_name = "Article_Sous_Category";
require_once($core.$table_name.".php");  
$ob = new $table_name();

$conditions = array("conditions"=>array("id_parent>"=>0));

?>

<div class="container">
	<div class="row page_title">
		<div class="col_6-inline icon">
			<i class="fas fa-folder-open"></i> 
			SOUS CATEGORIE (2)
		</div>
		<div class="col_6-inline actions">
			<button class="btn btn-green add sub" value="<?= $table_name ?>"><i class="fas fa-plus" aria-hidden="true"></i></button>
			<button class="btn btn-default refresh sub" value="<?= $table_name ?>"><i class="fas fa-sync-alt"></i></button>
			<button class="btn btn-orange showSearchBar"><i class="fas fa-search-plus"></i></button>
		</div>
	</div>
	<hr>
	<div class="row searchBar hide" style="background-color: rgba(241,241,241,1.00); padding: 10px 0; margin: 10px 0px">
		<div class="col_12-inline">

			<div class="input-group" style="overflow: hidden">
				<input type="text" placeholder="Chercher" class="suf" name="" id="request">
				<div class="input-suf"><button title="Chercher" id="a_u_s"><i class="fa fa-search"></i></button></div>
			</div>

		</div>
		<div class="col_5-inline">

		</div>
	</div>
	<div class="row <?= $table_name ?>">
		<?php 	
		//var_dump($_SESSION["REQUEST"][$table_name."_2"]);
		//unset($_SESSION["REQUEST"]);
		$args = array(
			"p_p"		=>	(isset($_POST['data']['p_p']))? $_POST['data']['p_p'] : null,
			"sort_by"	=>	(isset($_POST['data']['sort_by']))? $_POST['data']['sort_by'] : "ord",
			"current"	=>	(isset($_POST['data']['current']))? $_POST['data']['current'] : null,
			"style"	=>	(isset($_POST['data']['style']))? $_POST['data']['style'] : "list",
		);
			$args = ( isset($_SESSION["REQUEST"][$table_name."_2"]["args"]) )? $_SESSION["REQUEST"][$table_name."_2"]["args"]: $args;
			$conditions = ( isset($_SESSION["REQUEST"][$table_name."_2"]["cond"]) )? $_SESSION["REQUEST"][$table_name."_2"]["cond"]: array("conditions"=>array("id_parent>"=>0));

		?>
		<?= $ob->drawTable($args, $conditions, "") ?>		
	</div>


	<div class="debug"></div>
</div>



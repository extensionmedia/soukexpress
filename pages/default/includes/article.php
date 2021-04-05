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
		<button class="btn btn-default refresh_articles" value="<?= $table_name ?>"><i class="fas fa-sync-alt"></i></button>
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
		<div class="row" style="margin-top: 10px">
			<div class="flex items-center gap-1">
				<select id="this_article_category" data="category" class="max-w-xs py-1">
					<option selected value="-1"> --  Catégorie  -- </option>
						<?php require_once($core."Article_Category.php"); 
							foreach( $article_category->find("", array("order"=>"article_category_ar"), "") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= $v["article_category_ar"] ?> </option>
						<?php } ?>
				</select>
			</div>
		</div>

	</div>
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

<script>
	$(document).ready(function(){
		$("#this_article_category").on('change', function(){

			var id_article_category = $(this).val();
			var data = {
				'method'		:	'options',
				'controler'		:	'Article_Sous_Category',
				'params'		:	{
					'id_article_category'	:	id_article_category
				}
			}
			var that = $(this);
			//$(".content").append('<div class="loading" style="position:fixed; z-index: 9999999; width: 100%; top: 0px;"><div style="margin: 10px auto; width: 250px" class="animated bounce"><div style="background-color:green; color:white" class="info info-success info-dismissible"> <div class="info-message"> Chargement ...! </div> <a href="#" class="close" data-dismiss="info" aria-label="close">&times;</a></div> 	</div></div>');
			
			
			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/Ajax.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				that.nextAll('select').remove();
				if(response.msg !== ''){
					that.parent().append('<select class="this_article_sous_category max-w-xs py-1"><option value="-1">Sous Categorie</option>' + response.msg + '</select');
				}
			}).fail(function(xhr){
				alert("Error");
				console.log(xhr.responseText);
			});
			

		});

		$(document).on('change', ".this_article_sous_category", function(){
			var id_article_sous_category = $(this).val();
			var data = {
				'method'		:	'options',
				'controler'		:	'Article_Sous_Category',
				'params'		:	{
					'id_article_sous_category'	:	id_article_sous_category
				}
			}
			var that = $(this);
			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/Ajax.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				that.nextAll('select').remove();
				if(response.msg !== ''){
					that.parent().append('<select class="this_article_sous_category max-w-xs py-1"><option value="-1">Sous Categorie</option>' + response.msg + '</select');
				}
			}).fail(function(xhr){
				alert("Error");
				console.log(xhr.responseText);
			});

		});


	});
</script>

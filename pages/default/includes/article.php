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
			<input type="text" placeholder="Chercher" class="suf req_input" name="" id="request">
			<div class="input-suf">
				<button title="Chercher" id="a_u_s" class="req_submit">
					<i class="fa fa-search"></i>
				</button>
			</div>
		</div>

	</div>
	<div class="col_9">
		<div class="row" style="margin-top: 10px">
			<div class="flex items-center gap-1 filters">
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

<div class="row articles">
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
			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/Ajax.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				that.nextAll('select').remove();
				if(response.msg !== ''){
					that.parent().append('<select data="article_sous_category" class="this_article_sous_category max-w-xs py-1"><option value="-1">Sous Categorie</option>' + response.msg + '</select');
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
			if(that.val() == "-1"){
				that.nextAll('select').remove();
			}else{
				$.ajax({
					type		: 	"POST",
					url			: 	"pages/default/ajax/Ajax.php",
					data		:	data,
					dataType	: 	"json",
				}).done(function(response){
					that.nextAll('select').remove();
					if(response.msg !== ''){
						that.parent().append('<select data="article_sous_category" class="this_article_sous_category max-w-xs py-1"><option value="-1">Sous Categorie</option>' + response.msg + '</select');
					}
				}).fail(function(xhr){
					alert("Error");
					console.log(xhr.responseText);
				});				
			}


		});

		$(".refresh_articles").on('click', function(){

			var current = $(".current").html();
			var pearPage = $("#showPerPage").val();
			var sort_by = $("#sort_by").html();
			var request = $("#request").val();
			
			var style = $(".style").find(".checked").val();
			
			var data = {
					't_n' : $(this).val(),
					'current'	:	current,
					'p_p'		:	pearPage,
					'sort_by'	:	sort_by,
					'request'	:	request,
					'style'		:	style
				};
			
			var filter = {};
			$(".filters select").each(function(){
					if($(this).val() !== "-1"){
						filter[$(this).attr("data")] = $(this).val();
					}

				}
			);
			
			if(Object.keys(filter).length > 0 ){
				data.filter = filter;
			}			

			$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");

			$.post("pages/default/ajax/article/get.php",{'data':data},function(response){
				$('.articles').html(response);
				$(".modal").removeClass("show");	
			});


		});

		$('.req_submit').on('click', function(){
			$(".refresh_articles").trigger('click');
		});
	});
</script>

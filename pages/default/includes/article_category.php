<?php session_start(); 
	if(!isset($_SESSION["CORE"])) die('Session Expirée, Actualiser la page!');
	$core = $_SESSION["CORE"];
	$selected = [25, 13];
?>

<div class="bg-white rounded-lg border m-2 mt-4 overflow-auto">

	<div class="flex items-center justify-between text-xl font-bold bg-gray-100 p-2 shadow">
		<h1 class="">Article Categories</h1>
		<button class="load_categories text-xs border bg-gray-600 text-white rounded py-2 px-2 font-bold shadow"><i class="fas fa-sync-alt"></i></button>
	</div>
	
	
	<div class="flex gap-4 p-2">
		<div class="overflow-auto w-80 categories"></div>
		<div class="overflow-auto w-80 lavel-1"></div>
		<div class="overflow-auto w-80 lavel-2"></div>
		<div class="overflow-auto w-80 lavel-3"></div>
	</div>
</div>
<script>
	
	$(document).ready(function(){
		
		/************
		Load Categories
		************/
		$('.load_categories').on('click', function(){	

			var data = {
				'controler' 	 		: 	'Article_Category',
				'method'				:	'get'
			};

			$('.categories').html('<div class="p-4 bg-green-100 border border-green-300 text-green-800"><i class="fas fa-sync fa-spin"></i> Loading...</div>');
			$('.lavel-1').html("");
			$('.lavel-2').html("");
			$('.lavel-3').html("");
			$('.lavel-4').html("");
			$('.lavel-5').html("");

			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/Ajax.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				$('.categories').html(response.msg);				
			}).fail(function(xhr){
				alert("Error");
				console.log(xhr.responseText);
			});
		});
		
		$(document).on('click', '.load_sous_category', function(){

			var next_lavel = (parseInt($(this).data('lavel'))+1);

			var params = {
							'id_article_category' 	: 	$(this).data('id'),
							'id_parent'				:	$(this).data('parent_id'),
							'lavel'					:	next_lavel
						};
			var data = {
				'controler' 	 		: 	'Article_Sous_Category',
				'method'				:	'get',
				'params'				:	params
			};
			$('.lavel-'+(next_lavel+1)).html("");
			$('.lavel-'+(next_lavel+2)).html("");
			$('.lavel-'+(next_lavel+3)).html("");
			$('.lavel-'+(next_lavel+4)).html("");

			$(this).parent().find('.load_sous_category').removeClass('bg-yellow-200 border-yellow-400');
			$(this).addClass('bg-yellow-200 border-yellow-400');

			$('.lavel-'+ next_lavel).html('<div class="p-4 bg-green-100 border border-green-300 text-green-800"><i class="fas fa-sync fa-spin"></i> Loading...</div>');
			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/Ajax.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				$('.lavel-'+ next_lavel).html(response.msg);				
			}).fail(function(xhr){
				alert("Error");
				console.log(xhr.responseText);
			});
		});

		$(document).on('click','.this_category', function(){
			$('.this_category').removeClass('bg-yellow-200 border-yellow-400');
			$(this).addClass('bg-yellow-200 border-yellow-400');
			$('.this_subcategory').remove();

			var id_category = $(this).data("id");
			var target = $(this).data("target");
			var data = {
				'controler' 	 		: 	'Article_Sous_Category',
				'method'				:	'get',
				'params'				:	{'id_article_category' : id_category}
			};

			$('.'+target).html('<div class="p-4 bg-green-100 border border-green-300 text-green-800"><i class="fas fa-sync fa-spin"></i> Loading...</div>');

			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/Ajax.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				$('.'+target).html("");
				$('.'+target).append(
					   `<div class="flex items-center justify-between py-2">
							<div></div>
							<div>
								<button class="text-xs border bg-green-600 text-white rounded py-2 px-2 font-bold shadow"><i class="fas fa-plus"></i> Ajouter</button>
							</div>
						</div>`
					);
				
				var obj = JSON.parse(response.msg);
				Object.keys(obj).forEach(function(key) {
					$('.'+target).append(
						`
						<div data-target="level_2" data-id="`+obj[key].id+`" class="this_subcategory relative flex items-center mb-2 border rounded hover:bg-gray-100 cursor-pointer">
							<div class="p-1 m-1 mr-3 border"><img alt="Image" src="`+obj[key].image_url+`" class="h-16 w-16"></div>
							<div class="text-xs">
								<div>`+obj[key].article_sous_category_fr+`</div>
								<div>`+obj[key].article_sous_category_es+`</div>
								<div>`+obj[key].article_sous_category_ar+`</div>
							</div>
							<div class="absolute top-0 right-0 m-1 rounded bg-gray-500 text-gray-100 text-xs px-1">`+obj[key].id+`</div>
							<div class="absolute bottom-0 right-0 m-2">
								<button class="category_edit rounded bg-gray-200 text-gray-600 text-xs py-1 pb-2 px-3">تغيير</button>
							</div>
						</div>
						
						`
					);
				});
				
			}).fail(function(xhr){
				alert("Error");
				console.log(xhr.responseText);
			});
		});

		$(document).on('click', '.this_subcategory', function(){
			var target = $(this).data("target");
			
			$('.'+target).html("");
			$('.this_subcategory').removeClass('bg-yellow-200 border-yellow-400');
			$(this).addClass('bg-yellow-200 border-yellow-400');

			var id_sous_category = $(this).data("id");
			
			var data = {
				'controler' 	 		: 	'Article_Sous_Category',
				'method'				:	'get',
				'params'				:	{'id_parent' : id_sous_category}
			};
			$('.'+target).html('<div class="p-4 bg-green-100 border border-green-300 text-green-800"><i class="fas fa-sync fa-spin"></i> Loading...</div>');
			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/Ajax.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				$('.'+target).html("");
				var obj = JSON.parse(response.msg);
				Object.keys(obj).forEach(function(key) {
					console.log(key, obj[key].UID);
					$('.'+target).append(
						`
						<div data-target="level_3" data-id="`+obj[key].id+`" class="this_subcategory relative flex items-center mb-2 border rounded hover:bg-gray-100 cursor-pointer">
							<div class="p-1 m-1 mr-3 border"><img alt="Image" src="`+obj[key].image_url+`" class="h-16 w-16"></div>
							<div class="text-xs">
								<div>`+obj[key].article_sous_category_fr+`</div>
								<div>`+obj[key].article_sous_category_es+`</div>
								<div>`+obj[key].article_sous_category_ar+`</div>
							</div>
							<div class="absolute top-0 right-0 m-1 rounded bg-gray-500 text-gray-100 text-xs px-1">`+obj[key].id+`</div>
							<div class="absolute bottom-0 right-0 m-2">
								<button class="rounded bg-gray-200 text-gray-600 text-xs py-1 pb-2 px-3">تغيير</button>
							</div>
						</div>
						
						`
					);
				});
				
			}).fail(function(xhr){
				alert("Error");
				console.log(xhr.responseText);
			});
		});
		
		/************
		Add Category
		************/
		$(document).on('click','.category_add', function(){
			$('.this_category').removeClass('bg-yellow-200 border-yellow-400');
			$(this).addClass('bg-yellow-200 border-yellow-400');
			$('.this_subcategory').remove();

			var id_category = $(this).data("id");
			var target = $(this).data("target");
			var data = {
				'controler' 	 		: 	'Article_Category',
				'method'				:	'add'
			};

			$('.'+target).html('<div class="p-4 bg-green-100 border border-green-300 text-green-800"><i class="fas fa-sync fa-spin"></i> Loading...</div>');
			
			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/Ajax.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				if(response.code == 1){
					$('.wrapper').prepend(response.msg);
				}else{
					alert(response.msg);
				}
				
			}).fail(function(xhr){
				alert("Error");
				console.log(xhr.responseText);
			});
		});
	
		/************
		Edit Category
		************/
		$(document).on('click','.category_edit', function(e){
			e.preventDefault();
			$('.this_category').removeClass('bg-yellow-200 border-yellow-400');
			$(this).addClass('bg-yellow-200 border-yellow-400');
			$('.this_subcategory').remove();

			var id_category = $(this).data("id");
			var data = {
				'controler' 	 		: 	'Article_Category',
				'method'				:	'edit',
				'params'				:	{
					'id'	:	$(this).data('id')
				}
			};
			$("html, body").animate({ scrollTop: 0 }, "slow");
			$('.my_modal').prepend("");
			$('.wrapper').prepend(`
									<div class="my_modal w-full h-full bg-gray-800 bg-opacity-25 absolute top-0 z-10">
										<div class="p-4 bg-green-100 border border-green-300 text-green-800 mt-24 mx-auto w-64 text-center">
											<i class="fas fa-sync fa-spin"></i> Loading...
										</div>
									</div>`);
			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/Ajax.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				if(response.code == 1){
					$('.my_modal').html(response.msg);
				}else{
					alert(response.msg);
				}
				
			}).fail(function(xhr){
				alert("Error");
				console.log(xhr.responseText);
			});
		});
		
		$(document).on('click', '.close', function(){
			$("." + $(this).data("target") ).remove();
		});
		
	});
	
	var loader = setInterval(function(){
		if(! $('.load_categories').hasClass('loaded') ){
			$('.load_categories').trigger('click');
			$('.load_categories').addClass('loaded');
			clearInterval(loader);
		}
	}, 500);
	
</script>

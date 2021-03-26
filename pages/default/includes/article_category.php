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
		Categories
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
		
		/************
		Sous Categories
		************/
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

		$(document).on('click','.sous_category_edit', function(e){
			e.preventDefault();

			var categories = [];
			$(".item").each(function(index){
				if($(this).hasClass("bg-yellow-200") ){
					categories.push($(this).data('id'));
				}
			});

			if($(this).parent().parent().parent().hasClass('lavel-1')){
				categories.splice(1, 2);
			}
		
			if($(this).parent().parent().parent().hasClass('lavel-2')){
				categories.splice(2, 1);
			}	

			if($(this).parent().parent().parent().hasClass('lavel-3')){
				categories.splice(3, 1);
			}

			var id_category = $(this).data("id");
			var data = {
				'controler' 	 		: 	'Article_Sous_Category',
				'method'				:	'edit',
				'params'				:	{
					'id'			:	$(this).data('id'),
					'categories'	:	categories
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

		$(document).on('click','.sous_category_add', function(){

			var categories = [];
			$(".item").each(function(index){
				if($(this).hasClass("bg-yellow-200") ){
					categories.push($(this).data('id'));
				}
			});

			if($(this).parent().parent().parent().hasClass('lavel-1')){
				categories.splice(1, 2);
			}
		
			if($(this).parent().parent().parent().hasClass('lavel-2')){
				categories.splice(2, 1);
			}	

			if($(this).parent().parent().parent().hasClass('lavel-3')){
				categories.splice(3, 1);
			}

			var data = {
				'controler' 	 		: 	'Article_Sous_Category',
				'method'				:	'add',
				'params'				:	{'categories':categories}
			};

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

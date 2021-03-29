
<div class="my_modal w-full h-full bg-gray-800 bg-opacity-25 absolute top-0 z-10">
	<button class="close absolute top-0 right-0 m-12 mt-16 text-black text-2xl hover:font-bold hover:text-red-500" data-target="my_modal"> <i class="fas fa-times"></i> </button>
	<div class="mx-auto mt-24 w-11/12 lg:w-3/5 bg-white rounded-lg shadow overflow-hidden">
		<div class="bg-gray-300 py-1 pl-2 text-gray-800">Ajouter Categorie</div>
		<div class="bg-gray-100 py-4 overflow-auto">
			<div class="mx-auto w-72 relative">
				<?php include('includes/picture.php'); ?>
			</div>
		</div>
		
		<div class="flex category_form">
			<div class="bg-white px-4 py-4 flex-1">
				<input id="UID" class="input required" type="hidden" value="<?= $UID ?>">
				<div class="form md:flex items-center mb-2 gap-2">
					<label for="article_category_fr" class="w-36 text-right text-gray-700 text-xs">Category [Fr]</label>
					<input id="article_category_fr" class="input required rounded border py-1 px-2 flex-1" placeholder="Category fr">
				</div>
				<div class="form md:flex items-center mb-2 gap-2">
					<label for="article_category_es" class="w-36 text-right text-gray-700 text-xs">Categorie [Es]</label>
					<input id="article_category_es" class="input required rounded border py-1 px-2 flex-1" placeholder="Categoria es">
				</div>
				<div class="form md:flex items-center mb-2 gap-2">
					<label for="article_category_ar" class="w-36 text-right text-gray-700 text-xs">الصنف</label>
					<input id="article_category_ar" class="input required rounded border py-1 px-2 flex-1" placeholder="الصنف">
				</div>
				<div class="form md:flex items-center mb-4 gap-2">
					<label for="ord" class="w-36 text-right text-gray-700 text-xs">Niveau</label>
					<input id="ord" class="input required rounded border py-1 px-2 text-center w-36" placeholder="0">
				</div>
				<div class="form md:flex items-center mb-6 gap-2">
					<div class="w-36 text-right text-gray-700 text-xs"></div>
					<label class="flex items-center gap-2"> 
						<input id="status" type="checkbox" class="input" checked>
						<span class="text-xs font-bold">Status</span>
					</label>
				</div>
				<div class="form md:flex items-center mb-6 gap-2">
					<div class="w-36 text-right text-gray-700 text-xs"></div>
					<label class="flex items-center gap-2"> 
						<input id="is_visible_on_web" type="checkbox" class="input">
						<span class="text-xs font-bold">Publier sur le Web</span>
					</label>
				</div>
			</div>	
			
			<?php if(isset($categories)): ?>
			<div class="bg-white px-4 py-4 w-96">
				<select class="input required bg-gray-300 py-1 border border-gray-200 rounded mb-2">
				<?php foreach($categories as $k=>$v): ?>
					<option class="bg-gray-100 font-bold text-xs" value="<?= $v["id"] ?>"><?= $v["article_category_fr"]."\n".$v["article_category_ar"] ?></option>
				<?php endforeach ?>	
				</select>
				
				<select class="input required bg-gray-300 py-1 border border-gray-200 rounded">
				<?php foreach($categories as $k=>$v): ?>
					<option class="bg-gray-100 font-bold text-xs" value="<?= $v["id"] ?>"><?= $v["article_category_fr"] ?></option>
				<?php endforeach ?>	
				</select>
				
			</div>
			<?php endif ?>					
		</div>
		
		<hr class="mb-6">
		
		<div class="flex items-center p-4 gap-2">
			<button class="create rounded border py-2 px-3 bg-blue-500 text-white text-xs font-bold" data-form="category_form" data-controller="Article_Category">
				<i class="far fa-save"></i> Enregistrer
			</button>
			<button class="close rounded border py-2 px-3 bg-gray-500 text-white text-xs font-bold" data-target="my_modal">
				Annuler
			</button>
		</div>


	</div>
	<script>

		$(document).ready(function(){

			$('.create').on('click', function(e){
				var form = $(this).data('form');
				var controller = $(this).data('controller');
				var form_inputs = {};
				var go = true;
				$('.'+form+' .input').each(function(){
					if($(this).hasClass('required') && $(this).val() === ''){
						$(this).addClass('bg-red-100').addClass('border-red-700');
						go = false;
					}else{
						$(this).removeClass('border-red-700').removeClass('bg-red-100');
						if($(this).is(":checkbox")) {
							form_inputs[$(this).attr('id')] = $(this).prop('checked')?1:0;	
						}else{
							form_inputs[$(this).attr('id')] = $(this).val();		 
						}
					}
				});
				if(go){
					var data = {
						'controler' 	 		: 	controller,
						'method'				:	'create',
						'params'				:	form_inputs
					};
					$.ajax({
						type		: 	"POST",
						url			: 	"pages/default/ajax/Ajax.php",
						data		:	data,
						dataType	: 	"json",
					}).done(function(response){
						if(response.code == 1){
							$('.close').trigger('click');
							$('.load_categories').trigger('click');
						}
					}).fail(function(xhr){
						alert("Error");
						console.log(xhr.responseText);
					});				
				}
			});		
		});

	</script>
</div>
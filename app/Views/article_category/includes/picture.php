<img class="mx-auto h-36 w-auto" src="<?= $obj->avatar( ['UID'=>$UID] ) ?>">
<button data-file="upload_file_category" class="upload hover:bg-gray-400 hover:text-white absolute top-0 right-0 m-4 border border-gray-300 rounded py-1 px-2">
	<i class="fas fa-cloud-upload-alt"></i>
</button>
<button class="remove_file_category hover:bg-red-400 hover:text-white absolute top-0 left-0 m-4 border border-gray-300 rounded py-1 px-2 text-red-500" data-uid="<?= $UID ?>">
	<i class="far fa-trash-alt"></i>
</button>
<input class="hidden" type="file" id="upload_file_category" data-uid="<?= $UID ?>" data-folder="category">
<button class="reload_file_category hide hover:bg-red-400 hover:text-white absolute bottom-0 left-0 m-4 border border-gray-300 rounded py-1 px-2 text-red-500" data-uid="<?= $UID ?>">
	reload
</button>

<script>
	$(document).ready(function(){
		
		$('.reload_file_category').on('click', function(){
			var UID = $(this).data('uid');
			var data = {
				'controler' 	 		: 	'Article_Category',
				'method'				:	'avatar',
				'params'				:	{'UID' : UID}
			};

			var that = $(this);
			that.parent().append(`<?php include('loader.php'); ?>`);
			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/Ajax.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				that.parent().find('img').attr("src",response.msg);
				$('.loading').remove();
			}).fail(function(xhr){
				alert("Error");
				console.log(xhr.responseText);
			});
		});
		
		$('.remove_file_category').on('click', function(){
			if( !confirm('Vous êtes sur de supprimer cette photo?') ){
				return false;
			}
			
			var UID = $(this).data('uid');
			var data = {
				'controler' 	 		: 	'Article_Category',
				'method'				:	'remove_avatar',
				'params'				:	{'UID' : UID}
			};

			var that = $(this);
			that.parent().append(`<?php include('loader.php'); ?>`);
			
			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/Ajax.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				$('.loading').remove();
				$('.reload_file_category').trigger('click');
			}).fail(function(xhr){
				alert("Error");
				console.log(xhr.responseText);
			});
		});
		
		/************
		Upload
		************/	
		$(document).on('click', '.upload', function(){
			var target_file = $(this).data('file');
			$('#'+target_file).trigger('click');
		});
		
		$(document).on('change', '#upload_file_category', function(){
			var uid =  $(this).data("uid");
			var folder =  $(this).data("folder");

			var params = {
				IdIputFile			:	"upload_file_category",
				PHPUploader			:	"pages/default/ajax/upload_files.php",
				PHPUploaderParams	:	"?path="+folder+"/"+uid,
				Reloader			:	'reload_file_category'

			};
			if($(this).val() !== ""){ 
				console.log(uploader(params)); 
				$('#upload_file_category').val('');
			}
		})
	});
</script>

$(document).ready(function() {
	
	"use strict";

	/************************************************************************
		LIBRARY
	**************************************************************************/

	$(document).on('change','#upload_file_category___',function(){
		var id_client =  $(this).attr("data");
		
		var params = {
			IdIputFile			:	"upload_file_category",
			PHPUploader			:	"pages/default/ajax/upload_files.php",
			PHPUploaderParams	:	"?id=category/"+id_client
			
		};
		
		
		if($(this).val() !== ""){
			uploader(params);
		}
		
	});
	
	$(document).on('change','#upload_file_sous_category',function(){
		var id_client =  $(this).attr("data");
		
		var params = {
			IdIputFile			:	"upload_file_sous_category",
			PHPUploader			:	"pages/default/ajax/upload_files.php",
			PHPUploaderParams	:	"?id=sous_category/"+id_client
			
		};
		
		
		if($(this).val() !== ""){
			uploader(params);
		}
		
	});
	
	
	$(document).on('change','#upload_file_marque',function(){
		var id_client =  $(this).attr("data");
		
		var params = {
			IdIputFile			:	"upload_file_marque",
			PHPUploader			:	"pages/default/ajax/upload_files.php",
			PHPUploaderParams	:	"?id=marque/"+id_client
			
		};
		
		
		if($(this).val() !== ""){
			uploader(params);
		}
		
	});
	
	$(document).on("click", ".delete_file", function(){

		var data = {link:$(this).val()};
		
		swal({
			  title: "Vous êtes sûr?",
			  text: "Êtes vous sûr de vouloir supprimer ce Fichier? ",
				type:"warning",
				showCancelButton:!0,
				confirmButtonColor:"#3085d6",
				cancelButtonColor:"#d33",
				confirmButtonText:"Oui, Supprimer!"
			}).then(function(t){
			  if (t.value) {

					$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
				  
					$.ajax({

						type		: 	"POST",
						url			: 	"pages/default/ajax/delete_file.php",
						data		:	data,
						success 	: 	function(){
											//alert(response);
											$(".modal").removeClass("show");
											$(".show_files").trigger('click');
										},
						error		:	function(){
											$(".modal").removeClass("show");
											$(".show_files").trigger('click');

						}
					});	


			  } else {

			  }
		});	
		
		

	});

	
	$(document).on('click',".rotate", function(){
		var data = {link:$(this).val()};
		
		if($(this).hasClass("category")){
			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/article_category/rotate_image.php",
				data		:	data,
				success 	: 	function(response){
									$(".debug").html(response);
									$(".show_files").trigger('click');
								},
				error		:	function(response){
									console.log(response);

				}
			});				
		}else if($(this).hasClass("sous_category")){
			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/article_sous_category/rotate_image.php",
				data		:	data,
				success 	: 	function(response){
									$(".debug").html(response);
									$(".show_files").trigger('click');
								},
				error		:	function(response){
									console.log(response);

				}
			});				
		}else if($(this).hasClass("article")){
			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/article/rotate_image.php",
				data		:	data,
				success 	: 	function(response){
									$(".debug").html(response);
									$(".show_files").trigger('click');
								},
				error		:	function(response){
									console.log(response);

				}
			});				
		}
		


	});
	
	$(document).on("click", ".show_files", function(e){
		var data;
		
		if($(this).hasClass("category")){
			
			if( $(e.target).is("a") ){
				data = {
					id_produit	:	$(this).attr("data")
				};
			}else{
				data = {
					id_produit	:	$(this).val()
				};				
			}

			
			$(".show_files_result").prepend("<div style='padding:10px; color:black;position:absolute; top:0; width:70px; background-color:yellow; opacity:0.5; text-align:center'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.ajax({

				type		: 	"POST",
				url			: 	"pages/default/ajax/article_category/get_files.php",
				data		:	data,
				success 	: 	function(response){
									$("._loader").remove();
									$('.show_files_result').html(response);
									
								},
				error		:	function(response){
									$('.content').html(response);
									$(".modal").removeClass("show");

				}
			});
			
		}else if($(this).hasClass("marque")){
			
			if( $(e.target).is("a") ){
				data = {
					id_produit	:	$(this).attr("data")
				};
			}else{
				data = {
					id_produit	:	$(this).val()
				};				
			}

			
			$(".show_files_result").prepend("<div style='padding:10px; color:black;position:absolute; top:0; width:70px; background-color:yellow; opacity:0.5; text-align:center'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.ajax({

				type		: 	"POST",
				url			: 	"pages/default/ajax/article_marque/get_files.php",
				data		:	data,
				success 	: 	function(response){
									$("._loader").remove();
									$('.show_files_result').html(response);
									
								},
				error		:	function(response){
									$('.content').html(response);
									$(".modal").removeClass("show");

				}
			});
			
		}else if($(this).hasClass("article")){
			
			if( $(e.target).is("a") ){
				data = {
					id_produit	:	$(this).attr("data")
				};
			}else{
				data = {
					id_produit	:	$(this).val()
				};				
			}

			
			$(".show_files_result").prepend("<div style='padding:10px; color:black;position:absolute; top:0; width:70px; background-color:yellow; opacity:0.5; text-align:center'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.ajax({

				type		: 	"POST",
				url			: 	"pages/default/ajax/article/get_files.php",
				data		:	data,
				success 	: 	function(response){
									$("._loader").remove();
									$('.show_files_result').html(response);
									
								},
				error		:	function(response){
									$('.content').html(response);
									$(".modal").removeClass("show");

				}
			});
			
		}else if($(this).hasClass("sous_category")){
			
			if( $(e.target).is("a") ){
				data = {
					id_produit	:	$(this).attr("data")
				};
			}else{
				data = {
					id_produit	:	$(this).val()
				};				
			}

			
			$(".show_files_result").prepend("<div style='padding:10px; color:black;position:absolute; top:0; width:70px; background-color:yellow; opacity:0.5; text-align:center'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.ajax({

				type		: 	"POST",
				url			: 	"pages/default/ajax/article_sous_category/get_files.php",
				data		:	data,
				success 	: 	function(response){
									$("._loader").remove();
									$('.show_files_result').html(response);
									
								},
				error		:	function(response){
									$('.content').html(response);
									$(".modal").removeClass("show");

				}
			});
			
		}else if($(this).hasClass("person")){
			data = {
				id_produit	:	$(this).val()
			};
			$(".person_image").prepend("<div class='_loader' style='padding:10px; color:black;position:absolute; top:0; width:70px; background-color:yellow; opacity:0.5; text-align:center'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.ajax({

				type		: 	"POST",
				url			: 	"pages/default/ajax/person/get_picture.php",
				data		:	data,
				success 	: 	function(response){
									$("._loader").remove();
									$('.person_image .image').html(response);
								},
				error		:	function(response){
									$("._loader").remove();
									console.log(response);
									//$(".modal").removeClass("show");

				}
			});
		}else if($(this).hasClass("magasin")){
			
			if( $(e.target).is("a") ){
				data = {
					id_produit	:	$(this).attr("data")
				};
			}else{
				data = {
					id_produit	:	$(this).val()
				};				
			}

			
			$(".show_files_result").prepend("<div style='padding:10px; color:black;position:absolute; top:0; width:70px; background-color:yellow; opacity:0.5; text-align:center'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.ajax({

				type		: 	"POST",
				url			: 	"pages/default/ajax/magasin/get_files.php",
				data		:	data,
				success 	: 	function(response){
									$("._loader").remove();
									$('.show_files_result').html(response);
									
								},
				error		:	function(response){
									$('.content').html(response);
									$(".modal").removeClass("show");

				}
			});
		}


	});
	
	$(document).on('click', '.watermark', function(){
		
		if($(this).hasClass("article")){
			
			var UID = $(this).val();
			var data = {
				'folder'	:	'article',
				'UID'		:	UID
			};
			
			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/article/watermark.php",
				data		:	data,
				success 	: 	function(response){
									$(".debug").html(response);
									$(".show_files").trigger('click');
								},
				error		:	function(response){
									console.log(response);

				}
			});
			
		}
		
		if($(this).hasClass("category")){
			var link = $(this).val();
			$.post("pages/default/ajax/article_category/watermark.php",{'link':link,'new_name':'watermark'}, function(){
				$(".show_files").trigger('click');
			});	
		}
	});

	/****************************
		ARTICLE SECTION
	*****************************/	

	$(document).on('click', '.select_tarif_vente', function(){

		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		var data = {
			'module'	: 'vente',
			'UID'		:	$(this).val(),
			'id'	:	$(this).attr("data-id")
		};

		//$.post("pages/default/ajax/depense/util.php", {'module':'propriete'}, function(r){$(".debug_client").html(r);});

		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/article/util.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			if (response.code === 1){
				$(".modal").html("<div class='modal-content' style='width:420px; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");

			}else{
				$(".modal").html("<div class='modal-content' style='width:420px; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");
			}

		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});	
		
		
	});
	
	$(document).on('click', '.tarif_vente.save', function(){
		
		var _status = $("#tarif_vente_status").hasClass("on")? 1 : 0;
		var is_default = $("#tarif_vente_is_default").hasClass("on")? 1 : 0;
		
		var UID="";
		
		if($(this).hasClass("edit")){
			UID = $(this).attr("data-uid");
		}else{
			UID = $(this).val();
		}
		
		var columns = {
			'id_article_tarif*'			:	$("#id_article_tarif").val(),
			'montant*'					:	$("#montant").val(),
			'UID'						:	UID,
			'status'					:	_status,
			'is_default'				:	is_default,
			'id_article'				:	$(this).attr("data-id")
		};
		
		if($(this).hasClass("edit")){
			columns.id = $(this).val();
		}
		
		var _true = true	;

		for (var key in columns) {
			if (columns.hasOwnProperty(key)) {
				
				if( columns[key] === "" || columns[key] === "0"){
					if(key.includes("*")){
						$("#" + key).addClass('error');
						_true = false;
						console.log("error!");		
					}
				}else{
					$("#" + key).removeClass('error');

				}			
			}
		}
		
		if(_true){
			//data['columns']['date_naissance*'] = 
			var data = {

						't_n'				:	'Article_Tarif_Vente',
						'columns'			:	columns
			};
			//$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.post("pages/default/ajax/article_tarif_vente/save.php",data,function(response){

				if(response === "1"){
					$('.refresh_tarif_vente').trigger("click");
				}else{
					$(".debug").html(response);
				}
				

			});	
		}
	});
	
	$(document).on('click', '.refresh_tarif_vente', function(e){
		
		e.preventDefault();
		
		var data = {
			'UID'	:	$(this).val(),
			't_n'	:	"Article_Tarif_Vente",
			'id'	:	$(this).attr("data-id")
		};
		
		if($(this).hasClass("btn")){
			data.UID = $(this).val();
			
		}else{
			data.UID = $(this).attr("data");
		}
		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		$(".vente_tarif").html("");

		$.post("pages/default/ajax/article_tarif_vente/get.php",{'data':data},function(response){
			$(".vente_tarif").html(response);
			$(".modal").removeClass("show");
			
		});
		
	});
	
	$(document).on('click', '.edit_tarif_vente', function(){

		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		var data = {
			'module'	: 'vente_edit',
		};

		if($(this).hasClass("btn")){
			data.id = $(this).val();
		}else{
			data.id = $(this).find(".id-ligne").html();
		}
		
		
		//$.post("pages/default/ajax/depense/util.php", {'module':'propriete'}, function(r){$(".debug_client").html(r);});

		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/article/util.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			if (response.code === 1){
				$(".modal").html("<div class='modal-content' style='width:420px; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");

			}else{
				$(".modal").html("<div class='modal-content' style='width:420px; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");
			}

		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});	

	});	
	
	$(document).on('change', '#mois', function(e){
		e.preventDefault();
		var month 	= $(this).val();
		var year	=	$(this).attr("data-year");
		
		var data = {
			'controler' 	 		: 	'Article',
			'method'				:	'Get_Days_Of_Month',
			'params'				:	{'month' : month, 'year' : year}
		};

		
		$(".content").append('<div class="loading" style="position:fixed; z-index: 9999999; width: 100%; top: 0px;"><div style="margin: 10px auto; width: 250px" class="animated bounce"><div style="background-color:green; color:white" class="info info-success info-dismissible"> <div class="info-message"> Chargement ...! </div> <a href="#" class="close" data-dismiss="info" aria-label="close">&times;</a></div> 	</div></div>');

		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/Ajax.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			var days = parseInt( response.msg );
			$("#days").empty().append('<option selected value="-1">Tous les jours --</option>');
			for(var i=1; i<=days; i++){
				$("#days").append('<option value="'+i+'">'+i+'</option>');
			}
			
			$(".content .loading").remove();
		}).fail(function(xhr){
			alert("Error");
			console.log(xhr.responseText);
		});
		
		
	});
	
	
	

	/****** ACHAT	****/

	$(document).on('click', '.select_tarif_achat', function(){

		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		var data = {
			'module'	: 'achat',
			'UID'		:	$(this).val(),
			'id'	:	$(this).attr("data-id")
		};

		//$.post("pages/default/ajax/depense/util.php", {'module':'propriete'}, function(r){$(".debug_client").html(r);});

		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/article/util.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			if (response.code === 1){
				$(".modal").html("<div class='modal-content' style='width:420px; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");

			}else{
				$(".modal").html("<div class='modal-content' style='width:420px; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");
			}

		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});	
		
		
	});
	
	$(document).on('click', '.tarif_achat.save', function(){
		
		var _status = $("#tarif_achat_status").hasClass("on")? 1 : 0;
		var is_default = $("#tarif_achat_is_default").hasClass("on")? 1 : 0;
		
		var UID="";
		
		if($(this).hasClass("edit")){
			UID = $(this).attr("data-uid");
		}else{
			UID = $(this).val();
		}
		
		var columns = {
			'id_fournisseur*'			:	$("#id_fournisseur").val(),
			'montant*'					:	$("#montant").val(),
			'UID'						:	UID,
			'status'					:	_status,
			'is_default'				:	is_default,
			'id_article'				:	$(this).attr("data-id")
		};
		
		if($(this).hasClass("edit")){
			columns.id = $(this).val();
		}
		
		var _true = true	;

		for (var key in columns) {
			if (columns.hasOwnProperty(key)) {
				
				if( columns[key] === "" || columns[key] === "0"){
					if(key.includes("*")){
						$("#" + key).addClass('error');
						_true = false;
						console.log("error!");		
					}
				}else{
					$("#" + key).removeClass('error');

				}			
			}
		}
		
		if(_true){
			//data['columns']['date_naissance*'] = 
			var data = {

						't_n'				:	'Article_Tarif_Achat',
						'columns'			:	columns
			};
			//$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.post("pages/default/ajax/article_tarif_achat/save.php",data,function(response){

				if(response === "1"){
					$('.refresh_tarif_achat').trigger("click");
				}else{
					$(".debug").html(response);
				}
				

			});	
		}
	});
	
	$(document).on('click', '.refresh_tarif_achat', function(e){
		
		e.preventDefault();
		
		var data = {
			'UID'	:	$(this).val(),
			't_n'	:	"Article_Tarif_Achat",
			'id'	:	$(this).attr("data-id")
		};
		
		if($(this).hasClass("btn")){
			data.UID = $(this).val();
			
		}else{
			data.UID = $(this).attr("data");
		}
		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		$(".vente_achat").html("");

		$.post("pages/default/ajax/article_tarif_achat/get.php",{'data':data},function(response){
			$(".achat_tarif").html(response);
			$(".modal").removeClass("show");
			
		});
		
	});
	
	$(document).on('click', '.edit_tarif_achat', function(){

		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		var data = {
			'module'	: 'achat_edit',
		};

		if($(this).hasClass("btn")){
			data.id = $(this).val();
		}else{
			data.id = $(this).find(".id-ligne").html();
		}
		
		
		//$.post("pages/default/ajax/depense/util.php", {'module':'propriete'}, function(r){$(".debug_client").html(r);});

		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/article/util.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			if (response.code === 1){
				$(".modal").html("<div class='modal-content' style='width:420px; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");

			}else{
				$(".modal").html("<div class='modal-content' style='width:420px; padding:0; border:0; border-radius:3px'>" + response.msg + "</div>");
			}

		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});	

	});
	
	$(document).on('click', '.is_visible_on_web', function(){
		
		var id = $(this).attr("data-article-id");
		var status = 1;
		
		if($(this).hasClass("off")){ status = 0; }
		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		var data = {
			'module'		: 'is_visible',
			'id_article'	: id,
			'web_status'	: status
		};		
		
		//$.post("pages/default/ajax/depense/util.php", {'module':'propriete'}, function(r){$(".debug_client").html(r);});

		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/article/util.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			if (response.code === 1){
				$(".modal").removeClass("show");

			}else{
				$(".modal").removeClass("show");
			}

		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});	
		
		
		
	});

	
	/****************************
		ARTICLE CATEGORIE
	*****************************/	
	
	$(document).on('click', '.is_visible_on_web_article_category', function(){
		
		var id = $(this).attr("data-article-id");
		var status = 1;
		
		if($(this).hasClass("off")){ status = 0; }
		
		$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
		var data = {
			'module'		: 'is_visible',
			'id_article'	: id,
			'web_status'	: status
		};		
		
		//$.post("pages/default/ajax/depense/util.php", {'module':'propriete'}, function(r){$(".debug_client").html(r);});

		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/article_category/util.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			if (response.code === 1){
				$(".modal").removeClass("show");

			}else{
				$(".modal").removeClass("show");
			}

		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
		});	
		
		
		
	});
	
	/*****************************************************************************************************
		PERSON SECTION
	******************************************************************************************************/
	
	$(document).on('click', '.person_password_reset', function(){
		
		if($("#person_password").val() === "" || $("#person_login").val() === ""){
			alert("Valeurs Incorrect!");
		}else{
			$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			var id_person = $(this).val();
			var data = {
				'module' 	 : 'person',
				'options'	 : {'id_person': id_person, 'person_password':$("#person_password").val(), 'person_login':$("#person_login").val()}
			};
			/*
			$.post("pages/default/ajax/person/util.php",{'module':'person','options':{'id_person': id_person, 'person_password':$("#person_password").val()}}, function(r){
				//$(".debug_client").html(r);
				alert(r);
			});
			*/


			$.ajax({
				type		: 	"POST",
				url			: 	"pages/default/ajax/person/util.php",
				data		:	data,
				dataType	: 	"json",
			}).done(function(response){
				
				if (response.code === 1){
					alert(response.msg);
					$(".debug_client").html("");
					$(".modal").html("").removeClass('show');

				}else{
					$(".debug_client").html('	<div class="info info-error info-dismissible"> <div class="info-message"> '+response+' </div> <a href="#" class="close" data-dismiss="info" aria-label="close">&times;</a></div>');
				}

			}).fail(function(response, textStatus){
				$(".debug_client").html(textStatus);
				$(".modal").html("").removeClass('show');
			});

		}
		
		
		
	});
	
	$(document).on('click','.actions.person .save',function(){
		var _status = $("#person_status").hasClass("on")? 1 : 0;
		var columns = {
			'person_first_name*'	:	$("#person_first_name").val(),
			'UID*'					:	$("#UID").val(),
			'person_last_name*'		:	$("#person_last_name").val(),
			'person_profile*'		:	$("#person_profile").val(),
			'person_telephone'		:	$("#person_telephone").val(),
			'person_email'			:	$("#person_email").val(),
			'person_login*'			:	$("#person_login").val(),
			'person_password*'		:	$("#person_password").val(),
			'status'				:	_status

		};
		
		if($("#id").length>0){
			columns.id = $("#id").val();
			delete columns["person_password*"];
		}

		var _true = true;

		for (var key in columns) {
			if (columns.hasOwnProperty(key)) {

				if( columns[key] === "" || columns[key] === "-1"){
					if(key.includes("*")){
						$("#" + key).addClass('error');
						_true = false;

					}
				}else{
					$("#" + key).removeClass('error');

				}			
			}
		}
		if(_true){
			//data['columns']['date_naissance*'] = 
			var data = {

						't_n'				:	'Person',
						'columns'			:	columns
			};
			$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.post("pages/default/ajax/person/save.php",{'data':data},function(response){

				$(".modal").removeClass("show");
				if(response === "1"){

					swal("SUCCESS!", "Le produit a été ajouté!", "success");
					var data = {
						"page"	:	"menu",
						"p"		:	{
							"s"		:	0,
							"pp"	:	50
						}
					};

					$.ajax({
						
						type		: 	"POST",
						url			: 	"pages/default/includes/person.php",
						data		:	data,
						success 	: 	function(response){
											$('.content').html(response);
											$(".modal").removeClass("show");
										},
						error		:	function(response){
											$('.content').html(response);
											$(".modal").removeClass("show");

						}
					});



				}else{
					$(".debug_client").html("Impossible d\'enregistrer le client : " + response);
				}


			});	
		}
	});	
	
	$(document).on('click',".apercu_creative",function(){
		$(".screen_apercu").html($("#body").val());
		
	});


	/*****************************************************************************************************
		PERSON PROFILE SECTION
	******************************************************************************************************/

	$(document).on('click','.actions.person_profile .save',function(){
		var _status = $("#person_profile_status").hasClass("on")? 1 : 0;
		var columns = {
			'person_profile*'	:	$("#person_profile").val(),
			'is_default'			:	_status

		};

		if($("#id").length>0){
			columns.id = $("#id").val();
		}
		
		var _true = true	;

		for (var key in columns) {
			if (columns.hasOwnProperty(key)) {

				if( columns[key] === ""){
					if(key.includes("*")){
						$("#" + key).addClass('error');
						_true = false;

					}
				}else{
					$("#" + key).removeClass('error');

				}			
			}
		}
		if(_true){
			//data['columns']['date_naissance*'] = 
			var data = {

						't_n'				:	'Person_Profile',
						'columns'			:	columns
			};
			$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.post("pages/default/ajax/person_profile/save.php",{'data':data},function(response){

				$(".modal").removeClass("show");
				if(response === "1"){

					swal("SUCCESS!", "Le produit a été ajouté!", "success");
					var data = {
						"page"	:	"menu",
						"p"		:	{
							"s"		:	0,
							"pp"	:	50
						}
					};

					$.ajax({

						type		: 	"POST",
						url			: 	"pages/default/includes/person_profile.php",
						data		:	data,
						success 	: 	function(response){
											$('.content').html(response);
											$(".modal").removeClass("show");
										},
						error		:	function(response){
											$('.content').html(response);
											$(".modal").removeClass("show");

						}
					});



				}else{
					$(".debug_client").html("Impossible d\'enregistrer le client : " + response);
				}


			});	
		}
	});		
	
	$(document).on('change','#upload_file_person',function(){
		var id_client =  $(this).attr("data");
		
		var params = {
			IdIputFile			:	"upload_file_person",
			PHPUploader			:	"pages/default/ajax/upload_files.php",
			PHPUploaderParams	:	"?id=person/"+id_client
			
		};
		
		
		if($(this).val() !== ""){
			uploader(params);
		}
		
	});
	

	
	/***********************************************************************
		MENU SECTION
	************************************************************************/
	
	$(document).on('click', '.__menu .btn.order, .__sub .btn.order', function(){
		var data = {
			action 	: 	'',
			i		:	$(this).attr("data-id"),
			next	:	$(this).attr("data-id-n"),
			preview	:	$(this).attr("data-id-p"),
			order	:	$(this).attr("data-order")
		};
		
		if($(this).hasClass("up")){
			data.action = "UP";
		}else{
			data.action = "DOWN";
		}
		

		$.ajax({

			type		: 	"POST",
			url			: 	"pages/default/ajax/menu/util.php",
			data		:	data,
			success 	: 	function(response){
								//$('.debug_client').html(response);
								location.reload();
							},
			error		:	function(response){
								$('.debug_client').html(response);

			}
		});
		
	});
	
	$(document).on('change','#menu_icon',function(){
		$(".icon_display").html($(this).val());
	});

	$(document).on('click','.actions.menu .save',function(){

		var menu_status = $("#menu_status").hasClass("on")? 1 : 0;

		var columns = {
			'menu_libelle*'			:	$("#menu_libelle").val(),
			'menu_parent'			:	$("#menu_parent").val(),
			'menu_icon'				:	$("#menu_icon").val(),
			'menu_order*'			:	$("#menu_order").val(),
			'menu_url*'				:	$("#menu_url").val(),
			'menu_status*'			:	menu_status,

		};

		var _true = true	;

		for (var key in columns) {
			if (columns.hasOwnProperty(key)) {

				if( columns[key] === "" || columns[key] === "-1" ){
					if(key.includes("*")){
						$("#" + key).addClass('error');
						_true = false;

					}
				}else{
					$("#" + key).removeClass('error');

				}			
			}
		}
		if(_true){
			//data['columns']['date_naissance*'] = 
			var data = {

						't_n'				:	'Menu',
						'columns'			:	columns
			};
			$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.post("pages/default/ajax/menu/save.php",{'data':data},function(response){

				$(".modal").removeClass("show");
				if(response === "1"){

					swal("SUCCESS!", "Le produit a été ajouté!", "success");
					var data = {
						"page"	:	"menu",
						"p"		:	{
							"s"		:	0,
							"pp"	:	50
						}
					};

					$.ajax({

						type		: 	"POST",
						url			: 	"pages/default/includes/menu.php",
						data		:	data,
						success 	: 	function(response){
											$('.content').html(response);
											$(".modal").removeClass("show");
										},
						error		:	function(response){
											$('.content').html(response);
											$(".modal").removeClass("show");

						}
					});



				}else{
					$(".debug_client").html("Impossible d\'enregistrer le client : " + response);
				}


			});	
		}
	});
	
	$(document).on('click','.actions.menu .save_edit',function(){

		var menu_status = $("#menu_status").hasClass("on")? 1 : 0;

		var columns = {
			'menu_libelle*'			:	$("#menu_libelle").val(),
			'menu_parent'			:	$("#menu_parent").val(),
			'menu_icon'				:	$("#menu_icon").val(),
			'menu_order*'			:	$("#menu_order").val(),
			'menu_url*'				:	$("#menu_url").val(),
			'id*'					:	$("#id").val(),
			'menu_status*'			:	menu_status,

		};

		var _true = true	;

		for (var key in columns) {
			if (columns.hasOwnProperty(key)) {

				if( columns[key] === "" || columns[key] === "-1" ){
					if(key.includes("*")){
						$("#" + key).addClass('error');
						_true = false;

					}
				}else{
					$("#" + key).removeClass('error');

				}			
			}
		}
		if(_true){
			//data['columns']['date_naissance*'] = 
			var data = {

						't_n'				:	'Menu',
						'columns'			:	columns
			};
			$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.post("pages/default/ajax/menu/save.php",{'data':data},function(response){

				$(".modal").removeClass("show");
				if(response === "1"){

					swal("SUCCESS!", "Le produit a été ajouté!", "success");
					var data = {
						"page"	:	"menu",
						"p"		:	{
							"s"		:	0,
							"pp"	:	50
						}
					};

					$.ajax({

						type		: 	"POST",
						url			: 	"pages/default/includes/menu.php",
						data		:	data,
						success 	: 	function(response){
											$('.content').html(response);
											$(".modal").removeClass("show");
										},
						error		:	function(response){
											$('.content').html(response);
											$(".modal").removeClass("show");

						}
					});



				}else{
					$(".debug_client").html("Impossible d\'enregistrer le client : " + response);
				}


			});	
		}
	});
	

	/************************************************************************
		APROPOS SECTION
	*************************************************************************/

	$(document).on('click','.actions.apropos .save',function(){
						
			var columns = {
				'body*'		:	$("#editorTextArea").val(),
				'id'		:	1
			};

			var _true = true	;

			for (var key in columns) {
				if (columns.hasOwnProperty(key)) {

					if( columns[key] === "" || columns[key] === "-1" ){
						if(key.includes("*")){
							$("#" + key).addClass('error');
							_true = false;

						}
					}else{
						$("#" + key).removeClass('error');
														
					}			
				}
			}
			
			if(_true){
				//data['columns']['date_naissance*'] = 
				var data = {

							't_n'				:	'Apropos',
							'columns'			:	columns
				};
				$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
				$.post("pages/default/ajax/apropos/save.php",{'data':data},function(response){

					$(".modal").removeClass("show");
					if(response === "1"){
						
						swal("SUCCESS!", "La catégorie a été ajouté!", "success");
						var data = {
							"page"	:	"apropos",
							"p"		:	{
								"s"		:	0,
								"pp"	:	50
							}
						};

						$.ajax({

							type		: 	"POST",
							url			: 	"pages/default/includes/apropos.php",
							data		:	data,
							success 	: 	function(response){
												$('.content').html(response);
												$(".modal").removeClass("show");
											},
							error		:	function(response){
												$('.content').html(response);
												$(".modal").removeClass("show");

							}
						});
						
						
						
					}else{
						$(".debug_client").html("Impossible d\'enregistrer le client : " + response);
					}
								
					
				});	
			}
		});

	/*****************************************************************************************************
		PARAMS SECTION
	******************************************************************************************************/

	$(document).on('click','.actions.params .save',function(){
		
		var lang = "";
		
		$(".lang").each(function(){
			if( $(this).hasClass("checked") ){
				lang = $(this).val();
			}
		});

		var columns = {
			'website_name*'				:	$("#website_name").val(),
			'website_language*'			:	lang,
			'website_support'			:	$("#website_support").val(),
			'website_phone'				:	$("#website_phone").val(),
			'website_description'		:	$("#website_description").val(),
			'website_keywords'			:	$("#website_keywords").val(),
			'website_google_analytics'	:	$("#website_google_analytics").val(),
			'website_facebook_pixel'	:	$("#website_facebook_pixel").val(),
			'smtp_username'				:	$("#smtp_username ").val(),
			'smtp_password'				:	$("#smtp_password ").val(),
			'smtp_host'					:	$("#smtp_host").val(),
			'imap'						:	$("#imap").val(),
			'port'						:	$("#port").val(),
			'api_whatsapp'				:	$("#api_whatsapp").val(),
			'id'		:	1
		};

		var _true = true	;

		for (var key in columns) {
			if (columns.hasOwnProperty(key)) {

				if( columns[key] === "" || columns[key] === "-1" ){
					if(key.includes("*")){
						$("#" + key).addClass('error');
						_true = false;

					}
				}else{
					$("#" + key).removeClass('error');

				}			
			}
		}

		if(_true){
			//data['columns']['date_naissance*'] = 
			var data = {

						't_n'				:	'Params',
						'columns'			:	columns
			};
			$(".modal").addClass("show").html("<div class='modal-content' style='width:75px; opacity:0.9'><i style='font-size:30px;' class='fas fa-cog fa-spin'></i></div>");
			$.post("pages/default/ajax/params/save.php",{'data':data},function(response){

				$(".modal").removeClass("show");
				if(response === "1"){

					swal("SUCCESS!", "La catégorie a été ajouté!", "success");
					var data = {
						"page"	:	"apropos",
						"p"		:	{
							"s"		:	0,
							"pp"	:	50
						}
					};

					$.ajax({

						type		: 	"POST",
						url			: 	"pages/default/includes/params.php",
						data		:	data,
						success 	: 	function(response){
											$('.content').html(response);
											$(".modal").removeClass("show");
										},
						error		:	function(response){
											$('.content').html(response);
											$(".modal").removeClass("show");

						}
					});



				}else{
					$(".debug_client").html("Impossible d\'enregistrer le client : " + response);
				}


			});	
		}

	});
	
	$(document).on('click','.api_send', function(){
		var data = {
			'token' 	:	$("#api_whatsapp").val(),
			'phone' 	: 	$("#api_number").val(),
			'msg' 		: 	$("#api_msg").val(),
			
		};
		
		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/params/get.php",
			data		:	data,
			dataType	: 	"json",
		}).done(function(response){
			if (response.code === 1){
				$(".api_result").html("<div class='info info-success'><div class='info-message'> "+response.msg+'</div></div>');
				
			}else{
				$(".api_result").html("<div class='info info-error'><div class='info-message'> "+response.msg+'</div></div>');
			}
								
		}).fail(function(response, textStatus){
			$(".api_result").html(textStatus);
		});
		
	});
		
	$(document).on('change','#creative_file_to_upload',function(){
		var id_client = $(this).attr("data");
		
		var params = {
			IdIputFile			:	"creative_file_to_upload",
			PHPUploader			:	"pages/default/ajax/upload_files.php",
			PHPUploaderParams	:	"?id=creative/"+id_client
			
		};
		
		
		if($(this).val() !== ""){
			uploader(params);
		}
		
	});
	
	$(document).on('click', '.showImage', function(){
		var src = $(this).attr("src");
		$(".modal").removeClass("hide").addClass("show").html("<div class='modal-content'><img src='"+src+"' style='width:100%; height:auto'></div>");
	});
	

});
 
function draw(container, type, columns, data){
	
	var ctx = document.getElementById(container).getContext('2d');
	var myChart = new Chart(ctx, {
		type: type,
		data: {
			labels: columns,
			datasets: [{
				label: ' Commandes ',
				data: data,
				backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.3)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
				'rgba(255, 99, 132, 0.8)',
				'rgba(255, 206, 86, 0.7)',
				],
				borderWidth: 1
			}]
		},

		options: {
			elements: {
				line:{
					tension:0,
				}
			},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:false
					}
				}]
			}
		}

	});
}

$(window).on("load", function() {
	if($("#myChart").length>0){
		console.log("show_graph");
		$.ajax({
			type		: 	"POST",
			url			: 	"pages/default/ajax/graph/graph_01.php",
			dataType	: 	"json",
		}).done(function(response){
				console.log(response);
				var _months = ["Jan","Fév","Mars","Avr","Mai","Juin","Juil","Août","Sept","Oct","Nov","Déc"];
				var months = [];
				var totals = [];
				for(var i in response){
					months.push(response[i].month);
					totals.push(response[i].total);
				}			
				
				draw("myChart","bar",months,totals);
			
		}).fail(function(response, textStatus){
			$(".debug").html(textStatus);
			$(".modal").html("").removeClass('show');
		});		
	}

	
});


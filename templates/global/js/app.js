//var HOST = 'http://localhost/1_PROJECTS/locator-app/';
var HOST = 'http://www.manager.kabilamarina.com/';
var animationend = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";

$(document).ready(function(){

	$(".btn_login").on("click", function(){
		var action = $(this).val();
		var columns = {
			"login*"		:	$("#login").val(),
			"password*"		:	$("#password").val(),
		};
		
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
			
		var params = {
			"action"	: 	$(this).val(),
			"args"		:	{
				"login"			:	$("#login").val(),
				"password"		:	$("#password").val(),
				"formToken"		:	$("#formToken").val(),
				"remember"		:	($("#remember").is(':checked'))? 1:0,
			}
		};
			var this_btn = $(this);
			this_btn.find(".is_doing").removeClass("hide");
			this_btn.find(".do").addClass("hide");
			this_btn.prop("disabled",true);
			$.post("pages/login/ajax/login.php",{'param':params}, function(response){

				if(response=== "1"){
					if(action === "logout"){
						this_btn.val("login");
					}else{
						this_btn.val("logout");
					}

					this_btn.find(".is_doing").addClass("hide");
					this_btn.find(".do").removeClass("hide");
					this_btn.prop("disabled",false);

					$(".login_response").html('	<div class="info info-success"><b>Success ! </b> <div class="info-message">Message returned from server</div></div>');
					location.reload();
					//setInterval(function(){ location.reload(); }, 3000);


				}else{
					$(".login_response").html('	<div class="info info-error info-dismissible"> <div class="info-message"> '+response+' </div> <a href="#" class="close" data-dismiss="info" aria-label="close">&times;</a></div>');

					this_btn.find(".is_doing").addClass("hide");
					this_btn.find(".do").removeClass("hide");
					this_btn.prop("disabled",false);

				}


			});			
		}
		

		
	});
	
	$("#password").on("keyup",function(e) {
		if(e.keyCode === 13 ) {
			$(".btn_login").trigger('click');
		}
	});

	
	
});

var Reloader;
var IdIputFile;

function uploader(params){

			// Contains the file selected by File Element
	IdIputFile = params["IdIputFile"];
		
	var PHPUploader;		// Path to the PHP File Uploder
		PHPUploader = params['PHPUploader'];
		
	var PHPUploaderParams;	// Parameters to Pass to the PHPUploader
		PHPUploaderParams = params['PHPUploaderParams'];
	
	Reloader = params['Reloader'];

	var IdProgress;			// The ID of the progress bar to display progress <div id="progress"
							// <div id="progress"><div id="progress-bar"></div></div>
		IdProgress = "progress";
	
	var xhrq = check_ajax_version();

	var form = new FormData(); //	Internet Explorer does not support it.
	var file = div(IdIputFile).files[0];
	form.append("upload_file", file);
	
	xhrq.upload.addEventListener("progress", upload_progress, false);
	xhrq.addEventListener("load", upload_response,false);
	
	xhrq.open("POST", PHPUploader + PHPUploaderParams);
	xhrq.send(form);

	return true;
}


//	Event listener for the progress of the file
function upload_progress(event){
	var upload_percentage = 0;
	var IdProgress = ".progress";
	
	if(event.lengthComputable){
		upload_percentage = Math.round((event.loaded / event.total) * 100);
		
		$(IdProgress).removeClass('hide');
		$(IdProgress+" .progress-bar").css('width',upload_percentage.toString() + "%");
		$(IdProgress+" .progress-bar").html(upload_percentage.toString() + "%");

		if(upload_percentage == 100){
			var animation = 'animated fadeOut';
			$(IdProgress).addClass(animation).one(animationend, function(){
				$(IdProgress).removeClass(animation);
				$(IdProgress).addClass('hide');	
			});	
		}
	}
	return false;
}

//	Response from server whether success or failure
function upload_response(event){
	var response = null;
	
	if(event.target.responseText){
		response = event.target.responseText;
		$("."+Reloader).trigger('click');
	}
	return false;	
}

//	Function to check the AJAX version of the browser
function check_ajax_version(){
	var version = false;
	var ie_versions = ["MSXML2.XMLHTTP.6.0", "MSXML2.XMLHTTP.3.0", "Microsoft.XMLHTTP"];
	for(var i = 0; i < ie_versions.length; i++)
	{
		try
		{
			version = new ActiveXObject(ie_versions[i]);
			break;
		}
		catch(e)
		{
			continue;
		}
	}
	if(version == false)
	{
		version = new XMLHttpRequest();
	}
	else
	{
		version = version;
	}
 	return version;
}

//  Mimic jQuery
function div(id_of_element){
    id_of_element = document.getElementById(id_of_element);
    return id_of_element;
} 
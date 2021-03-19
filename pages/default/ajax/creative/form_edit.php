<?php session_start(); $core = $_SESSION['CORE']; 

$table_name = $_POST["page"];
require_once($core.$table_name.".php");
$ob = new $table_name();
$ob->id = $_POST["id"];
$data = $ob->read()[0];
$imoticon = array(😀,😃,😄,😁,😆,😅,🤣,😂,🙂,😉,😊,😇,😍,😘,😜,😛,🤑,😎,😱);
$formToken=uniqid();
$return_page = "Creative";
?>
<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-address-card"></i> Creative / الرسالة
	</div>
	<div class="col_6-inline actions <?= strtolower($return_page) ?>">
		<button class="btn btn-green save" value="<?= $return_page ?>"><i class="fas fa-save"></i></button>
		<button class="btn btn-default close" value="<?= $return_page ?>"><i class="fas fa-times"></i></button>
	</div>
</div>
<hr>
<div class="row">
	<div class="col_6">
		<div class="panel">
			<div class="panel-content">
				<h3 style="margin-left: 6px"> Creative / الرسالة</h3>
				<input type="hidden" id="id" value="<?= $data["id"] ?>">
				<div class="row" style="margin-bottom: 20px">
					<div class="col_6-inline">
						<label for="creative_title">Title </label>
						<input type="text" placeholder="Creative / عنوان" id="creative_title" value="<?= $data["title"] ?>">
					</div>
					<div class="col_6-inline">
						<span style="padding: 2px 0 0 0; display: block">Type d'Envoi</span>
						<div class='btn-group-radio'>
							<button class='btn btn-default whatsapp_type checked' value='chat' style='padding:5px 7px'>Chat</button>
							<button class='btn btn-default whatsapp_type ' value='file' style='padding:5px 7px'>Image</button>
						</div>
					</div>			
				</div>	

				<div class="row creative_chat" style="margin-bottom: 20px">
					<div class="col_12">
						<?php
							foreach($imoticon as $k=>$v){
								echo "<button class='imoticon' value='".$v."' style='margin:5px'>" . $v . "</button>";
							}
						?>
					</div>
					<div class="col_12-inline">
						<label for="creative_body">Body / الرسالة </label>
						<textarea id="creative_body_chat" style="max-width: 100%;height: 250px"><?= $data["body"] ?></textarea>
					</div>				
				</div>
				
				<div class="row creative_file hide">
					
					<div class="col_12">
						<button class="btn btn-orange upload_btn" style="position: relative; overflow: hidden">
						<i class="fas fa-upload"></i> Choisir
						<input type="file" id="creative_file_to_upload" data="<?= $data["id"] ?>" class="" name="image" accept="image/*" capture style="position: absolute; top: 0; left: 0; background-color: aqua; padding: 10px 0; opacity: 0">
						</button>
						<button class="show_files creative btn btn-default" value="<?= $data["id"] ?>">show</button>
					</div>
					
					<div class="col_12" style="background-color: #F1EFEF; margin-top: 20px">
					
						<div class="creative_image" style="max-width: 250px; margin: 0 auto; height: auto; text-align: center">
							<div class="image" style="margin: 10px 0">
								<img src="http://<?= $_SESSION["HOST"] ?>templates/default/images/creative_0.png" style="width: 100%; height: auto">
							</div>
						</div>
					
					</div>
					
					<div id="progress" class="progress"><div id="progress-bar" class="progress-bar"></div></div>				
				</div>

				
				
				<div class="row" style="margin-bottom: 20px; margin-top: 20px">
					<div class="col_6-inline">
						<div class="" style="position: relative; width: 125px">
							<div class="on_off <?= ($data["status"] == "1")? "on":"off" ?>" id="creative_status"></div>
							<span style="position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px">
								  Status
							</span>
						</div>
					</div>						
				</div>
			</div>
		</div>		
	</div>
	
	<div class="col_6">
		<div class="panel">
			<div class="panel-content">
				<h3 style="margin-left: 6px"> Abonné(s) / المنخرطوت</h3>
				<div class="row" style="margin-bottom: 20px">
					<div class="col_12">
						<select id="abonnee">
							<option value="-1"> -- Abonné(e) -- </option>
							<?php  
								require_once($core."User_Category.php");
		 						$u = $user_category->fetchAll();
		 						foreach($u as $k=>$v){
									echo '<option value="'.$v["id"].'">'.$v["user_category"].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="row" style="margin-bottom: 20px">
					<div class="col_12" id="abonnee_list">
						
					</div>
				</div>
				<div class="row api_result" style="margin-bottom: 20px">

				</div>
			</div>
		</div>
	</div>
	
</div>
	


<div class="debug_client"></div>


<?php session_start(); 
if(!isset($_SESSION['CORE'])){ die("-1"); }
if(!isset($_POST["page"])){ die("-2"); }

$core = $_SESSION['CORE']; 
$action = "add";
$table_name = $_POST["page"];
if(!file_exists($core.$table_name.".php")){ die("-3"); }
$formToken = md5( uniqid('auth', true) );
$id = 0;
$return_page = "Person";

if(isset($_POST["id"])){
	require_once($core.$table_name.".php");
	$ob = new $table_name();
	$id = $_POST["id"];
	$data = $ob->find('', ['id='=>$id], 'v_person');
	
	if( count( $data ) < 1){ die("-4"); }
	$data = $data[0];
	$action = "edit";
	
}else{
	require_once($core.$table_name.".php");
	$ob = new $table_name();
}
?>
<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-address-card"></i> Utilisateur
		<input type="hidden" id="UID" value="<?= $action==='edit'? $data["UID"]: $formToken; ?>">
		<?= $action==='edit'? '<input type="hidden" id="id" value="'.$data["id"].'">': '' ?>
	</div>
	<div class="col_6-inline actions <?= strtolower($return_page) ?>">
		<button class="btn btn-green save" value="<?= $return_page ?>"><i class="fas fa-save"></i></button>
		<button class="btn btn-default close" value="<?= $return_page ?>"><i class="fas fa-times"></i></button>
	</div>
</div>
<hr>

<div class="panel">
	<div class="panel-header" style="padding: 0px">
		<div class="panel-header-tab ">
			<a href="" class="active"><i class="fas fa-file-invoice"></i> Détails</a>
			<a href=""><i class="far fa-clock"></i> Droit</a>
			<a  href=""><i class="fas fa-images"></i> Activités</a>
		</div>
	</div>
	<div class="panel-content" style="padding: 0px">
		<div class="tab-content">
			<div class="row">
				<div class="col_4" style="background-color: rgba(102,100,100,1.00); padding: 10px 0">
					<button class="show_files person hide" value="<?= $action==='edit'? $data["UID"]: $formToken; ?>"></button>
					<div class="person_image" style="max-width: 250px; margin: 0 auto; height: auto; text-align: center">
						<div class="image" style="margin: 10px 0">
							<img src="http://<?= $_SESSION["HOST"] ?>templates/default/images/user.png" style="width: 100%; height: auto">
						</div>
						
						<div class="row person_actions">
							<div class="col_6-inline">
								<button class="btn btn-orange upload_btn" style="position: relative; overflow: hidden">
								<i class="fas fa-upload"></i> Choisir
								<input type="file" id="upload_file_person" data="<?= $action==='edit'? $data["UID"]: $formToken; ?>" class="" name="image" accept="image/*" capture style="position: absolute; top: 0; left: 0; background-color: aqua; padding: 10px 0; opacity: 0">
								</button>
							</div>
							<div class="col_6-inline" style="text-align: right">
								<button class="btn btn-red remove"><i class="fas fa-redo-alt"></i> Initialiser</button>
							</div>
							
							
							
						</div>						
					</div>
					<div id="progress" class="progress hide"><div id="progress-bar" class="progress-bar"></div></div>
				</div>
				
				
				
				<div class="col_8">
					<h3 style="margin-left: 6px">Fiche Utilisateur</h3>

					<div class="row" style="margin-bottom: 20px">
						<div class="col_6-inline">
							<label for="person_first_name">Prénom</label>
							<input type="text" id="person_first_name" placeholder="Prénom" value="<?= $action==='edit'? $data["first_name"]: ""; ?>">
						</div>				
						<div class="col_6-inline">
							<label for="person_last_name">Nom</label>
							<input type="text" id="person_last_name" placeholder="Nom" value="<?= $action==='edit'? $data["last_name"]: ""; ?>">
						</div>
					</div>
					<div class="row" style="margin-bottom: 20px">
						<div class="col_6-inline">
							<label for="person_profile">Profile</label>
							<select id="person_profile">
								<option selected value="-1"></option>
									<?php require_once($core."Person_Profile.php"); 
										foreach( $person_profile->fetchAll() as $k=>$v){
											if($action === 'edit'){
									?>	
												<option <?= ($v["id"]==$data["id_profil"])? "selected":"" ?> value="<?= $v["id"] ?>"> <?= $v["person_profile"] ?> </option>
									<?php 	}else{ ?>
												<option value="<?= $v["id"] ?>"> <?= $v["person_profile"] ?> </option>
									<?php 	}
										}
								?>
							</select>
						</div>
					</div>	


					<div class="row" style="margin-bottom: 20px; border-bottom: 1px solid rgba(197,197,197,1.00)">
						<div class="col_8-inline">
							<h3 style="margin-left: 6px">CONTACT</h3>					
						</div>
					</div>

					<div class="row" style="margin-bottom: 20px;">
						<div class="col_6-inline">
							<label for="person_telephone">Téléphone </label>
							<input type="text" placeholder="Téléphone" id="person_telephone" value="<?= $action==='edit'? $data["telephone"]: ""; ?>">
						</div>	
						<div class="col_6-inline">
							<label for="person_email">E-Mail </label>
							<input type="text" placeholder="E-Mail" id="person_email" value="<?= $action==='edit'? $data["email"]: ""; ?>">
						</div>	

					</div>	

					<div class="row">
						<div class="col_12">
							<div class="row" style="margin-bottom: 20px; border-bottom: 1px solid rgba(197,197,197,1.00)">
								<div class="col_12-inline">
									<h3 style="margin-left: 6px">CONNEXION</h3>					
								</div>
							</div>						
						</div>
					</div>
					<div class="row" style="margin-bottom: 20px;">
						<div class="col_6-inline">
							<label for="person_login">Login </label>
							<input type="text" placeholder="Login" id="person_login" value="<?= $action==='edit'? $data["login"]: ""; ?>">
						</div>	
						<div class="col_6-inline">
							<label for="person_login">Password </label>
							<div class="input-group">
								<input type="text" placeholder="Password" id="person_password">
								<div class="input-suf">
									<button value="<?= $action==='edit'? $data["id"]: ""; ?>" class="person_password_reset" style="background-color: red; color: white; border-radius: 0; padding: 8px 10px; margin-right: 0px; border-top-right-radius: 7px;border-bottom-right-radius: 7px;">Initialiser</button>
								</div>
							</div>
						</div>		
					</div>
					
					<div class="row" style="margin-bottom: 20px">
						<div class="col_6-inline">
							<div class="" style="position: relative; width: 125px">
								<div class="on_off <?= $action==='edit'? ($data["status"] == 1)? "on" : "off": "on"  ?>" id="person_status"></div>
								<span style="position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px">
									  Status
								</span>
							</div>
						</div>						
					</div>				
				</div> <!-- COL-8 -->
			</div> <!-- ROW-->
		</div>

	
		<div class="tab-content" style="display: none">
			<div class="location_form">
				<div class="row">
					<div class="col_4-inline">
						<h3 style="margin-left: 6px">Droits</h3>
					</div>
					<div class="col_8-inline" style="text-align: right; padding: 10px 5px">
						<button class="btn btn-default refresh_droit" value="0"><i class="fas fa-sync-alt"></i></button>
					</div>
				</div>
				<div class="location_form_content">
					<?php 
	/*
					require_once($core."Propriete_Proprietaire_Location.php"); 
					echo $propriete_proprietaire_location->drawTable("", array("conditions" => array("id_propriete=" => 0 )) );
					*/
					?>				
				</div>

			</div>
		</div>
	
		<div class="tab-content" style="display: none" >

			<div class="row">
				<div class="col_4-inline">
					<h3 style="margin-left: 6px">Activités</h3>
				</div>
				<div class="col_8-inline" style="text-align: right; padding: 10px 5px">
					<button class="btn btn-default refresh_droit" value="0"><i class="fas fa-sync-alt"></i></button>
				</div>
			</div>
			<div class="person_activity">
				<?php 
				require_once($core."Person_Activity.php"); 
				echo $person_activity->drawTable("", array("conditions" => array("created_by=" => $data["id"] )) );
				?>				
			</div>

		</div>
	</div>	<!-- END PANEL CONTENT -->

</div>

<div class="debug_client"></div>


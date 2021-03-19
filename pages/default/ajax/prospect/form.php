<?php session_start(); 
if(!isset($_SESSION['CORE'])){ die("-1"); }
if(!isset($_POST["page"])){ die("-2"); }

$core = $_SESSION['CORE']; 
$action = "add";
$table_name = $_POST["page"];
if(!file_exists($core.$table_name.".php")){ die("-3"); }
$formToken = md5( uniqid('auth', true) );
$id = 0;

if(isset($_POST["id"])){
	require_once($core.$table_name.".php");
	$ob = new $table_name();
	$ob->id = $_POST["id"];
	$id = $_POST["id"];
	if( count( $ob->read() ) < 1){ die("-4"); }
	$data = $ob->read()[0];
	$action = "edit";
	
}


?>
<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-folder-open"></i> Prospect <span style="font-size: 9px"><?= ($action === "edit")? "<span style='color:red'>" . $data["_md5"] . "</span>" : substr($formToken,0,8) ?></span>
	</div>
	<div class="col_6-inline actions">
		<button class="btn btn-green save_form <?= ($action === "edit")? "edit" : "" ?>" data-table="<?= $table_name ?>"><i class="fas fa-save"></i></button>
		<button class="btn btn-default close" value="<?= $table_name ?>"><i class="fas fa-times"></i></button>
	</div>
</div>
<hr>

<div class="panel">
	
	<div class="panel-header" style="padding: 0px">
		<div class="panel-header-tab ">
			<a href="" class="active"><i class="fas fa-folder-open"></i> Détails</a>
		</div>
	</div>
	
	<div class="panel-content" style="padding: 0px">
		<div class="tab-content">
			<div class="row  <?= strtolower($table_name) ?>" style="margin-top: 25px">
			<?= ($action === "edit")? "<input class='form-element' type='hidden' id='id' value='".$id."'>" : "" ?>
				
				<div class="row" style="margin-bottom: 20px">
					<div class="col_2">
						<label for="created">Date </label>
						<input style='text-align:center; font-size:14px; font-weight:bold' type='text' placeholder='AAAA-MM-DD' readonly id='created' value='<?= ($action === "edit")? $data["created"] : "" ?>'>
					</div>
					
					<div class="col_2">
						<label for="ip_from">IP </label>
						<input style='text-align:left; font-size:14px; ' type='text' readonly placeholder='ip' id='ip_from' value='<?= ($action === "edit")? $data["ip_from"] : "" ?>'>
					</div>
				</div>
				
				<div class="row" style="margin-bottom: 20px">
					<div class="col_6">
						<label for="first_name">Prénom</label>
						<input class="form-element required" type="text" placeholder="Prénom" id="first_name" value="<?= ($action === "edit")? $data["first_name"] : "" ?>">
					</div>	
					<div class="col_6">
						<label for="last_name">Nom</label>
						<input class="form-element required" type="text" placeholder="Nom" id="last_name" value="<?= ($action === "edit")? $data["last_name"] : "" ?>">
					</div>	
				</div>
				
				<div class="row" style="margin-bottom: 20px">
					<div class="col_4">
						<label for="phone_1">Phone (1)</label>
						<input class="form-element required" readonly type="text" placeholder="Phone (1)" id="phone_1" value="<?= ($action === "edit")? $data["phone_1"] : "" ?>">
					</div>	
					<div class="col_4">
						<label for="phone_2">Phone (2)</label>
						<input class="form-element" type="text" placeholder="Phone (2)" id="phone_2" value="<?= ($action === "edit")? $data["phone_2"] : "" ?>">
					</div>	
					<div class="col_4">
						<label for="email">Email</label>
						<input class="form-element required" readonly type="text" placeholder="Email" id="email" value="<?= ($action === "edit")? $data["email"] : "" ?>">
					</div>
				</div>
				
				<div class="row" style="margin-bottom: 20px">
					<div class="col_2">
						<label for="city">Ville</label>
						<input class="form-element required" readonly type="text" placeholder="Ville" id="city" value="<?= ($action === "edit")? $data["city"] : "" ?>">
					</div>	
					<div class="col_10">
						<label for="address">Adresse</label>
						<input class="form-element required" type="text" placeholder="Adress" id="address" value="<?= ($action === "edit")? $data["address"] : "" ?>">
					</div>	

				</div>
				
				<div class="row" style="margin-bottom: 20px">
					<div class="col_12">
						<label for="notes">Remarques</label>
						<textarea class="form-element" id="notes" ><?= ($action === "edit")? $data["notes"] : "" ?></textarea>
					</div>		

				</div>
				
				<div class="row" style="margin-bottom: 20px">
					<div class="col_6">
						<div class="" style="position: relative; width: 125px">
							<div class="on_off <?= ($action === "edit")? ($data["status"])? "on" : "off" : "off" ?> form-element" id="status"></div>
							<span style="position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px">
								  Status
							</span>
						</div>
					</div>						
				</div>
			</div> <!-- ROW-->
		</div>
		
	</div>	<!-- END PANEL CONTENT -->

</div>

<div class="debug"></div>


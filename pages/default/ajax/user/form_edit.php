<?php session_start(); $core = $_SESSION['CORE']; 

$table_name = $_POST["page"];
require_once($core.$table_name.".php");
$ob = new $table_name();
$ob->id = $_POST["id"];
$data = $ob->read()[0];

$formToken=uniqid();
$return_page = "User";
?>
<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-address-card"></i> Abonné
	</div>
	<div class="col_6-inline actions <?= strtolower($return_page) ?>">
		<button class="btn btn-green save" value="<?= $return_page ?>"><i class="fas fa-save"></i></button>
		<button class="btn btn-default close" value="<?= $return_page ?>"><i class="fas fa-times"></i></button>
	</div>
</div>
<hr>

<div class="panel">
	<div class="panel-content">
	
		<div class="menu_form">

			<h3 style="margin-left: 6px">Abonné</h3>
			<input type="hidden" value="<?= $data["id"] ?>" id="id">
			<div class="row" style="margin-bottom: 20px">
				<div class="col_6-inline">
					<label for="first_name">Prénom </label>
					<input type="text" placeholder="Prénom" id="first_name" value="<?= $data["first_name"] ?>">
				</div>				
				<div class="col_6-inline">
					<label for="last_name">Nom </label>
					<input type="text" placeholder="Nom" id="last_name" value="<?= $data["last_name"] ?>">
				</div>
			</div>
			<div class="row" style="margin-bottom: 20px">
				<div class="col_6-inline">
					<label for="username">Username </label>
					<input type="text" placeholder="Username" id="username" value="<?= $data["username"] ?>">
				</div>	
				<div class="col_6-inline">
					<label for="email">Email </label>
					<input type="text" placeholder="Email" id="email" value="<?= $data["email"] ?>">
				</div>			
			</div>	
			<div class="row" style="margin-bottom: 20px">
				<div class="col_6-inline">
					<label for="ville">Ville </label>
					<input type="text" placeholder="Ville" id="ville" value="<?= $data["city"] ?>">
				</div>	
				<div class="col_6-inline">
					<label for="ip">I.P. </label>
					<input type="text" disabled placeholder="IP" id="ip" value="<?= $data["ip"] ?>">
				</div>			
			</div>	
			<div class="row" style="margin-bottom: 20px">
				<div class="col_6-inline">
					<label for="user_category">Catégorie </label>
					<select id="user_category">
						<option selected value="-1"></option>
							<?php require_once($core."User_Category.php"); 
								foreach( $user_category->fetchAll() as $k=>$v){
							?>	
						<option <?= ($v["id"] == $data["id_user_category"])? "selected":"" ?> value="<?= $v["id"] ?>"> <?= $v["user_category"]  ?> </option>
							<?php } ?>
					</select>
				</div>				
				<div class="col_6-inline">
					<label for="user_status">Status </label>
					<select id="user_status">
						<option selected value="-1"></option>
							<?php require_once($core."User_Status.php"); 
								foreach( $user_status->find("", array(), "") as $k=>$v){
							?>	
						<option <?= ($v["id"] == $data["id_user_status"])? "selected":"" ?> value="<?= $v["id"] ?>"> <?= $v["user_status"] ?> </option>
							<?php } ?>
					</select>
				</div>	
			</div>
			<div class="row" style="margin-bottom: 20px; border-bottom: 1px solid rgba(197,197,197,1.00)">
				<div class="col_4-inline">
					<h3 style="margin-left: 6px">ABONNEMENT</h3>					
				</div>
				<div class="col_8-inline" style="text-align: right">
					<button class="btn btn-default select_course" value="<?= $data["id"] ?>"><i class="fas fa-graduation-cap"></i> Ajouter</button>	
					<button class="btn btn-default refresh_course" value="<?= $data["id"] ?>"><i class="fas fa-sync-alt"></i></button>			
				</div>
			</div>
			<div class="row course_of_user">
							<?php require_once($core."User_Abonnement.php"); 
							$conditions = array("conditions" => array("id_user=" => $data["id"] ));
							echo $user_abonnement->drawTable("",$conditions);
								
							?>	
			</div>
			
		<h3 style="margin-left: 6px">NOTE(S)</h3>
			<div class="row" style="margin-bottom: 20px">
				<div class="col_12-inline">
					<textarea id="notes" style="max-width: 100%; height: 120px"><?= $data["notes"] ?></textarea>
				</div>					
			</div>						
		</div>		

	</div>

</div>

<div class="debug_client"></div>


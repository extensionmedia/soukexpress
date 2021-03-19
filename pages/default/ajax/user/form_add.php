<?php session_start(); $core = $_SESSION['CORE']; 

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
			
			<div class="row" style="margin-bottom: 20px">
				<div class="col_6-inline">
					<label for="first_name">Prénom </label>
					<input type="text" placeholder="Prénom" id="first_name" value="">
				</div>				
				<div class="col_6-inline">
					<label for="last_name">Nom </label>
					<input type="text" placeholder="Nom" id="last_name" value="">
				</div>
			</div>
			<div class="row" style="margin-bottom: 20px">
				<div class="col_6-inline">
					<label for="username">Username </label>
					<input type="text" placeholder="Username" id="username" value="">
				</div>	
				<div class="col_6-inline">
					<label for="email">Email </label>
					<input type="text" placeholder="Email" id="email" value="">
				</div>			
			</div>	
			<div class="row" style="margin-bottom: 20px">
				<div class="col_6-inline">
					<label for="ville">Ville </label>
					<input type="text" placeholder="Ville" id="ville" value="">
				</div>	
				<div class="col_6-inline">
					<label for="user_ip">I.P. </label>
					<input type="text" disabled placeholder="IP" id="user_ip" value="">
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
						<option <?= ($v["is_default"] == "1")? "selected":"" ?> value="<?= $v["id"] ?>"> <?= $v["user_category"]  ?> </option>
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
						<option <?= ($v["is_default"] == "1")? "selected":"" ?> value="<?= $v["id"] ?>"> <?= $v["user_status"] ?> </option>
							<?php } ?>
					</select>
				</div>	
			</div>
		
		<h3 style="margin-left: 6px">NOTE(S)</h3>
			<div class="row" style="margin-bottom: 20px">
				<div class="col_12-inline">
					<textarea id="user_notes" style="max-width: 100%; height: 120px"></textarea>
				</div>					
			</div>						
		</div>		

	</div>


</div>

<div class="debug_client"></div>


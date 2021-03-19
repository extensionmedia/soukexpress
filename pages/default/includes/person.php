<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$core = $_SESSION["CORE"];
$table_name = "Person";
require_once($core.$table_name.".php");  
$ob = new $table_name();
?>

	<div class="row page_title">
		<div class="col_6-inline icon">
			<i class="fas fa-address-card"></i> Utilisateurs
		</div>
		<div class="col_6-inline actions">
			<button class="btn btn-green add" value="<?= $table_name ?>"><i class="fas fa-plus" aria-hidden="true"></i></button>
			<button class="btn btn-default refresh" value="<?= $table_name ?>"><i class="fas fa-sync-alt"></i></button>
			<button class="btn btn-orange showSearchBar"><i class="fas fa-search-plus"></i></button>
		</div>
	</div>
	<hr>
	<div class="row searchBar" style="background-color: rgba(241,241,241,1.00); padding: 10px 0; margin: 10px 0px">
		<div class="col_6-inline">
			
			<div class="input-group" style="overflow: hidden">
				<input type="text" placeholder="Chercher" class="suf" name="" id="request">
				<div class="input-suf"><button title="Chercher" id="a_u_s"><i class="fa fa-search"></i></button></div>
			</div>

		</div>
		<div class="col_6-inline">
			<div class="row _select">
				<div class="col_6-inline">
					<select id="person_profile" data="profile">
						<option selected value="-1"> --  Profile  -- </option>
							<?php require_once($core."Person_Profile.php"); 
								foreach( $person_profile->find("", array("order"=>"person_profile"), "") as $k=>$v){
							?>	
						<option value="<?= $v["id"] ?>"> <?= strtoupper( $v["person_profile"] ) ?> </option>
							<?php } ?>
					</select>
				</div>
				
			</div>

		</div>
		<div class="col_12 _choices" style="padding-top: 15px"></div>
	</div>
	
	<div class="row <?= $table_name ?>">
		<?php
$args 			= 	['sort_by'		=>	'first_name DESC'];
$conditions		=	[];
$use = 'v_person';		 
echo $ob->drawTable($args, $conditions, $use); ?>		
	</div>

		
	<div class="debug"></div>

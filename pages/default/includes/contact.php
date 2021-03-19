<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$core = $_SESSION["CORE"];
$table_name = "Contact";
require_once($core.$table_name.".php");  
$ob = new $table_name();

?>

	<div class="row page_title">
		<div class="col_6-inline icon">
			<i class="fas fa-address-card"></i> <?= $table_name ?>(s)
		</div>
		<div class="col_6-inline actions">
			<button class="btn btn-default refresh" value="<?= $table_name ?>"><i class="fas fa-sync-alt"></i></button>
			<button class="btn btn-orange showSearchBar"><i class="fas fa-search-plus"></i></button>
		</div>
	</div>
	<hr>
	<div class="row searchBar hide" style="background-color: rgba(241,241,241,1.00); padding: 10px 0; margin: 10px 0px">
		<div class="col_12-inline">
			
			<div class="input-group" style="overflow: hidden">
				<input type="text" placeholder="Chercher" class="suf" name="" id="request">
				<div class="input-suf"><button title="Chercher" id="a_u_s"><i class="fa fa-search"></i></button></div>
			</div>

		</div>
		<div class="col_5-inline">

		</div>
	</div>
	
	<div class="row <?= strtolower($table_name) ?>">
		<div class="col_12" style="padding: 0">	
		<?php $values = $ob->find(null,array("order"=>"created ASC","limit"=>array(0,20)),"contact");  
			$columns = $ob->getColumns(); 
			$totalItems = $ob->getTotalItems();
			?>

		<div style="display: flex; flex-direction: row">

			<div style="flex: auto; padding: 12px 0 10px 5px; margin: 0; color: rgba(118,17,18,1.00)">
			Total : <?= count($values).' / '.$totalItems ?> <span class="current hide">0</span>

			</div>

			<div style="width: 10rem">

				<div style="flex-direction: row; display: flex">
					<div style="flex: 1">
						<select id="showPerPage" style="width: 70px">
							<option value="20" selected>20</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="200">200</option>
							<option value="500">500</option>
						</select>
						<span class="hide desc" id="sort_by">created</span>
					</div>
					<div style="flex: 1; text-align: center">
						<div class="btn-group">
							<a style="padding: 12px 12px" id="btn_passive_preview"  title="Précédent"><i class="fa fa-chevron-left"></i></a>
							<a style="padding: 12px 12px" id="btn_passive_next" title="Suivant"><i class="fa fa-chevron-right"></i></a>
						</div>											
					</div>
				</div>

			</div>

		</div>
		<div class="panel" style="overflow: auto;">
				<div class="panel-content" style="padding: 0">
					<table class="table">
						<thead>
							<tr>
								<?php
									foreach($columns as $key=>$value){
										echo "<th class='sort_by' data-sort='" . $value["column"] . "'>" . $value["label"] . "</th>";
									}
										echo "<th style='width:55px'></th>";
								?>

							</tr>
						</thead>
						<tbody>
							<?php
								//var_dump($values);
								$i = 0;
								foreach($values as $k=>$v){
									//$status = '<img style="cursor: pointer;" src="http://'.$_SESSION["HOST"].'templates/default/images/disable.png" class="enable_this_c" title="'.$v["id"].'">';
							?>
							<tr class="edit_ligne" data-page="<?= $table_name ?>">
								<?php
									foreach($columns as $key=>$value){
										if(isset($v[ $columns[$key]["column"] ])){
											if($columns[$key]["column"] == "is_default"){
												echo ($v[ $columns[$key]["column"] ] == 0)? "<td>-</td>": "<td>Par Défaut</td>";
											}elseif($columns[$key]["column"] == "id"){
												echo "<td><span class='id-ligne'>" . $v[ $columns[$key]["column"] ] . "</span></td>";
											}elseif($columns[$key]["column"] == "status"){
												
												if($v[ $columns[$key]["column"] ] == 1){
													echo "<td><div class='label label-green'>Activé</div></td>";
												}else{
													echo "<td><div class='label label-red'>Désactivé</div></td>";
												}
												
												
											}else{
												echo "<td>" . $v[ $columns[$key]["column"] ] . "</td>";
											}											
										}else{
											echo  "<td>NaN</td>";
										}

										
									}
									echo  "<td><button data-page='".$table_name."' class='btn btn-orange edit_ligne' value='".$v["id"]."'><i class='fas fa-edit'></i></button></td>";
								?>

							</tr>
							<?php
								$i++;
								}
							?>

						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	</div>
		
	<div class="debug_client"></div>

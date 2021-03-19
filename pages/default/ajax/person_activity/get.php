<?php session_start();

if(!isset($_SESSION['CORE'])){die();}
if(!isset($_POST['data'])){die();}


$table_name = $_POST['data']['t_n'];
$core = $_SESSION['CORE'];

if(file_exists($core.$table_name.".php")){
	require_once($core.$table_name.".php");
	$ob = new $table_name();
	
	$p_p = $_POST['data']['p_p'];
	$sort_by = $_POST['data']['sort_by'];
	$temp = explode(" ", $sort_by );
	$order = "";
	if(count( $temp ) > 1 ){ $order =  $temp[1]; }
	$current = $p_p *  $_POST['data']['current'];
	$request =  $_POST['data']['request'];
	
	$conditions = array();

	if($request !== ""){$conditions["code like "] = "%".$request."%";}
	if(isset($_POST['data']['filter'])){
		foreach($_POST['data']['filter'] as $k=>$v){
			if($k === "urilisateur") $conditions["created_by = "] = $v;
			if($k === "action") $conditions["activity_action = "] = $v;
		}
	}

	
	if(empty($conditions)){
		$values = $ob->find(null,array("order"=>$sort_by,"limit"=>array($current,$p_p)),"v_person_activity");
		$totalItems = $ob->getTotalItems();
	}else{
		if(count($conditions)>1){
		$totalItems = count($ob->find(null,array("conditions AND"=>$conditions,"order"=>$sort_by),"v_person_activity"));
		$values = $ob->find(null,array("conditions AND"=>$conditions,"order"=>$sort_by,"limit"=>array($current,$p_p)),"v_person_activity");			
		}else{
		$totalItems = count($ob->find(null,array("conditions"=>$conditions,"order"=>$sort_by),"v_person_activity"));
		$values = $ob->find(null,array("conditions"=>$conditions,"order"=>$sort_by,"limit"=>array($current,$p_p)),"v_person_activity");			
		}

	}
	
	
	
	
	$values = (is_null($values)? array(): $values);

	$returned = "<div class='info info-error'>Error DATA </div>";

	$returned = '<div class="col_12" style="padding: 0">';

	$returned .= '	<div style="display: flex; flex-direction: row">';
	$returned .= '		<div style="flex: auto; padding: 15px 0 10px 5px; margin: 0; color: rgba(118,17,18,1.00)">';
	$returned .= '			Total : ('.count($values).' / '.$totalItems.') <span class="current hide">'.$_POST['data']['current'].'</span>';
	$returned .= '		</div>';
	$returned .= '		<div style="width: 10rem">';
	$returned .= '		<div style="flex-direction: row; display: flex">';
	$returned .= '			<div style="flex: 1">';
	$returned .= '				<select id="showPerPage">';
	$returned .= '					<option value="20" ' . ( $p_p == 20 ? "selected" : "") .'>20</option>';
	$returned .= '					<option value="50" ' . ( $p_p == 50 ? "selected" : "") .'>50</option>';
	$returned .= '					<option value="100" ' . ( $p_p == 100 ? "selected" : "") .'>100</option>';
	$returned .= '					<option value="200" ' . ( $p_p == 200 ? "selected" : "") .'>200</option>';
	$returned .= '					<option value="500" ' . ( $p_p == 500 ? "selected" : "") .'>500</option>';
	$returned .= '				</select>';
	$returned .= '					<span class="hide ' . $order . '" id="sort_by">'.$sort_by.'</span>';
	$returned .= '			</div>';
	$returned .= '			<div style="flex: 1; text-align: center">';
	$returned .= '				<div class="btn-group">';
	$returned .= '					<a style="padding: 12px 12px" id="btn_passive_preview"  title="Précédent"><i class="fa fa-chevron-left"></i></a>';
	$returned .= '					<a style="padding: 12px 12px" id="btn_passive_next" title="Suivant"><i class="fa fa-chevron-right"></i></a>';
	$returned .= '				</div>';
	$returned .= '			</div>';
	$returned .= '		</div>';
	$returned .= '		</div>';
	$returned .= '	</div>';	

	$returned .= '	<div class="panel" style="overflow: auto;">';
	$returned .= '		<div class="panel-content" style="padding: 0">';

	$returned .= '			<table class="table">';
	$returned .= '				<thead>';
	$returned .= '					<tr>';

	$columns = $ob->getColumns();

	$remove_sort = array("options", "actions");
	
	foreach($columns as $key=>$value){

		$style = ""; 
		$is_sort = ( in_array($value["column"], $remove_sort) )? "" : "sort_by";
		$is_display = ( isset($value["display"]) )? "hide" : "";
		if( $value["column"] === "actions" ){
			if($_SESSION["AGRAOUI-MANAGER"]["USER"]["id_profil"] === "1"){
				$returned .= "<th class='".$is_sort. " ". $is_display . "' data-sort='" . $value['column'] . "' style='".$style."'>" . $value['label'] . "</th>";
			}
		}else{
			$returned .= "<th class='".$is_sort. " ". $is_display . "' data-sort='" . $value['column'] . "' style='".$style."'>" . $value['label'] . "</th>";
		}
			
		

	}
		
	$returned .= '					</tr>';
	$returned .= '				</thead>';
	$returned .= '				<tbody>';


	$content = '<div class="info info-success"><div class="info-success-icon"><i class="fa fa-info" aria-hidden="true"></i> </div><div class="info-message">Liste vide ...</div></div>';
	$i = 0;
	foreach($values as $k=>$v){
		
		$returned .= '					<tr class="" data-page="'.$table_name.'">';
								foreach($columns as $key=>$value){
									
									$style = (isset($columns[$key]["style"]))? $columns[$key]["style"]:"";
									
									if(isset($v[ $columns[$key]["column"] ])){

										if($columns[$key]["column"] == "id"){
											$returned .= "<td style='".$style."'><span class='id-ligne'>" . $v[ $columns[$key]["column"] ] . "</span></td>";
										}elseif($columns[$key]["column"] == "activity_message"){
											$returned .= "<td style='".$style."'><span style='font-size:10px; color:red; font-weight:bold'>" . $v["first_name"] . "</span> " . $v[ $columns[$key]["column"] ] . "</td>";
										}else{

											$returned .= "<td style='".$style."'>" . $v[ $columns[$key]["column"] ] . "</td>";
										}											
									}else{
										if($columns[$key]["column"] == "actions"){
											if($_SESSION["AGRAOUI-MANAGER"]["USER"]["id_profil"] === "1"){
											$returned .=   "<td style='".$style."'><button style='margin-right:10px; padding:3px 10px' data-page='".$table_name."' class='btn btn-red remove_ligne' value='".$v["id"]."'><i class='fas fa-trash-alt'></i></button></td>";	
											}
										}else{
											$returned .=  "<td style='".$style."'>NaN</td>";
										}

									}


								}
		$returned .= '					</tr>';
	$i++	;
	}
	if($i == 0){
		$returned .= "<tr><td colspan='" . (count($columns)+1) . "'>".$content."</td></tr>";
	}


	$returned .= '				</tbody>';
	$returned .= '			</table>';
	$returned .= '		</div>';
	$returned .= '	</div">';
	$returned .= '</div>';
	echo $returned;
}else{
	echo -1;
}
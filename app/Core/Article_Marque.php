<?php
require_once('Helpers/Modal.php');

class Article_Marque extends Modal{

	private $columns = array(
		array("column" => "id", "label"=>"#ID", "style"=>"display:none", "display"=>0),
		array("column" => "created", "label"=>"CREATION", "style"=>"display:none", "display"=>0),
		array("column" => "article_marque", "label"=>"MARQUE (fr)", "style"=>"min-width:125px;font-weight:bold"),
		array("column" => "total", "format"=>"money", "label"=>"TOTAL", "style"=>"min-width:105px; width:100px; text-align:right; color:#E91E63; font-size:14px;background-color:rgba(255,0,0,0.2)"),
		array("column" => "status", "label"=>"STATUS", "style"=>"min-width:80px; width:80px"),
		array("column" => "actions", "label"=>"", "style"=>"min-width:105px; width:105px")
	);
	
	private $tableName = "Article_Marque";
	
// construct
	public function __construct(){
		try{
			parent::__construct();
			$this->setTableName(strtolower($this->tableName));
		}catch(Exception $e){
			die($e->getMessage());
		}
	}	
	
		
	public function getColumns(){
		
		if ( isset($this->columns) ){
			return $this->columns;
		}else{
			$columns = array();
			//var_dump($this->getColumnsName("client"));
			foreach($this->getColumnsName(strtolower($this->tableName)) as $k=>$v){
				//var_dump($v["Field"]);
				array_push($columns, array("column" => $v["Field"], "label" => $v["Field"]) );
			}
			array_push($columns, array("column" => "actions", "label" => "", "style"=>"min-width:105px; width:105px") );
			return $columns;
		}
		
	}
	
	
	public function drawTable($args = null, $conditions = null, $useTableName = null){

		$showPerPage = array("20","50","100","200","500","1000");
		$status = array("<div class='label label-red'>Désactivé</div>", "<div class='label label-green'>Activé</div>");
		$remove_sort = array("actions","nbr");
		
		
		$p_p = (isset($args['p_p']))? $args['p_p']: $showPerPage[0];
		$current = (isset($args['current']))? $args['current']: 0;
		$sort_by = (isset($args['sort_by']))? $args['sort_by']: "article_marque";
		$temp = explode(" ", $sort_by );
		$style = (isset($args['style']))? $args['style']: "list";
		
		$order = "";
		if(count( $temp ) > 1 ){ $order =  $temp[1]; }
		
		$values = array("Error : " . $this->tableName);
		$t_n = ($useTableName===null)? strtolower($this->tableName): $useTableName;
		
		if($conditions === null){
			$values = $this->find(null,array("order"=>$sort_by,"limit"=>array($current*$p_p,$p_p)),$t_n);
			$totalItems = $this->getTotalItems();
		}else{
			$conditions["order"] = $sort_by;
			$totalItems = count($this->find(null,$conditions,$t_n));
			$conditions["limit"] = array($current*$p_p,$p_p);
			$values = $this->find(null,$conditions,$t_n);
		}
		
		$returned = '<div class="col_12" style="padding: 0">';
	
		$returned .= '	<div style="display: flex; flex-direction: row">';
		$returned .= '		<div style="flex: auto; padding: 15px 0 10px 5px; margin: 0; color: rgba(118,17,18,1.00)">';
		$returned .= '			Total : ('.count($values).' / '.$totalItems.') <span class="current hide">'.$current.'</span>';
		$returned .= '		</div>';
		$returned .= '		<div style="width: 20rem">';
		$returned .= '		<div style="flex-direction: row; display: flex">';
		$returned .= '			<div style="flex: 1">';
		$returned .= '				<select id="showPerPage">';
		
		foreach($showPerPage as $kk => $vv)
			$returned .= '				<option value="'.$vv.'" ' . ( $p_p == $vv ? "selected" : "") .'>'.$vv.'</option>';
		
		
		$returned .= '				</select>';
		$returned .= '					<span class="hide ' . $order . '" id="sort_by">'.$sort_by.'</span>';
		$returned .= '			</div>';
		
		$returned .= '			<div style="flex: 1; text-align: center">';
		$returned .= '				<div class="btn-group">';
		$returned .= '					<a style="padding: 12px 12px" id="btn_passive_preview"  title="Précédent"><i class="fa fa-chevron-left"></i></a>';
		$returned .= '					<a style="padding: 12px 12px" id="btn_passive_next" title="Suivant"><i class="fa fa-chevron-right"></i></a>';
		$returned .= '				</div>';
		$returned .= '			</div>';
		
		$returned .= '			<div style="flex: 1; text-align: center">';
		$returned .= '				<div class="btn-group-radio style">';
		if($style === "list"){
		$returned .= '					<button class="btn btn-default checked" value="list" style="padding:9px 15px; font-size:18px"><i class="fas fa-list"></i></button>';
		$returned .= '					<button class="btn btn-default" value="grid" style="padding:9px 15px; font-size:18px"><i class="fas fa-th"></i></button>';			
		}else{
		$returned .= '					<button class="btn btn-default" value="list" style="padding:9px 15px; font-size:18px"><i class="fas fa-list"></i></button>';
		$returned .= '					<button class="btn btn-default checked" value="grid" style="padding:9px 15px; font-size:18px"><i class="fas fa-th"></i></button>';				
		}

		$returned .= '				</div>';
		$returned .= '			</div>';
		
		$returned .= '		</div>';
		$returned .= '		</div>';
		$returned .= '	</div>';	
	
		$returned .= '	<div class="panel" style="overflow: auto;">';
		$returned .= '		<div class="panel-content" style="padding: 0 0 25px 0">';
		
		
		if($style === "list"){
			$returned .= '			<table class="table">';
			$returned .= '				<thead>';
			$returned .= '					<tr>';

			$columns = $this->getColumns();



			foreach($columns as $key=>$value){

				$style = ""; 
				$is_sort = ( in_array($value["column"], $remove_sort) )? "" : "sort_by";
				$is_display = ( isset($value["display"]) )? "hide" : "";
				if($is_sort === ""){
					$returned .= "<th class='".$is_sort. " ". $is_display . "' data-sort='" . $value['column'] . "'> " . $value['label'] . "</th>";
				}else{
					$returned .= "<th class='".$is_sort. " ". $is_display . "' data-sort='" . $value['column'] . "'> <i class='fas fa-sort'></i> " . $value['label'] . "</th>";
				}


			}
			$returned .= '					</tr>';
			$returned .= '				</thead>';
			$returned .= '				<tbody>';


			$content = '<div class="info info-success"><div class="info-success-icon"><i class="fa fa-info" aria-hidden="true"></i> </div><div class="info-message">Liste vide ...</div></div>';
			$i = 0;

			$t = explode("_",$this->tableName);
			$_t = "";
			foreach ($t as $k=>$v){
				$_t .= ($_t==="")? ucfirst($v): "_".ucfirst($v) ;
			}

			foreach($values as $k=>$v){
				$returned .= '					<tr class="edit_ligne" data-page="'.$_t.'">';
				foreach($columns as $key=>$value){

					$style = (isset($columns[$key]["style"]))? $columns[$key]["style"]:"";

					if(isset($v[ $columns[$key]["column"] ])){
						if($columns[$key]["column"] == "id"){
							$returned .= "<td style='".$style."'><span class='id-ligne'>" . $v[ $columns[$key]["column"] ] . "</span></td>";
						}elseif($columns[$key]["column"] == "article_marque"){
							$returned .= "<td style='".$style."'>".$v["article_marque"] . "<br>".$v["article_marque_ar"] . "</td>";
						}elseif($columns[$key]["column"] == "status"){
							if($v["status"]){
								$returned .= "<td style='".$style."'><span class='label label-green'>Activé</span></td>";
							}else{
								$returned .= "<td style='".$style."'><span class='label label-red'>Désactivé</span></td>";
							}
							
						}else{

							if(isset($columns[$key]["format"])){
								if($columns[$key]["format"] == "money"){
									$returned .= "<td style='".$style."'>" . $this->format( $v[ $columns[$key]["column"] ] ) . "</td>";
								}else{
									$returned .= "<td style='".$style."'>" . $v[ $columns[$key]["column"] ] . "</td>";
								}
							}else{
								$returned .= "<td style='".$style."'>" . $v[ $columns[$key]["column"] ] . "</td>";
							}

						}											
					}else{
						if($columns[$key]["column"] == "actions"){
							$returned .=   "<td style='".$style."'><button style='margin-right:10px' data-page='".$_t."' class='btn btn-red remove_ligne' value='".$v["id"]."'><i class='fas fa-trash-alt'></i></button><button data-page='".$_t."' class='btn btn-orange edit_ligne' value='".$v["id"]."'><i class='fas fa-edit'></i></button></td>";												
						}elseif($columns[$key]["column"] == "nbr"){
							$returned .=  "<td style='".$style."'>0</td>";
						}else{
							$returned .=  "<td style='".$style."'></td>";
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
			
		}else{
			
			$content = '<div class="info info-success"><div class="info-success-icon"><i class="fa fa-info" aria-hidden="true"></i> </div><div class="info-message">Liste vide ...</div></div>';
			$i = 0;

			$t = explode("_",$this->tableName);
			$_t = "";
			foreach ($t as $k=>$v){
				$_t .= ($_t==="")? ucfirst($v): "_".ucfirst($v) ;
			}
			
			foreach($values as $k=>$v){
				$returned .= "<div style='position:relative; width:180px; height:180px; margin:5px; display:inline-block; background-color:rgba(220,220,220,0.5); border:1px solid #C0C0C0; border-radius:7px'>" . $this->get_files("marque", (is_null($v["UID"]))? "a": ($v["UID"] === "")? "a": $v["UID"],array("id"=>$v["id"])) . "<span class='label label-red' style='position:absolute; top:10px; left:10px'>".$v["article_marque"] . "</span></div>";
			}
			
		}
		
		
		$returned .= '		</div>';
		$returned .= '	</div">';
		$returned .= '</div>';
		echo $returned;

	}

	public function get_files($folder = "", $name = "", $args = null){
		$statics = $_SESSION["STATICS"];
		$upload_folder = $_SESSION["UPLOAD_FOLDER"];

		$dS = DIRECTORY_SEPARATOR;

		$filesDirectory = $upload_folder.$folder.$dS.$name.$dS;
		
		$images = "";
		if(file_exists($filesDirectory)){
			

			foreach(scandir($filesDirectory) as $k=>$v){

				if($v <> "." and $v <> ".." and strpos($v, '.') !== false){
					$images .= "<div style='display:inline-block; margin:5px; text-align:center'>";
					$images .= "<img class='' style='width:100%; height:auto; display:block' src='http://".$statics.$folder."/".$name."/".$v."'>";	
					$images .= "<button data-page='Article_Marque' class='btn btn-orange edit_ligne' value='".$args["id"]."'><i class='fas fa-edit'></i></button>";
					$images .= "</div>";
					//$nbr++;
				}

			}	
			//echo $images;
		}else{
			$images .= "<div style='display:inline-block; margin:5px; text-align:center'>";
			$images .= "<img class='' style='width:100%; height:auto; display:block' src='http://".$statics."/creative_0.png'>";	
			$images .= "<button data-page='Article_Marque' class='btn btn-orange edit_ligne' value='".$args["id"]."'><i class='fas fa-edit'></i></button>";
			$images .= "</div>";
		}
		
		
		return $images;
		
	}
	
	
	
}

$article_marque = new Article_Marque;
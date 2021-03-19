<?php
require_once('Helpers/Modal.php');

class Article_Tarif_Vente extends Modal{

	private $columns = array(
		array("column" => "id", "label"=>"#ID", "style"=>"display:none", "display"=>0),
		array("column" => "article_tarif", "label"=>"TARIF", "style"=>"font-weight:bold"),
		array("column" => "montant", "format"=>"money", "label"=>"MONTANT", "style"=>"font-weight:bold; background-color:rgba(217, 247, 69,0.5); width:105px; text-align:right; color:#191919"),
		array("column" => "is_default", "label"=>"DEFAULT", "style"=>"min-width:80px; width:80px"),
		array("column" => "status", "label"=>"STATUS", "style"=>"min-width:80px; width:80px; font-size:16px; font-weight:normal"),
		array("column" => "actions", "label"=>"", "style"=>"min-width:105px; width:105px")
	);
	
	private $tableName = "Article_Tarif_Vente";
	
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
		
		$values = $this->find(null,$conditions,"v_article_tarif_vente");
		$style = "";	
			
		$returned = '<div class="col_12" style="padding: 0">';	
	
		$returned .= '	<div class="panel" style="overflow: auto;">';
		$returned .= '		<div class="panel-content" style="padding: 0">';
		
		$returned .= '			<table class="table">';
		$returned .= '				<thead>';
		$returned .= '					<tr>';
		
		$columns = $this->getColumns();
	
		

		foreach($columns as $key=>$value){

			$style = ""; 
			$is_sort = "";
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
			$returned .= '					<tr class="edit_tarif_vente" data-page="'.$_t.'">';
			foreach($columns as $key=>$value){
				
				$style = (isset($columns[$key]["style"]))? $columns[$key]["style"]:"";
				
				if(isset($v[ $columns[$key]["column"] ])){
					if($columns[$key]["column"] == "is_default"){
						$returned .= ($v[ $columns[$key]["column"] ] == 0)? "<td style='".$style."'></td>": "<td style='".$style."; font-size:10px; color:green'> <i class='fas fa-check'></i> <span>Par Défaut</span></td>";
					}elseif($columns[$key]["column"] == "id"){
						$returned .= "<td style='".$style."'><span class='id-ligne'>" . $v[ $columns[$key]["column"] ] . "</span></td>";
					}elseif($columns[$key]["column"] == "status"){
						if($v["status"] === "1"){
							$returned .= "<td style='".$style."'><span class='label label-green'>Activé</span></td>";
						}else{
							$returned .= "<td style='".$style."'><span class='label label-red'>Désactivé</span></td>";
						}
						
					}elseif($columns[$key]["column"] == "first_name"){
								
						if($v["notes"] !== "" and isset($v["notes"])){
							$returned .= "<td style='".$style."'>" . $v["first_name"] . " " . $v["last_name"] . " <span style='color:blue; font-size:12px'><i class='fas fa-info-circle'></i></span></td>";
						}else{
							$returned .= "<td style='".$style."'>" . $v["first_name"] . " " . $v["last_name"] . "</td>";
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
						$returned .=   "<td style='".$style."'><button style='margin-right:10px' data-page='".$_t."' class='btn btn-red remove_ligne tarif_vente' value='".$v["id"]."'><i class='fas fa-trash-alt'></i></button><button data-page='".$_t."' class='btn btn-orange edit_tarif_vente' value='".$v["id"]."'><i class='fas fa-edit'></i></button></td>";												
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

		$returned .= '		</div>';
		$returned .= '	</div">';
		$returned .= '</div>';
		echo $returned;

	}

	
}

$article_tarif_vente = new Article_Tarif_Vente;
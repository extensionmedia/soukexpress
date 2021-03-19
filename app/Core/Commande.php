<?php
require_once('Helpers/Modal.php');

class Commande extends Modal{

	private $columns = array(
		array("column" => "id", "label"=>"#ID", "style"=>"display:none", "display"=>0),
		array("column" => "commande_numero", "label"=>"N°", "style"=>"font-weight:bold; min-width:80px; width:80px; "),
		array("column" => "created", "label"=>"DATE", "style"=>"min-width:80px; width:80px; "),
		array("column" => "client_name", "label"=>"CLIENT", "style"=>"font-weight:bold"),
		array("column" => "client_telephone", "label"=>"PHONE", "style"=>""),
		array("column" => "nbr_produits", "label"=>"ARTICLES", "style"=>"min-width:90px; width:90px; font-size:18px; font-weight:bold; text-align:center"),
		array("column" => "total_commande", "label"=>"TOTAL", "style"=>"min-width:110px; width:110px; background-color:#FFE4B5; color:black; font-weight:bold; border-bottom:#9E9E9E 1px solid; text-align:right"),
		array("column" => "actions", "label"=>"", "style"=>"min-width:105px; width:105px")
	);
	
	private $tableName = "Commande";
	
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
		$sort_by = (isset($args['sort_by']))? $args['sort_by']: "created";
		$temp = explode(" ", $sort_by );
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
		$returned .= '			المجموع : ('.count($values).' / '.$totalItems.') <span class="current hide">'.$current.'</span>';
		$returned .= '		</div>';
		$returned .= '		<div style="width: 10rem">';
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
		$returned .= '		</div>';
		$returned .= '		</div>';
		$returned .= '	</div>';	
	
		$returned .= '	<div class="panel" style="overflow: auto;">';
		$returned .= '		<div class="panel-content" style="padding: 0">';
		
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
			
			$bg = 'background-color:' . $v["color"];
			
			$returned .= '					<tr style="'.$bg.'" class="edit_ligne" data-page="'.$_t.'">';
			foreach($columns as $key=>$value){
				
				$style = (isset($columns[$key]["style"]))? $columns[$key]["style"]:"";
				
				if(isset($v[ $columns[$key]["column"] ])){
					if($columns[$key]["column"] == "total_commande"){
						$returned .= "<td style='".$style."'>" . $this->format($v["total_commande"]) . "</td>";
					}elseif($columns[$key]["column"] == "id"){
						$returned .= "<td style='".$style."'><span class='id-ligne'>" . $v[ $columns[$key]["column"] ] . "</span></td>";
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
		$returned .= '		</div>';
		$returned .= '	</div">';
		$returned .= '</div>';
		echo $returned;

	}
	
	public function Get_Commande_Details($params){
		$cmd = $this->find('', [ 'conditions'=>['id_commande='=>$params['id_commande']] ], 'v_commande_detail');
		
		$table = '
			<table style="width:100%">
				<thead>
					<tr style="background-color:rgba(82,82,82,1)">
						<th style="padding:5px 3px">CODE</th>
						<th>LIBELLE</th>
						<th style="text-align:center">QTE</th>
						<th style="text-align:right">PU</th>
						<th style="text-align:right">TOTAL</th>
					</tr>
				</thead>
				<tbody style="max-height:250px; overflow:hidden">
					{{trs}}
				</tbody>
			</table>
		';
		
		$trs = '';
		
		foreach($cmd as $k=>$v){
			$trs .= '
					<tr>
						<td>'.$v["code"].'</td>
						<td>'.$v["libelle_fr"].'</td>
						<td style="font-size:14px; text-align:center; color:blue">'. $v["qte"].'</td>
						<td style="font-size:12px; text-align:right">'. $this->format($v["pu"]).'</td>
						<td style="font-size:12px; text-align:right; color:blue">'. $this->format($v["pu"] * $v["qte"]).'</td>
					</tr>
					';
		}
		
		return str_replace("{{trs}}", $trs, $table);
		
	}
}

$commande = new Commande;
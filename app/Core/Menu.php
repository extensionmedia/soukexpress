<?php
require_once('Helpers/Modal.php');

class Menu extends Modal{

	private $columns = array(
		array("column" => "id", "label"=>"#ID"),
		array("column" => "libelle", "label"=>"LIBELLE"),
		array("column" => "url", "label"=>"URL"),
		array("column" => "icon", "label"=>"ICON"),
		array("column" => "parent", "label"=>"PARENT"),
		array("column" => "_order", "label"=>"ORDRE"),
		array("column" => "status", "label"=>"STATUS")
	);
	
// construct
	public function __construct(){
		try{
			parent::__construct();
			$this->setTableName("manager_links");
		}catch(Exception $e){
			$this->err->save("Template -> Constructeur","$e->getMessage()");
		}
	}	
	
		
	public function getColumns(){
		
		if ( isset($this->columns) ){
			return $this->columns;
		}else{
			$columns = array();
			//var_dump($this->getColumnsName("client"));
			foreach($this->getColumnsName("manager_links") as $k=>$v){
				//var_dump($v["Field"]);
				array_push($columns, array("column" => $v["Field"], "label" => $v["Field"]) );
			}
			return $columns;
		}
		
	}
	
	public function editOrder($id, $up_or_down, $id_preview, $id_next, $current_order){
		
		
		
		$this->id = $id;
		$m = $this->read();
		if($up_or_down==="UP"){
			$this->save(array(
				"id"		=>	$id,
				"_order"	=>	$current_order-1
			));
			
			$this->save(array(
				"id"		=>	$id_preview,
				"_order"	=>	$current_order
			));
			
		}else{
			$this->save(array(
				"id"		=>	$id,
				"_order"	=>	$current_order+1
			));
			
			$this->save(array(
				"id"		=>	$id_next,
				"_order"	=>	$current_order
			));
		}
		return 1;
	}
	
	public function drawTable_2(){
		
		$i = 0;
		$m = $this->find(null,array("conditions"=>array("id_parent="=>0), "order"=>"_order"),"v_link");
		$i_count = count($m);		
		
		$returned = '	<div class="col_12">';
		$returned .= '		<ul class="unstyle">';
		
		foreach ($m as $k=>$v){
			$status = ($v["status"])? "<div class='label label-green'>Activé</div>": "<div class='label label-red'>Désactivé</div>";
			$returned .= '		<li>';
			$returned .= '			<a href="#menu" class="__menu">';
			$returned .= '				<div class="icon">' . $v["icon"] . '</div>';
			$returned .= '				<div>'.$v["_order"].' '.$v["libelle"].' '. $status. '</div>';
			$returned .= '				<div class="" style="text-align: right">';
			$returned .= '					<div class="btn-group" style="margin: 0; padding: 0;">';

			if($i > 0){
				$next = ($i === $i_count-1)? 0: $m[$i+1]["id"];
				$returned .= '					<button class="btn up order" data-order="'.$i.'" data-id-n="'.$next.'" data-id-p="'.$m[$i-1]["id"].'" data-id="'.$v["id"].'"><i class="fas fa-chevron-up"></i></button>';
			}
			if($i < $i_count-1){
				$preview = ($i===0)? 0: $m[$i-1]["id"];
				$returned .= '					<button class="btn down order" data-order="'.$i.'" data-id-n="'.$m[$i+1]["id"].'" data-id-p="'.$preview.'" data-id="'.$v["id"].'"><i class="fas fa-chevron-down"></i></button>';
			}
			
			$returned .= "						<button class='btn btn-red remove_ligne' value='".$v["id"] ."' data-page='Menu'  data-id='".$v["id"]."'><i class='fas fa-trash-alt'></i></button>";
			$returned .= "						<button class='btn btn-green edit_ligne' value='".$v["id"]."' data-page='Menu' data-id='".$v["id"]."'><i class='far fa-edit'></i></button>";
			$returned .= '					</div>';
			$returned .= '				</div>';
			$returned .= '			</a>';
			
			
			$returned .= '			<ul class="unstyle">';
			$data = $this->find(null,array("conditions AND"=>array("id_parent="=>$v["id"]), "order"=>"_order"),null);
			$j = 0;
			$j_count = count($data);
			
			foreach ($data as $kk=>$vv){
				
				$_status = ($vv["status"])? "<div class='label label-green'><i class='fas fa-minus'></i></div>": "<div class='label label-red'><i class='fas fa-minus'></i></div>";
				
				$returned .= '		<li>';
				$returned .= '			<a href="#menu" class="__sub">';
				$returned .= '				<div class="icon">' .$_status. '</div>';
				$returned .= '				<div>'.$vv["libelle"].'</div>';
				$returned .= '				<div class="" style="text-align: right">';
				$returned .= '					<div class="btn-group" style="margin: 0; padding: 0;">';

				if($j > 0){
					$next = ($j === $j_count-1)? 0: $data[$j+1]["id"];
					$returned .= '					<button class="btn up order" data-order="'.$j.'" data-id-n="'.$next.'" data-id-p="'.$data[$j-1]["id"].'" data-id="'.$vv["id"].'"><i class="fas fa-chevron-up"></i></button>';
				}
				if($j < $j_count-1){
					$preview = ($j===0)? 0: $data[$j-1]["id"];
					$returned .= '					<button class="btn down order" data-order="'.$j.'" data-id-n="'.$data[$j+1]["id"].'" data-id-p="'.$preview.'" data-id="'.$vv["id"].'"><i class="fas fa-chevron-down"></i></button>';
				}

				$returned .= "						<button class='btn btn-red remove_ligne' value='".$vv["id"] ."' data-page='Menu'  data-id='".$vv["id"]."'><i class='fas fa-trash-alt'></i></button>";
				$returned .= "						<button class='btn btn-green edit_ligne' value='".$vv["id"]."' data-page='Menu' data-id='".$vv["id"]."'><i class='far fa-edit'></i></button>";
				$returned .= '					</div>';
				$returned .= '				</div>';


				$returned .= '			</a>';
				$returned .= '		</li>';
				$j++;
			}		



			$returned .= '		</ul>';
			
			
			
			
			$returned .= '		</li>';
			$i++;
		}		
		
		
		
		$returned .= '		</ul>';
		$returned .= '	</div>';
		
		echo $returned;

		
	}
	
}
$links = new Menu;
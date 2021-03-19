<?php
require_once($_SESSION['CORE'].'Helpers/Modal.php');

class Apropos extends Modal{
	
	private $columnsd = array(
		array("column" => "id", "label"=>"#ID"),
		array("column" => "nom", "label"=>"NOM"),
		array("column" => "client_category", "label"=>"CATEGORIE"),
		array("column" => "telephone_01", "label"=>"Téléphone"),
		array("column" => "created", "label"=>"CREE LE"),
		array("column" => "is_default", "label"=>"PRINCIPAL")
	);
	
// construct
	public function __construct(){
		parent::__construct();
		$this->setTableName("apropos");
	}
	
	
	public function add($data){
			 

		$columns = array("id_status","id_list","link","element","UID");
		$isAllRight = true;
		
		foreach($columns as $k=>$v){
						
			if( !isset( $data[$v] ) ){
				$isAllRight = false;
			}
			
		}
		if($data['id'] == ''){
			unset($data['id']);
		}
		if($isAllRight){ 
			echo $this->save($data);
		}else{
			echo 0;
		}

	}
	
	public function getColumns(){
		
		if ( isset($this->columns) ){
			return $this->columns;
		}else{
			$columns = array();
			//var_dump($this->getColumnsName("client"));
			foreach($this->getColumnsName("apropos") as $k=>$v){
				//var_dump($v["Field"]);
				array_push($columns, array("column" => $v["Field"], "label" => $v["Field"]) );
			}
			return $columns;
		}
		
	}
}
$apropos = new Apropos;
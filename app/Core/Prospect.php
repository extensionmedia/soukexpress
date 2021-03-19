<?php
require_once('Helpers/Modal.php');

class Prospect extends Modal{

	private $columns = array(
		array("column" => "id", "label"=>"#ID", "style"=>"display:none", "display"=>0),
		array("column" => "first_name", "label"=>"CLIENT", "style"=>"font-weight:bold"),
		array("column" => "created", "label"=>"CREATION", "style"=>"min-width:80px; width:130px"),
		array("column" => "phone_1", "label"=>"PHONE", "style"=>"min-width:80px; width:130px"),
		array("column" => "email", "label"=>"EMAIL", "style"=>"min-width:80px; width:130px"),
		array("column" => "city", "label"=>"VILLE", "style"=>"min-width:80px; width:130px"),
		array("column" => "status", "label"=>"STATUS", "style"=>"min-width:80px; width:80px"),
		array("column" => "actions", "label"=>"", "style"=>"min-width:105px; width:105px")
	);
	
	private $tableName = "Prospect";
	
// construct
	public function __construct(){
		try{
			parent::__construct();
			$this->setTableName(strtolower($this->tableName));
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
			foreach($this->getColumnsName(strtolower($this->tableName)) as $k=>$v){
				//var_dump($v["Field"]);
				array_push($columns, array("column" => $v["Field"], "label" => $v["Field"]) );
			}
			return $columns;
		}
		
	}
	

}
$prospect = new Prospect;
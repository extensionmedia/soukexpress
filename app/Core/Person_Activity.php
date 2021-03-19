<?php
require_once('Helpers/Modal.php');
class Person_Activity extends Modal{

	private $columns = array(
		array("column" => "id", "label"=>"#ID", "style"=>"display:none", "display"=>0),
		array("column" => "created", "label"=>"DATE"),
		array("column" => "activity_action", "label"=>"ACTION"),
		array("column" => "activity_message", "label"=>"DESCRIPTION"),
		array("column" => "activity_ip", "label"=>"LOCATION"),
		array("column" => "module", "label"=>"MODULE", "width"=>80),
		array("column" => "actions", "label"=>"", "style"=>"min-width:55px; width:55px")
	);
	
// construct
	public function __construct(){
		try{
			parent::__construct();
			$this->setTableName("person_activity");
		}catch(Exception $e){
			$this->err->save("person -> Constructeur",$e->getMessage());
		}
	}	
	
	
	public function getColumns(){
		
		if ( isset($this->columns) ){
			return $this->columns;
		}else{
			$columns = array();
			//var_dump($this->getColumnsName("client"));
			foreach($this->getColumnsName("person_activity") as $k=>$v){
				//var_dump($v["Field"]);
				array_push($columns, array("column" => $v["Field"], "label" => $v["Field"]) );
			}
			return $columns;
		}
		
	}

	
}
$person_activity = new Person_Activity;


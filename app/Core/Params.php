<?php
require_once($_SESSION['CORE'].'Helpers/Modal.php');

class Params extends Modal{
	
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
		$this->setTableName("params");
	}
	
	
	public function getColumns(){
		
		if ( isset($this->columns) ){
			return $this->columns;
		}else{
			$columns = array();
			//var_dump($this->getColumnsName("client"));
			foreach($this->getColumnsName("params") as $k=>$v){
				//var_dump($v["Field"]);
				array_push($columns, array("column" => $v["Field"], "label" => $v["Field"]) );
			}
			return $columns;
		}
		
	}
	
	public function getMessageFromWhatsapp($args = null){
		
		$data = $this->fetchAll();
		$link = str_replace("message","messages",$data[0]["api_whatsapp"]) ;
		
		$linkSuf = "";
		
		if($args == null){
			$link .= "&last";
		}else{
			if(isset($args["lastMessageNumber"])){
				$link .= "&lastMessageNumber=".$args["lastMessageNumber"];
			}
		}
		
		
		
		$result = json_decode(file_get_contents($link),1);
		$messages = $result["messages"];
		
		if(isset($args["fromMe"])){
			for($i=1; $i<count($messages);$i++){
				if($messages[$i]["fromMe"] !== $args["fromMe"]){
					unset ($messages[$i]);
				}
			}
		}
		

		
		return $messages;
		
	}
	
	
}
$params = new Params;
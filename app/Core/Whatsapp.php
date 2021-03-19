<?php
require_once($_SESSION['CORE'].'Helpers/Modal.php');

class Whatsapp extends Modal{
	private $token;
	private $defaultPhone = "212661098984";
	private $defaultMsg = "Default message from Whatsapp Class!";
	private $defaultImageLink = "https://upload.wikimedia.org/wikipedia/ru/3/33/NatureCover2001.jpg";
	private $defaultImageName = "Cover.jpg";
	
	private $columns = array(
		array("column" => "messageNumber", "label"=>"Msg. N°"),
		array("column" => "body", "label"=>"MESSAGE"),
		array("column" => "fromMe", "label"=>"FROM Me"),
		array("column" => "author", "label"=>"SENDER ID"),
		array("column" => "time", "label"=>"DATE"),
		array("column" => "type", "label"=>"TYPE"),
		array("column" => "senderName", "label"=>"SENDER NAME")
	);

	
// construct
	public function __construct(){
		parent::__construct();
		$this->setTableName("params");
		
		$data = $this->fetchAll();
		$this->token = $data[0]["api_whatsapp"];
		
	}
	
	public function checkStatus(){
		
		$url = str_replace("message","status", $this->token);
		return($this->execute($url));
		
	}
	
	public function sendMessage($phone = null, $msg = null){
		
		if($phone === null) $phone = $this->defaultPhone;
		if($msg === null) $msg = $this->defaultMsg;
		
		$data = [
			'phone' =>	$phone,
			"body"=>	$msg
		];

		return($this->execute($this->token, $data));		
		
	}
	
	public function sendFile($phone = null, $msg = null, $filename = null){
		
		if($phone === null) $phone = $this->defaultPhone;
		if($msg === null) $msg = $this->defaultImageLink;
		if($filename === null) $filename = $this->defaultImageName;
		
		$data = [
			'phone' 	=>	$phone,
			"body"		=>	$msg,
			"filename"	=>	$filename
		];
		$url = str_replace("message","sendFile", $this->token);
		return($this->execute($url, $data));	
		
	}
	
	
	
	public function getLast($lastMessageNumber=null, $conditions=null){
		
		$url = str_replace("message","messages", $this->token);
		$messages = "";
		
		if($lastMessageNumber == null){
			$url .= "&last";
		}else{
			$url .= "&lastMessageNumber=".$lastMessageNumber;
		}
		
		$messages = $this->execute($url);
		
		if($conditions !== null){
			if(is_array($conditions)){
				foreach($conditions as $k=>$v){
					foreach($messages["messages"] as $key=>$value){
						
						if($value[$k] !== $v){
							
							unset ($messages["messages"][$key]);
							
						}						
					}
				}
			}
		}
		
		return $messages;
		
	}

	public function execute($url, $data=null){
		
		if($data !== null){
			$json = json_encode($data);
			
			$options = stream_context_create(['http' => [
					'method'  => 'POST',
					'header'  => 'Content-type: application/json',
					'content' => $json
				]
			]);
			return json_decode(file_get_contents($url, false, $options),1);				
		}else{
			return json_decode(file_get_contents($url),1);	
		}
	
		
	}
	
	public function drawTable(){
		
		$columns = $this->columns;
		
		$returned = '<table class="table">';
		$returned .= '	<thead>';
		$returned .= '		<tr>';
		
		$remove_sort = array("solde", "actions");
		
		foreach($columns as $key=>$value){

			$style = ""; 
			$is_sort = ( in_array($value["column"], $remove_sort) )? "" : "sort_by";
			$is_display = ( isset($value["display"]) )? "hide" : "";

			$returned .= "<th class='".$is_sort. " ". $is_display . "' data-sort='" . $value['column'] . "'>" . $value['label'] . "</th>";

		}
		$returned .= '		</tr>';
		$returned .= '	</thead>';
		$returned .= '<tbody>';
		
		$content = '<div class="info info-success"><div class="info-success-icon"><i class="fa fa-info" aria-hidden="true"></i> </div><div class="info-message">Liste vide ...</div></div>';
		$i = 0;
		/*
		array("author"=>"212661098984@c.us")
		array("type"=>"image")
		*/
		$messages = $this->getLast(null, array("type"=>"chat"));
		$_messages = $messages["messages"];
		$this->aasort($_messages,"time", SORT_DESC);
		
		//$_messages = $messages["messages"];
		foreach($_messages as $k=>$v){
			$returned .= '	<tr>';
			foreach($columns as $key=>$value){
				if ($columns[$key]["column"] == "time"){
					$returned .= "<td>" . gmdate("Y-m-d H:i:s", $v['time']) . "</td>";
				}else{
					$returned .= "<td>" . $v[$columns[$key]["column"]] . "</td>";
				}
				
			}
			$returned .= '	</tr>';
		$i++	;
		}
	
		if($i == 0){
			$returned .= "<tr><td colspan='" . (count($columns)+1) . "'>".$content."</td></tr>";
		}
		
		return $returned;
		
	}
	
	public function aasort (&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
    	foreach ($arr as $key=> $row) {
        	$sort_col[$key] = $row[$col];
    	}

    	array_multisort($sort_col, $dir, $arr);
		
	}
}
$whatsapp = new Whatsapp;
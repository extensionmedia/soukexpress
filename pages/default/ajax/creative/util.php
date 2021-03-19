<?php session_start();

if(!isset($_SESSION['CORE'])){die();}
if(!isset($_POST['args'])){die();}



$core = $_SESSION['CORE'];
require_once($core."Whatsapp.php");


$action = $_POST["args"]["action"];

switch ($action){
		
	case "person":
		require_once($core."User.php");
		$id_category = $_POST["args"]["id_category"];
		//$conditions = array("conditions AND"=>array("id_user_category="=>$id_category,"reste > "=>-1));
		$conditions = array("conditions"=>array("id_user_category="=>$id_category));
		
		$columns = array(
			array("column" => "name", "label"=>"ABBONNE"),
			array("column" => "reste", "label"=>"JR(s)"),
			array("column" => "username", "label"=>"USERNAME"),
			array("column" => "nbr", "label"=>"SEND"),
		);
		
		$returned = '<table class="table">';
		$returned .= '	<thead>';
		$returned .= '		<tr>';
		
		foreach($columns as $key=>$value){
			if(isset($value["width"])){
				$returned .=  "<th style='width:" . $value["width"] . "'>" . $value["label"] . "</th>";
			}else{
				$returned .=  "<th>" . $value["label"] . "</th>";
			}
		}
		$returned .= '			<th style="width:105px; text-align:right"><button style="padding:2px 10px" class="btn btn-red send_whatsapp_pausse hide"><i class="fas fa-pause-circle"></i> Pauss</button><button style="padding:2px 10px" class="btn btn-green send_whatsapp_all"><i class="fas fa-play-circle"></i> Envoyé</button></th>';
		$returned .= '		</tr>';
		$returned .= '	</thead>';
		$returned .= '<tbody>';
		
		$values = $user->find("",$conditions,"v_user");
		
		$i=0;
		
		$doing = '<span class="is_doing hide"><i class="fas fa-sync fa-spin"></i> Sending</span> 
					<span class="do"><i class="fab fa-whatsapp"></i> </span>';
		
		
		foreach($values as $k=>$v){
			
			$color = "";
			if($v["reste"]<0){
				$color = "style='background-color:#FFCDD2'";
			}
			
			$returned .= '	<tr '.$color.' data="'.$v["id"].'">';
			$is_error = false;
			foreach($columns as $key=>$value){
				if($columns[$key]["column"] === "nbr"){
					$returned .= "<td><div style='font-size:14px; color:green; font-weight:bold; text-align:center'>0</div></td>";	
				}elseif($columns[$key]["column"] === "name"){
					$returned .= "<td>" . $v['first_name'] . " " . $v['last_name'] . "</td>";
				}elseif($columns[$key]["column"] === "username"){
					if(strlen($v[ $columns[$key]["column"] ]) === 12 || strlen($v[ $columns[$key]["column"] ]) === 11 ){
						$returned .= "<td>" . $v[ $columns[$key]["column"] ] . "</td>";
					}else{
						$returned .= "<td><span style='border:1px red solid; padding:3px 5px; color:red'>" . $v[ $columns[$key]["column"] ] . "</span></td>";
						$is_error = true;
						
					}
					
				}else{
					$returned .= "<td>" . $v[ $columns[$key]["column"] ] . "</td>";
				}
								
			}	
			if(!$is_error){
				if($color == ""){
					$returned .= "	<td style='text-align:right'><button style='padding:2px 10px' class='btn btn-green creative_send not_sent' value='".$v["username"]."'>".$doing."</button></td>";
				}else{
					$returned .= "	<td style='text-align:center'><div class='label label-red'>Expiré!</div></td>";
				}
			}else{
				$returned .= "	<td style='text-align:right'></td>";
			}
			
			$returned .= '	</tr>';
			$i++;
		}
		if($i==0){
			$returned .= '<tr><td colspan="' . (count($columns) + 1) . '">';
			$returned .= '<div class="info info-success"><div class="info-success-icon"><i class="fa fa-info" aria-hidden="true"></i> </div><div class="info-message">Liste vide ...</div></div>';
			$returned . '</td></tr>';
		}
		$returned .= '</tbody>';	
		$returned .= '</table>';
		
		echo str_replace("{i}","<span style='font-size:10px'>".$i . " Selected</span>",$returned);
		
		break;

	case "send":
		$phones = explode(";", $_POST["args"]["data"]["items"]);
		$msg = $_POST["args"]["data"]["msg"];
		$type = $_POST["args"]["data"]["type"]; 

		$success = array();
		$error = array();
		//https://eu18.chat-api.com/instance19822/message?token=zomphfcfmt4ek13g
		//https://eu4.chat-api.com/instance19847/message?token=r5i1f6fo1d8inbis (new one)
		for($i=0; $i < count($phones); $i++){
			if($type === "chat"){
				$result = $whatsapp->sendMessage($phones[$i], $msg);
			}elseif($type === "file"){
				$result = $whatsapp->sendFile($phones[$i], $msg);
			}
			//var_dump($_POST["args"]["data"]);
			//$result = $whatsapp->sendMessage($phones[$i], $msg);
			//$result = $whatsapp->sendFile($phones[$i], $msg);
			//$result = $whatsapp->checkStatus($phones[$i], $msg);
			//var_dump($result);
			
			
			if($result["sent"]){
				echo "1";
				//$success[$phones[$i]] = $result["message"];
			}else{
				echo "0";
				//$error[$phones[$i]] = $result["message"];
			}
			
		}
		/*
		echo "--- SUCCESS ---";
		var_dump($success);

		echo "--- ERROR ---";
		var_dump($error);
		*/
		break;
	
	case "get":
		
		$conditions = array("author"=>"212661098984@c.us");
		var_dump($whatsapp->getLast(null, $conditions));
		
		break;
		
}



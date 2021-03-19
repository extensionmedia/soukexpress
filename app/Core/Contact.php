<?php
require_once($_SESSION['CORE'].'Helpers/Modal.php');
require_once($_SESSION['CORE'].'Notify.php');

class Contact extends Modal{
	
	private $columns_ = array(
		array("column" => "id", "label"=>"#ID"),
		array("column" => "title", "label"=>"CODE / TITRE"),
		array("column" => "produit_category", "label"=>"CATEGORY"),
		array("column" => "description", "label"=>"DESCRIPTION"),
		array("column" => "created", "label"=>"CREE LE"),
		array("column" => "status", "label"=>"STATUS")
	);
	
	
// construct
	public function __construct(){
		parent::__construct();
		$this->setTableName("contact");
	}	
	


	
	/********************
							SAVE NEW MEMBER
	*********************/
	
	public function add($data){
		 
		try{
			
			$isexists = false;

			$columns = array("name","societe","phone","email","message");
			
			$isAllRight = true;

			$prefix = "contact_";

			foreach($columns as $k=>$v){



				if( !isset( $data[$prefix.$v] ) ){
					$isAllRight = false;
				}else{
					$data[ str_replace($prefix,"",$v) ] = $data[$prefix.$v];
					unset( $data[ $prefix.$v ] );
				}


			}
			
			$data["ip"] = Util::getIP();

			$lang = (isset($_SESSION["ASPICONFORT"]["params"]["lang"]["lang"]))? $_SESSION["ASPICONFORT"]["params"]["lang"]["lang"]: "";
			$msg1 = "<b> Merci ! </b> Votre message a été envoyé.";
			$msg2 = "<b> Error ! </b> Votre message n\'a pas été envoyé.";
			
			if($lang == "ar"){
				$msg1 = "<b> شكرا ! </b> لقد تمت عمليةالإرسال بنجاح.";
				$msg2 = "<b> خطء ! </b> عدرا لم تتم عملية الإرسال.";
			}

			$success = '<div class="info info-success" style="background-color:green; color:white">
							<div class="info-success-icon"><i class="fa fa-check" aria-hidden="true"></i> </div>
							<div class="info-message"> 
							'.$msg1.'
							</div>
						</div>';

			$error = '<div class="info info-error">
							<div class="info-error-icon"><i class="fa fa-ban" aria-hidden="true"></i> </div>
							<div class="info-message"> 
							'.$msg2.'
							</div>
						</div>';

			if($isAllRight){ 


				if( $this->save($data) ){
					
					
					$return = array('code'=>1,"message"=>$success);
					
					/*
					$params = array("campaign"=>"contact", "replace"=>array("{{name}}"=>$data["name"]));
					$_mail = new Mail;
					$values = array(
										"to"		=>	$data["email"],
										"message" 	=>	$_mail->getCampaign($params),
										"subject" 	=>	($lang == "ar")? "برنامج للتسيير التجاري": "Gestore : Logiciel de gestion commerciale"
										);

					$_mail->send($values);		
					*/
					$notify = new Notify("Contact", "Email : <b>" . $data["email"] . "</b><br>Téléphone : " . $data["phone"] . "<br>Message : " . $data["message"]);
					
					
				}else{
					$return = array('code'=>0,"message"=>$error);
				}	
				return $return;

			}else{
				$return = array('code'=>0,"message"=>$error);
				return $return;
			}	

			
		}catch(Exception $e) {
			$return = array('code'=>0,"message"=>$e->getMessage());
			return $return;
		}
		
	}
	
	
	public function getColumns(){
		
		if ( isset($this->columns) ){
			return $this->columns;
		}else{
			$columns = array();
			//var_dump($this->getColumnsName("client"));
			foreach($this->getColumnsName("contact") as $k=>$v){
				//var_dump($v["Field"]);
				array_push($columns, array("column" => $v["Field"], "label" => $v["Field"]) );
			}
			return $columns;
		}
		
	}

}
$contact = new Contact;
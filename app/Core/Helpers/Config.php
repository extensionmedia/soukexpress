<?php

date_default_timezone_set('Africa/Casablanca');

class Config{
	private $config = array(
				"dev"	=>	array(
									"host"		=>	"localhost",
									"dbname"	=>	"soukexpr_db",
									"username"	=>	"root",
									"password"	=>	""
							),
				"prod"	=>	array(
									"host"		=>	"localhost",
									"dbname"	=>	"soukexpr_db",
									"username"	=>	"soukexpr_db",
									"password"	=>	"1A2Z3E4R5t6y"
							),
				"mail"	=>	array(
							"host"			=>	"mail.aspi-confort.com",
							"port"			=>	"465",
							"smtp_secure"	=>	"ssl",
							"is_smtp_auth"	=>	true,
							"user_name"		=>	"contact@aspi-confort.com",
							"password"		=>	"1A2Z3E4R5T6Y",
							"from_name"		=>	"ASPICONFORT"
							)
	);
	
	
	public function get(){
		return $this->config;
	}
	
	/*************************************
	Get the IP_ADDRESS
	**************************************/
	public function getEnv() {
		if($this->getIP() == "::1" || $this->getIP() == "127.0.0.1"){
			return "dev";
		}else{
			return "prod";
		}
	}
	
	/*************************************
	Get the IP_ADDRESS
	**************************************/
	public function getIP() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}	
	
}

$config = new Config();

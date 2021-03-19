<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['data'])){die("-2");}

if(!isset($_POST['data']['t_n'])){die("-3");}

$table_name = $_POST['data']['t_n'];


if(file_exists($_SESSION['CORE'].$table_name.".php")){
	
	require_once($_SESSION['CORE'].$table_name.".php");
	$ob = new $table_name();
	
	foreach($_POST["data"]["columns"] as $k=>$v){

		if(strpos($k,"*")){
			$_POST["data"]["columns"][trim($k,"*")] = $_POST["data"]["columns"][$k];
			unset($_POST["data"]["columns"][$k]);
		}

		// don't forfet to remove slash by using : stripslashes($v)
		$_POST["data"]["columns"][trim($k,"*")] = addslashes ($v);
		

	}	
	
	$data = array(
		"website_phone"				=>	$_POST["data"]["columns"]["website_phone"],
		"website_description"		=>	$_POST["data"]["columns"]["website_description"],
		"website_keywords"			=>	$_POST["data"]["columns"]["website_keywords"],
		"website_google_analytics"	=>	$_POST["data"]["columns"]["website_google_analytics"],
		"website_facebook_pixel"	=>	$_POST["data"]["columns"]["website_facebook_pixel"],
		"smtp_username"				=>	$_POST["data"]["columns"]["smtp_username"],
		"smtp_password"				=>	$_POST["data"]["columns"]["smtp_password"],
		"smtp_host"					=>	$_POST["data"]["columns"]["smtp_host"],
		"imap"						=>	$_POST["data"]["columns"]["imap"],
		"port"						=>	$_POST["data"]["columns"]["port"],
		"api_whatsapp"				=>	$_POST["data"]["columns"]["api_whatsapp"],
		"website_name"				=>	$_POST["data"]["columns"]["website_name"],
		"website_language"			=>	$_POST["data"]["columns"]["website_language"]
	);

	
	if( isset($_POST["data"]["columns"]["id"]) ){
		$data["id"] = $_POST["data"]["columns"]["id"];
	}	
	
	//var_dump($_POST["data"]["columns"]);
	
	$ob->save($data);
	echo "1";
	
}else{
	echo "File not exists : " . $_SESSION['CORE'].$table_name.".php";
}



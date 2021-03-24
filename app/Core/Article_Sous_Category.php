<?php
require_once('Helpers/Modal.php');
require_once('Helpers/View.php');
class Article_Sous_Category extends Modal{
	private $default_avatar = "https://cdn4.iconfinder.com/data/icons/food-delivery-21/64/grocery-512.png";
	private $tableName = "Article_Sous_Category";
	
// construct
	public function __construct(){
		try{
			parent::__construct();
			$this->setTableName(strtolower($this->tableName));

			/*
			foreach($this->find() as $c){
				$filesDirectory = $_SESSION["UPLOAD_FOLDER"]."sous_category".DIRECTORY_SEPARATOR.$c["UID"].DIRECTORY_SEPARATOR;
				foreach(scandir($filesDirectory) as $k=>$v){
					if( $v <> "." && $v <> ".." && strpos($v, '.') !== false ){
						$img = 'http://'.$_SESSION["STATICS"]."sous_category/".$c["UID"].'/'.$v;
						$this->save([
							'id'			=>	$c['id'],
							'image_url'		=>	$img
						]);
					}
				}
			}
			*/

		}catch(Exception $e){
			die($e->getMessage());
		}
	}	

	public function get_files($folder = "", $name = "", $args = null){
		$statics = $_SESSION["STATICS"];
		$upload_folder = $_SESSION["UPLOAD_FOLDER"];

		$dS = DIRECTORY_SEPARATOR;

		$filesDirectory = $upload_folder.$folder.$dS.$name.$dS;
		
		$images = "";
		if(file_exists($filesDirectory)){
			

			foreach(scandir($filesDirectory) as $k=>$v){

				if($v <> "." and $v <> ".." and strpos($v, '.') !== false){
					$images .= "<div style='display:inline-block; margin:5px; text-align:center'>";
					$images .= "<img class='' style='width:100%; height:auto; display:block' src='http://".$statics.$folder."/".$name."/".$v."'>";	
					$images .= "<button data-page='Article_Sous_Category' class='btn btn-orange edit_ligne' value='".$args["id"]."'><i class='fas fa-edit'></i></button>";
					$images .= "</div>";
					//$nbr++;
				}

			}	
			//echo $images;
		}else{
			$images .= "<div style='display:inline-block; margin:5px; text-align:center'>";
			$images .= "<img class='' style='width:100%; height:auto; display:block' src='http://".$statics."/creative_0.png'>";	
			$images .= "<button data-page='Article_Sous_Category' class='btn btn-orange edit_ligne' value='".$args["id"]."'><i class='fas fa-edit'></i></button>";
			$images .= "</div>";
		}
		
		
		return $images;
		
	}

	public function get($params){

		$view = new View("article_sous_category.partials.header");
		$html = $view->render([]);
		
		if(!empty($params)){
			if($params['id_parent'] != 0)
				$data = $this->find('', ['conditions'=>['id_parent='=>$params['id_parent']]], 'article_sous_category');
			else
				$data = $this->find('', ['conditions AND'=>['id_parent='=>-1,'id_article_category='=>$params['id_article_category']]], 'article_sous_category');
		}

		foreach($data as $sous_category){
			$view = new View("article_sous_category.partials.item");
			$html .= $view->render([
				'parent'	=>	$sous_category['id'],
				'lavel'		=>	$params['lavel'],
				'sous_category'	=>	$sous_category
			]); 
		}
		return $html;
	}
	
}

$article_sous_category = new Article_Sous_Category;
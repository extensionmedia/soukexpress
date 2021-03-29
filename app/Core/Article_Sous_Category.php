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

		if(!empty($params)){
			if($params['id_parent'] != 0)
				$data = $this->find('', ['conditions'=>['id_parent='=>$params['id_parent']], 'order'=>'ord'], 'article_sous_category');
			else
				$data = $this->find('', ['conditions AND'=>['id_parent='=>-1,'id_article_category='=>$params['id_article_category']]], 'article_sous_category');
		}

		$view = new View("article_sous_category.partials.header");
		$html = $view->render([]);

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

	/** Avatar Section*/
	public function avatar($params){
		if(!isset($params['UID'])) return $this->default_avatar;
		
		$dS = DIRECTORY_SEPARATOR;
		$dir = $_SESSION["UPLOAD_FOLDER"]."sous_category".$dS.$params['UID'].$dS;
		if(file_exists($dir)){
			foreach(scandir($dir) as $file){
				if($file <> "." and $file <> ".."){
					return "http://".$_SESSION["STATICS"]."sous_category/".$params['UID']."/".$file;
				}
			}	
		}else{
			return $this->default_avatar;
		}

	}

	public function remove_avatar($params){
		
		$dS = DIRECTORY_SEPARATOR;
		$dir = $_SESSION["UPLOAD_FOLDER"]."sous_category".$dS.$params['UID'].$dS;
		if(file_exists($dir)){
			$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
			$files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
			foreach($files as $file) {
				unlink($file->getRealPath());
			}

			rmdir($dir);	

			$data = $this->find('',['conditions'=>['UID='=>$params['UID']]],'');

			if( count( $data ) ){
				$this->save([
					'id'=>$data[0]['id'], 
					'image_url'=> $this->default_avatar
				]);
			}
		}
		return "success";
		
	}

	public function edit($params = []){
		$category = $this->find('', ['conditions'=>['id='=>$params['id']]], 'article_sous_category')[0];
		$parent = $this->find('', ['conditions AND'=>['id_parent='=>"-1", 'id_article_category='=>$category['id_article_category']],'order'=>'ord asc'], 'article_sous_category');
		$params = [
			'categories'		=>	$this->find('', ['order'=>'ord asc'], 'article_category'),
			'sous_category'		=>	$category,
			'parents'			=>	$params['categories'],
			'obj'				=>	new Article_Sous_Category,
			'UID'				=>	$category['UID']
		];
		$view = new View("article_sous_category.edit");
		return $view->render($params); 
	}

	public function add($params = []){
		$params = [
			'categories'	=>	$this->find('', ['order'=>'ord asc'], 'article_category'),
			'UID'			=>	 substr( md5( uniqid('auth', true) ),0,8),
			'obj'			=>	new Article_Sous_Category,
			'parents'		=>	$params['categories']
		];
		$view = new View("article_sous_category.add");
		return $view->render($params); 
	}

	public function create($params){
		$params['image_url'] = $this->avatar(['UID'=>$params['UID']]);
		$params['article_sous_category_fr'] = addslashes($params['article_sous_category_fr']);
		$params['article_sous_category_ar'] = addslashes($params['article_sous_category_ar']);
		$params['article_sous_category_es'] = addslashes($params['article_sous_category_es']);
		return $this->save($params);
	}

	public function update($params){
		$params['image_url'] = $this->avatar(['UID'=>$params['UID']]);
		$params['article_sous_category_fr'] = addslashes($params['article_sous_category_fr']);
		$params['article_sous_category_ar'] = addslashes($params['article_sous_category_ar']);
		$params['article_sous_category_es'] = addslashes($params['article_sous_category_es']);
		return $this->save($params);
	}

	public function remove($params){
		if(isset($params['id'])){
			$data = $this->find('', ['conditions'=>['id='=>$params['id']]], '');
			if(count($data)){

				$dS = DIRECTORY_SEPARATOR;
				$dir = $_SESSION["UPLOAD_FOLDER"]."sous_category".$dS.$data[0]['UID'].$dS;
				if(file_exists($dir)){
					array_map('unlink', glob("$dir/*.*"));
					rmdir($dir);
				}
				return $this->delete($data[0]['id']);
			}
		}
		return 0;
	}

}

$article_sous_category = new Article_Sous_Category;
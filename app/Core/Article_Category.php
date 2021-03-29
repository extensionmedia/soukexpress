<?php
require_once('Helpers/Modal.php');
require_once('Helpers/View.php');

class Article_Category extends Modal{

	private $default_avatar = "https://cdn4.iconfinder.com/data/icons/food-delivery-21/64/grocery-512.png";
	
	private $tableName = "Article_Category";
	
// construct
	public function __construct(){
		try{

			parent::__construct();
			$this->setTableName(strtolower($this->tableName));
			/*
			foreach($this->find() as $c){
				$filesDirectory = $_SESSION["UPLOAD_FOLDER"]."category".DIRECTORY_SEPARATOR.$c["UID"].DIRECTORY_SEPARATOR;
				foreach(scandir($filesDirectory) as $k=>$v){
					if( $v <> "." && $v <> ".." && strpos($v, '.') !== false ){
						$img = 'http://'.$_SESSION["STATICS"]."category/".$c["UID"].'/'.$v;
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

	public function images($params){
		$statics = $_SESSION["STATICS"];
		$upload_folder = $_SESSION["UPLOAD_FOLDER"];	
		$dS = DIRECTORY_SEPARATOR;
		$images = ["https://cdn.iconscout.com/icon/free/png-256/gallery-187-902099.png"];
		$folder_name = $params['folder_name'];
		
		$filesDirectory = $_SESSION["UPLOAD_FOLDER"]."category".$dS.$folder_name.$dS;
		
	}
	
	/** Avatar Section*/
	public function avatar($params){
		if(!isset($params['UID'])) return $this->default_avatar;
		
		$dS = DIRECTORY_SEPARATOR;
		$dir = $_SESSION["UPLOAD_FOLDER"]."category".$dS.$params['UID'].$dS;
		if(file_exists($dir)){
			foreach(scandir($dir) as $file){
				if($file <> "." and $file <> ".."){
					return "http://".$_SESSION["STATICS"]."category/".$params['UID']."/".$file;
				}
			}	
		}else{
			return $this->default_avatar;
		}

	}
	
	public function remove_avatar($params){
		
		$dS = DIRECTORY_SEPARATOR;
		$dir = $_SESSION["UPLOAD_FOLDER"]."category".$dS.$params['UID'].$dS;
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
	
	/** END Avatar Section*/

	
	public function get(){

		$view = new View("article_category.partials.header");
		$html = $view->render([]);
		foreach($this->find('', ['order'=>'ord asc'], '') as $category){
			$view = new View("article_category.partials.item");
			$html .= $view->render([
				'parent'	=>	0,
				'lavel'		=>	0,
				'category'	=>	$category
			]); 
		}
		return $html;
	}
	
	public function edit($params = []){
		$category = $this->find('', ['conditions'=>['id='=>$params['id']]], 'article_category')[0];
		$params = [
			'categoriess'	=>	$this->find('', ['order'=>'ord asc'], ''),
			'category'		=>	$category,
			'obj'			=>	new Article_Category,
			'UID'			=>	$category['UID']
		];
		$view = new View("article_category.edit");
		return $view->render($params); 
	}
	
	public function create($params){
		$params['image_url'] = $this->avatar(['UID'=>$params['UID']]);
		$params['article_category_fr'] = addslashes($params['article_category_fr']);
		$params['article_category_ar'] = addslashes($params['article_category_ar']);
		$params['article_category_es'] = addslashes($params['article_category_es']);
		return $this->save($params);
	}

	public function add($params = []){
		$params = [
			'categoriess'	=>	$this->find('', ['order'=>'ord asc'], ''),
			'UID'			=>	 substr( md5( uniqid('auth', true) ),0,8),
			'obj'			=>	new Article_Category,
		];
		$view = new View("article_category.add");
		return $view->render($params); 
	}	
	
	public function update($params){
		$params['image_url'] = $this->avatar(['UID'=>$params['UID']]);
		$params['article_category_fr'] = addslashes($params['article_category_fr']);
		$params['article_category_ar'] = addslashes($params['article_category_ar']);
		$params['article_category_es'] = addslashes($params['article_category_es']);
		return $this->save($params);
	}
	
	public function remove($params){
		if(isset($params['id'])){
			$data = $this->find('', ['conditions'=>['id='=>$params['id']]], '');
			if(count($data)){

				$dS = DIRECTORY_SEPARATOR;
				$dir = $_SESSION["UPLOAD_FOLDER"]."category".$dS.$data[0]['UID'].$dS;
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

$article_category = new Article_Category;
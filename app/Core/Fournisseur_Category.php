<?php
require_once('Helpers/Modal.php');

class Fournisseur_Category extends Modal{

	private $columns = array(
		array("column" => "id", "label"=>"#ID", "style"=>"display:none", "display"=>0),
		array("column" => "created", "label"=>"CREATION", "style"=>"display:none", "display"=>0),
		array("column" => "fournisseur_category_fr", "label"=>"CATEGORIE (fr)", "style"=>"min-width:125px;font-weight:bold"),
		array("column" => "fournisseur_category_es", "label"=>"CATEGORIE (es)", "style"=>"min-width:125px;font-weight:bold"),
		array("column" => "fournisseur_category_ar", "label"=>"CATEGORIE (ar)", "style"=>"min-width:125px;font-weight:bold"),
		array("column" => "total", "format"=>"money", "label"=>"TOTAL", "style"=>"min-width:105px; width:100px; text-align:right; color:#E91E63; font-size:14px;background-color:rgba(255,0,0,0.2)"),
		array("column" => "status", "label"=>"STATUS", "style"=>"min-width:80px; width:80px"),
		array("column" => "is_default", "label"=>"DEFAULT", "style"=>"min-width:80px; width:80px"),
		array("column" => "actions", "label"=>"", "style"=>"min-width:105px; width:105px")
	);
	
	private $tableName = "Fournisseur_Category";
	
// construct
	public function __construct(){
		try{
			parent::__construct();
			$this->setTableName(strtolower($this->tableName));
		}catch(Exception $e){
			die($e->getMessage());
		}
	}	
	
		
	public function getColumns(){
		
		if ( isset($this->columns) ){
			return $this->columns;
		}else{
			$columns = array();
			//var_dump($this->getColumnsName("client"));
			foreach($this->getColumnsName(strtolower($this->tableName)) as $k=>$v){
				//var_dump($v["Field"]);
				array_push($columns, array("column" => $v["Field"], "label" => $v["Field"]) );
			}
			array_push($columns, array("column" => "actions", "label" => "", "style"=>"min-width:105px; width:105px") );
			return $columns;
		}
		
	}
	
}

$fournisseur_category = new Fournisseur_Category;
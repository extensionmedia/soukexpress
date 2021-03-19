<?php
require_once('Utils.php');
require_once('Config.php');
require_once('DataBase.php');

class Modal{
	private $mysql;
	public $isConnected = false;
	public $err;
	private $tableName = "";
	private $table_preffix="";
	public $id="";
	public $totalItems = 0;
	public $isError = 0;

// construct
	public function __construct(){
		
		try{
			$config = new Config;
			$params = $config->get();
			$this->mysql = new DataBase($params[$config->getEnv()]);
			if ($this->mysql->isConnected){
				$this->isConnected = true;
			}else{
				$this->isConnected = false;
				$this->err = $this->mysql->err;
			}
			
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	
	public function setTableName($tableName){
		$this->tableName = $this->table_preffix.$tableName;
		
	}	
	
	public function setID($id){
		$this->id = $id;
	}
	
	//**************************************
	//********************* DATA BASE SCHEMA
	//**************************************
	
	// get Table schema in data base
	public function getTablesName(){
		try{
			$req = "SHOW TABLES";
			return $this->mysql->getTables($req);
			
		}catch(Exception $e){
			$this->err->save($this->tableName." -> getTablesName",$e->getMessage(),$req);
		}
	}

	// get Columns in given table name
	public function getColumnsName($tableName){
		try{
			$req = "SHOW FULL COLUMNS FROM " . $tableName;
			return $this->mysql->getTables($req);
			
		}catch(Exception $e){
			die($e->getMessage());
			//$this->err->save($this->tableName." -> getTablesName",$e->getMessage(),$req);
		}
	}
	
	// fetch all tableName
	public function fetchAll($use = null, $from = null, $to = null){
		try{
			$req = "";
			if($use==null){$req = "SELECT * FROM ".$this->tableName;}
			if($use!=null){$req = "SELECT * FROM ".$this->table_preffix.$use;}
			
			if($to!=null){$req = $req." LIMIT ".$from.",".$to;}
			//$_SESSION["req"] = $req;
			return $this->mysql->getRows($req);
			
		}catch(Exception $e){
			die($e->getMessage());
		}
	}

	// FIND DATA
	public function read($fields = null){
		if($fields == null){$fields = "*";}
		if ($this->id == ""){
			$sql = "SELECT ".$fields." FROM ".$this->tableName;
		}else{
			$sql = "SELECT ".$fields." FROM ".$this->tableName." WHERE id=". $this->id;
		}
		return $this->mysql->getRows($sql);	
	}

	//get tableName by fields
	public function find($fields = null,$params = null, $use = null){
		try{
			$tableToUse = $this->tableName;
			
			if($use!=null){
				$tableToUse = $this->table_preffix.$use;
			}
			
			if(is_array($fields) and !empty($fields)){
				$req = "SELECT * FROM ".$tableToUse;
				if(is_array($params) and !empty($params)){
					$params = $fields;
				}
			}else{
				$fields = ($fields==null)? "*": ( ($fields=="all")? "*": $fields );
				$req = "SELECT ".$fields." FROM ".$tableToUse;
			}
			$reqTemp = "";
			if(is_array($params) and !empty($params)){

				foreach($params as $k=>$v){
						if ($k == "conditions" OR $k == "conditions OR" OR $k == "conditions AND"){
							$reqTemp="";
							$p = explode(" ",$k);
							if(count($p) == 0){
								foreach($v as $k1=>$v1){
									$reqTemp .= ($reqTemp=="")?" WHERE ".$k1."'".$v1."'":" AND ".$k1."'".$v1."'";
								}
							}else{
								foreach($v as $k1=>$v1){
									$reqTemp .= ($reqTemp=="")?" WHERE ".$k1."'".$v1."'":" " . $p[1] . " ".$k1."'".$v1."'";
								}
							}
							
							$req.=$reqTemp;
						}
						if ($k == "order"){
							$reqTemp="";
							$reqTemp .= " ORDER BY ".$v;
							/*
							foreach($v as $k1=>$v1){
								$reqTemp .= ($reqTemp=="")?" ORDER BY ".$v1:" , ".$v1;
							}*/
							$req.=$reqTemp;
						}
						if ($k == "limit"){
							$reqTemp="";
							foreach($v as $k1=>$v1){
								$reqTemp .= ($reqTemp=="")?" LIMIT ".$v1:" , ".$v1;
							}$req.=$reqTemp;
						}

				}
				//echo $req;
			}return $this->mysql->getRows($req); 	//echo $req;
		}catch(Exception $e){
			$this->isError = 1;
			//$this->err->save($this->tableName." -> find",$e->getMessage(),$req);
		}
	}
	
	//Save article
	public function save($data, $tableName=null){
		try{
			if(isset($data["numero"]) && !empty($data["numero"])){
				$sql = "UPDATE ".$this->tableName." SET";
				foreach($data as $k=>$v){
					if($k != "numero"){
						$sql.=" ".$k."='".$v."',";	
					}
				}
				$sql = substr($sql,0,-1);
				$sql.= " WHERE numero=".$data['numero'];
			}elseif(isset($data["id"]) && !empty($data["id"])){
				if($tableName===null){
					$sql = "UPDATE ".$this->tableName." SET";
				}else{
					$sql = "UPDATE ".$tableName." SET";
				}
				
				foreach($data as $k=>$v){
					if($k != "id"){
						$sql.=" ".$k."='".$v."',";	
					}
				}
				$sql = substr($sql,0,-1);
				$sql.= " WHERE id=".$data['id'];
			}else{
				if($tableName===null){
					$sql = "INSERT INTO ".$this->tableName."(";	
				}else{
					$sql = "INSERT INTO ".$tableName."(";	
				}
				
				foreach($data as $k=>$v){
					$sql.= $k.",";	
				}
				$sql = substr($sql,0,-1);
				$sql.=") VALUES(";
				foreach($data as $k=>$v){
					$sql.="'".$v."',";	
				}
				$sql = substr($sql,0,-1);
				$sql.=")";
			}
			//echo $sql;
			return $this->mysql->insertRow($sql);
		}catch(Exception $e){
			echo $e->getMessage(); echo "<br>".$sql;
		}
	}

	//Delete article
	public function delete($id,$tName=null){
		try{
			if($id != "" && $id != null){
				if($tName != "" && $tName != null){
					$sql = "DELETE FROM ".$this->table_preffix.$tName." WHERE id=".$id;
				}else{
					$sql = "DELETE FROM ".$this->tableName." WHERE id=".$id;
				}
			}
			return $this->mysql->insertRow($sql);
		}catch(Exception $e){
			$this->err->save($this->tableName." -> Delete",$e->getMessage(),$sql);
		}
	}	
	
	// Get Last ID
	public function getLastID(){
		try{
			$req = "SELECT id as lastID FROM ".$this->tableName." ORDER BY id DESC";
			$id = $this->mysql->getRows($req);
			if(count($id)>0){
				return $id[0]["lastID"];
			}else{
				return 0;
			}
		}catch(Exception $e){
			$this->err->save($this->tableName." -> getLastID",$e->getMessage(),$req);
		}		
	}
	
	// Get Total Items
	public function getTotalItems(){
		try{
			$req = "SELECT id FROM ".$this->tableName;
			return count($this->mysql->getRows($req));
			
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	
	// Get SUM Items
	public function getSum($column, $conditions){
		try{
			$req = "SELECT SUM(" . $column . ") as _total_ FROM ".$this->tableName . " WHERE " . $conditions;
			$SUM = $this->mysql->getRows($req);
			return $SUM[0]["_total_"];
			
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	
	// Filter string to evoid injections
	public function strFilter($string){
		$string = str_replace("/","",$string);
		$string = str_replace("'","",$string); 
		$string = str_replace("=","",$string); 
		$string = str_replace("\\","",$string); 
		$string = str_replace(",","",$string);
		$string = str_replace("script","",$string);
		$string = str_replace("<","",$string);
		$string = str_replace(">","",$string);	
		
		return $string;	
	}
	
	// Save activity of a user
	function saveActivity($lang, $id_user, $code, $id_module){
		$activity = Util::getActionByCode($lang, $code[0]);
		$data = array(
			"created_by"			=>	$id_user,
			"activity_action"		=>	$activity[$code[1]]["title"],
			"activity_module_id"	=>	$id_module,
			"activity_message"		=>	$activity[$code[1]]["message"],
			"activity_ip"			=>  Util::getIP(),
			"module"				=>	$code[0]
		);
		$this->save($data, "person_activity");
	}
	
	public function format($number = 0, $show_currency=true){
		if($show_currency){
			return number_format($number,2,",",".")." Dh";
		}else{
			return number_format($number,2,",",".");
		}
	}
	
	public function drawTable($args = null, $conditions = null, $useTableName = null){

		$showPerPage = array("20","50","100","200","500","1000");
		$status = array("<div class='label label-red'>Désactivé</div>", "<div class='label label-green'>Activé</div>");
		$remove_sort = array("actions","nbr");
		
		
		$p_p = (isset($args['p_p']))? $args['p_p']: $showPerPage[0];
		$current = (isset($args['current']))? $args['current']: 0;
		$sort_by = (isset($args['sort_by']))? $args['sort_by']: "created";
		$temp = explode(" ", $sort_by );
		$order = "";
		if(count( $temp ) > 1 ){ $order =  $temp[1]; }
		
		$values = array("Error : " . $this->tableName);
		$t_n = ($useTableName===null)? strtolower($this->tableName): $useTableName;
		
		if($conditions === null){
			$values = $this->find(null,array("order"=>$sort_by,"limit"=>array($current*$p_p,$p_p)),$t_n);
			$totalItems = $this->getTotalItems();
		}else{
			$conditions["order"] = $sort_by;
			$totalItems = count($this->find(null,$conditions,$t_n));
			$conditions["limit"] = array($current*$p_p,$p_p);
			$values = $this->find(null,$conditions,$t_n);
		}
		
		$returned = '<div class="col_12" style="padding: 0">';
	
		$returned .= '	<div style="display: flex; flex-direction: row">';
		$returned .= '		<div style="flex: auto; padding: 15px 0 10px 5px; margin: 0; color: rgba(118,17,18,1.00)">';
		$returned .= '			المجموع : ('.count($values).' / '.$totalItems.') <span class="current hide">'.$current.'</span>';
		$returned .= '		</div>';
		$returned .= '		<div style="width: 10rem">';
		$returned .= '		<div style="flex-direction: row; display: flex">';
		$returned .= '			<div style="flex: 1">';
		$returned .= '				<select id="showPerPage">';
		
		foreach($showPerPage as $kk => $vv)
			$returned .= '				<option value="'.$vv.'" ' . ( $p_p == $vv ? "selected" : "") .'>'.$vv.'</option>';
		
		
		$returned .= '				</select>';
		$returned .= '					<span class="hide ' . $order . '" id="sort_by">'.$sort_by.'</span>';
		$returned .= '			</div>';
		$returned .= '			<div style="flex: 1; text-align: center">';
		$returned .= '				<div class="btn-group">';
		$returned .= '					<a style="padding: 12px 12px" id="btn_passive_preview"  title="Précédent"><i class="fa fa-chevron-left"></i></a>';
		$returned .= '					<a style="padding: 12px 12px" id="btn_passive_next" title="Suivant"><i class="fa fa-chevron-right"></i></a>';
		$returned .= '				</div>';
		$returned .= '			</div>';
		$returned .= '		</div>';
		$returned .= '		</div>';
		$returned .= '	</div>';	
	
		$returned .= '	<div class="panel" style="overflow: auto;">';
		$returned .= '		<div class="panel-content" style="padding: 0">';
		
		$returned .= '			<table class="table">';
		$returned .= '				<thead>';
		$returned .= '					<tr>';
		
		$columns = $this->getColumns();
	
		

		foreach($columns as $key=>$value){

			$style = ""; 
			$is_sort = ( in_array($value["column"], $remove_sort) )? "" : "sort_by";
			$is_display = ( isset($value["display"]) )? "hide" : "";
			if($is_sort === ""){
				$returned .= "<th class='".$is_sort. " ". $is_display . "' data-sort='" . $value['column'] . "'> " . $value['label'] . "</th>";
			}else{
				$returned .= "<th class='".$is_sort. " ". $is_display . "' data-sort='" . $value['column'] . "'> <i class='fas fa-sort'></i> " . $value['label'] . "</th>";
			}
			

		}
		$returned .= '					</tr>';
		$returned .= '				</thead>';
		$returned .= '				<tbody>';
		
		
		$content = '<div class="info info-success"><div class="info-success-icon"><i class="fa fa-info" aria-hidden="true"></i> </div><div class="info-message">Liste vide ...</div></div>';
		$i = 0;
		
		$t = explode("_",$this->tableName);
		$_t = "";
		foreach ($t as $k=>$v){
			$_t .= ($_t==="")? ucfirst($v): "_".ucfirst($v) ;
		}
		
		foreach($values as $k=>$v){
			$returned .= '					<tr class="edit_ligne" data-page="'.$_t.'">';
			foreach($columns as $key=>$value){
				
				$style = (isset($columns[$key]["style"]))? $columns[$key]["style"]:"";
				
				if(isset($v[ $columns[$key]["column"] ])){
					if($columns[$key]["column"] == "is_default"){
						$returned .= ($v[ $columns[$key]["column"] ] == 0)? "<td style='".$style."'></td>": "<td style='".$style."; font-size:10px; color:green'> <i class='fas fa-check'></i> <span>Par Défaut</span></td>";
					}elseif($columns[$key]["column"] == "id"){
						$returned .= "<td style='".$style."'><span class='id-ligne'>" . $v[ $columns[$key]["column"] ] . "</span></td>";
					}elseif($columns[$key]["column"] == "status"){
						$returned .= "<td style='".$style."'>".$status[$v["status"]]."</td>";
					}elseif($columns[$key]["column"] == "first_name"){
								
						if(isset($v["notes"])){
							if($v["notes"] !== '')
								$returned .= "<td style='".$style."'>" . $v["first_name"] . " " . $v["last_name"] . " <span style='color:blue; font-size:12px'><i class='fas fa-info-circle'></i></span></td>";
							else
								$returned .= "<td style='".$style."'>" . $v["first_name"] . " " . $v["last_name"] . " </td>";
						}else{
							$returned .= "<td style='".$style."'>" . $v["first_name"] . " " . $v["last_name"] . "</td>";
						}
					}else{
						if(isset($columns[$key]["format"])){
							if($columns[$key]["format"] == "money"){
								$returned .= "<td style='".$style."'>" . $this->format( $v[ $columns[$key]["column"] ] ) . "</td>";
							}else{
								$returned .= "<td style='".$style."'>" . $v[ $columns[$key]["column"] ] . "</td>";
							}
						}else{
							$returned .= "<td style='".$style."'>" . $v[ $columns[$key]["column"] ] . "</td>";
						}
						
					}											
				}else{
					if($columns[$key]["column"] == "actions"){
						$returned .=   "<td style='".$style."'><button style='margin-right:10px' data-page='".$_t."' class='btn btn-red remove_ligne' value='".$v["id"]."'><i class='fas fa-trash-alt'></i></button><button data-page='".$_t."' class='btn btn-orange edit_ligne' value='".$v["id"]."'><i class='fas fa-edit'></i></button></td>";												
					}elseif($columns[$key]["column"] == "nbr"){
						$returned .=  "<td style='".$style."'>0</td>";
					}else{
						$returned .=  "<td style='".$style."'></td>";
					}

				}


			}
			$returned .= '					</tr>';
		$i++	;
		}
	
		if($i == 0){
			$returned .= "<tr><td colspan='" . (count($columns)+1) . "'>".$content."</td></tr>";
		}
		
	
		$returned .= '				</tbody>';
		$returned .= '			</table>';
		$returned .= '		</div>';
		$returned .= '	</div">';
		$returned .= '</div>';
		echo $returned;

	}

}
//$modal = new Modal;


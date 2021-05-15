<?php
require_once('Helpers/Modal.php');
require_once('Helpers/View.php');

class Article extends Modal{

	private $columns = array(
		array("column" => "id", "label"=>"#ID", "style"=>"display:none", "display"=>0),
		array("column" => "created", "label"=>"CREATION", "style"=>"display:none", "display"=>0),
		array("column" => "code", "label"=>"CODE", "style"=>"font-weight:bold; min-width:80px; width:80px; "),
		array("column" => "libelle_fr", "label"=>"DESIGNATION", "style"=>""),
		array("column" => "article_category_fr", "label"=>"CATEGORY", "style"=>""),
		array("column" => "article_sous_category_fr", "label"=>"SOUS CATEGORY", "style"=>""),
		array("column" => "display_order", "label"=>"ORDER", "style"=>"font-size:18px; text-align:center; font-weight:bold;min-width:85px; width:85px; color:red"),
		array("column" => "prix_achat","format"=>"money", "label"=>"ACHAT", "style"=>"min-width:180px; width:180px; background-color:#FFE4B5; color:black; font-weight:bold; border-bottom:#9E9E9E 1px solid; text-align:right"),
		array("column" => "prix_vente","format"=>"money", "label"=>"VENTE", "style"=>"min-width:180px; width:180px; background-color:#EEEEEE; color:black; font-weight:bold; border-bottom:#9E9E9E 1px solid; text-align:right"),
		array("column" => "is_visible_on_web","label"=>"WEB", "style"=>"max-width:80px; width:80px"),
		array("column" => "actions", "label"=>"", "style"=>"min-width:105px; width:105px")
	);
	
	private $tableName = "Article";
	
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
	
		
	public function drawTable($args = null, $conditions = null, $useTableName = null){

		$on = $_SESSION["HOST"]."templates/default/images/enable.png";
		$off = $_SESSION["HOST"]."templates/default/images/disable.png";
		
		$showPerPage = array("20","50","100","200","500","1000");
		$status = array("<div class='label label-red'>Désactivé</div>", "<div class='label label-green'>Activé</div>");
		$remove_sort = array("actions","nbr", "prix_achat", "prix_vente");
		
		
		$p_p = (isset($args['p_p']))? $args['p_p']: $showPerPage[5];
		$current = (isset($args['current']))? $args['current']: 0;
		$sort_by = (isset($args['sort_by']))? $args['sort_by']: "created";
		$temp = explode(" ", $sort_by );
		$style = (isset($args['style']))? $args['style']: "list";
		
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
		$returned .= '			Total : ('.count($values).' / '.$totalItems.') <span class="current hide">'.$current.'</span>';
		$returned .= '		</div>';
		$returned .= '		<div style="width: 20rem">';
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
		
		$returned .= '			<div style="flex: 1; text-align: center">';
		$returned .= '				<div class="btn-group-radio style">';
		if($style === "list"){
		$returned .= '					<button class="btn btn-default checked" value="list" style="padding:9px 15px; font-size:18px"><i class="fas fa-list"></i></button>';
		$returned .= '					<button class="btn btn-default" value="grid" style="padding:9px 15px; font-size:18px"><i class="fas fa-th"></i></button>';			
		}else{
		$returned .= '					<button class="btn btn-default" value="list" style="padding:9px 15px; font-size:18px"><i class="fas fa-list"></i></button>';
		$returned .= '					<button class="btn btn-default checked" value="grid" style="padding:9px 15px; font-size:18px"><i class="fas fa-th"></i></button>';				
		}

		$returned .= '				</div>';
		$returned .= '			</div>';
		
		$returned .= '		</div>';
		$returned .= '		</div>';
		$returned .= '	</div>';	
	
		$returned .= '	<div class="panel" style="overflow: auto;">';
		$returned .= '		<div class="panel-content" style="padding: 0 0 25px 0">';
		
		
		if($style === "list"){
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
				$returned .= '					<tr data-page="'.$_t.'">';
				foreach($columns as $key=>$value){

					$style = (isset($columns[$key]["style"]))? $columns[$key]["style"]:"";

					if(isset($v[ $columns[$key]["column"] ])){
						if($columns[$key]["column"] == "id"){
							$returned .= "<td style='".$style."'><span class='id-ligne'>" . $v[ $columns[$key]["column"] ] . "</span></td>";
						}elseif($columns[$key]["column"] == "libelle_fr"){
							$returned .= "<td style='".$style."'>".$v["libelle_ar"] . "</td>";
						}elseif($columns[$key]["column"] == "id_article_status"){
							$returned .= "<td style='".$style."'><span class='label label-green'>".$v["article_status_fr"] . "</span></td>";
						}elseif($columns[$key]["column"] == "prix_achat"){
							$prix_achat = "";
							foreach( $this->find("", array("conditions AND" =>array("UID="=>$v["UID"],"id_article="=>$v["id"])), "v_article_tarif_achat") as $kk=>$vv){
								$prix_achat .= "<span style='font-size:8px; color:red'>" . $vv["fournisseur_name"] . "</span> : " . $this->format( $vv[ "montant" ] ) . "<br>";
							}
							$prix_achat = ($prix_achat==="")? "0.00 Dh" : $prix_achat;
							$returned .= "<td style='".$style."'>" . $prix_achat . "</td>";
						}elseif($columns[$key]["column"] == "prix_vente"){
							$prix_vente = "";
							foreach( $this->find("", array("conditions AND" =>array("UID="=>$v["UID"],"id_article="=>$v["id"])), "v_article_tarif_vente") as $kk=>$vv){
								$prix_vente .= "<span style='font-size:8px; color:blue'>" . $vv["article_tarif"] . "</span> : " . $this->format( $vv[ "montant" ] ) . "<br>";
							}
							$prix_vente = ($prix_vente==="")? "0.00 Dh" : $prix_vente;
							$returned .= "<td style='".$style."'>" . $prix_vente . "</td>";
						}elseif($columns[$key]["column"] == "article_category_fr"){
							$returned .= "<td style='".$style."'>" . $v["article_category_ar"] ."</td>";
						}elseif($columns[$key]["column"] == "article_sous_category_fr"){
							$returned .= "<td style='".$style."'>" . $v["article_sous_category_ar"] ."</td>";
						}elseif($columns[$key]["column"] == "is_visible_on_web"){
							$s = ($v["is_visible_on_web"])? "on" : "off";
							$returned .= "<td style='".$style."'><div data-article-id='" . $v["id"] . "' class='on_off ".$s." is_visible_on_web'></div></td>";
						}else{
							
							if(isset($columns[$key]["format"])){
								if($columns[$key]["format"] == "money"){
									$returned .= "<td style='".$style."'>" . $v[ $columns[$key]["column"] ] . "</td>";
								}else{
									$returned .= "<td style='".$style."'>" . $v[ $columns[$key]["column"] ] . "</td>";
								}
							}else{
								$returned .= "<td style='".$style."'>" . $v[ $columns[$key]["column"] ] . "</td>";
							}

						}											
					}else{
						if($columns[$key]["column"] == "actions"){
							$returned .=   "<td style='width:95px; max-width:95px'><button style='margin-right:5px' data-page='".$_t."' class='btn btn-red remove_ligne' value='".$v["id"]."'><i class='fas fa-trash-alt'></i></button><button data-page='".$_t."' class='btn btn-orange edit_ligne' value='".$v["id"]."'><i class='fas fa-edit'></i></button></td>";						
						}elseif($columns[$key]["column"] == "prix_achat"){
							$returned .= "<td style='".$style."'> 0.00 Dh</td>";
						}elseif($columns[$key]["column"] == "prix_vente"){
							$returned .= "<td style='".$style."'> 0.00 Dh</td>";
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
			
		}else{
			
			$content = '<div class="info info-success"><div class="info-success-icon"><i class="fa fa-info" aria-hidden="true"></i> </div><div class="info-message">Liste vide ...</div></div>';
			$i = 0;

			$t = explode("_",$this->tableName);
			$_t = "";
			foreach ($t as $k=>$v){
				$_t .= ($_t==="")? ucfirst($v): "_".ucfirst($v) ;
			}
			
			foreach($values as $k=>$v){
				$returned .= "<div style='position:relative; width:180px; height:180px; margin:5px; display:inline-block; background-color:rgba(220,220,220,0.5); border:1px solid #C0C0C0; border-radius:7px'>" . $this->get_files("article", (is_null($v["UID"]))? "a": ($v["UID"] === "")? "a": $v["UID"],array("id"=>$v["id"])) . "<span class='label label-red' style='position:absolute; top:10px; left:10px'>".$v["code"] . "</span></div>";
			}
			
		}
		
		
		$returned .= '		</div>';
		$returned .= '	</div">';
		$returned .= '</div>';
		echo $returned;

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
					if(isset($args["style"])){
						$images .= "<img src='http://".$statics.$folder."/".$name."/".$v."'>";						
					}else{
						$images .= "<div style='display:inline-block; margin:5px; text-align:center'>";
						$images .= "<img class='' style='width:100%; height:auto; display:block' src='http://".$statics.$folder."/".$name."/".$v."'>";	
						$images .= "<button data-page='Article' class='btn btn-orange edit_ligne' value='".$args["id"]."'><i class='fas fa-edit'></i></button>";
						$images .= "</div>";					
					}
				}

			}	
			//echo $images;
		}else{
			$images .= "<div style='display:inline-block; margin:5px; text-align:center'>";
			$images .= "<img class='' style='width:100%; height:auto; display:block' src='http://".$statics."/creative_0.png'>";	
			$images .= "<button data-page='Article' class='btn btn-orange edit_ligne' value='".$args["id"]."'><i class='fas fa-edit'></i></button>";
			$images .= "</div>";
		}
		
		
		return $images;
		
	}
	
	public function createWatermark($arg = array()){
		
		if(isset($arg["article_folder"])){
			
			$dS = DIRECTORY_SEPARATOR;
			$article_folder = $arg["article_folder"];	
			
			// Find the watermark of the category
			$data = $this->find("", array("conditions"=>array("UID="=>$article_folder)), "v_article");
			
			if(count($data)>0){
				$http_statics = $_SESSION["STATICS"];
				$file_folder = $_SESSION["UPLOAD_FOLDER"];

				$direction = $file_folder."article".$dS.$article_folder.$dS;
				
				$watermark_direction = $file_folder."public".$dS."images".$dS."protection.png";
				
				if(file_exists($watermark_direction)){
					$watermark_file = "http://".$http_statics."public/images/protection.png";
					$i=1;
					if(file_exists($direction)){

						foreach(scandir($direction) as $k=>$v){
							if($v <> "." and $v <> ".." and strpos($v, '.') !== false){	
								$ext = explode(".",$v);
								$this->watermark_image($direction.$v, $watermark_file, $direction."thumbnail (" . $i . ").".$ext[1]);
								$i++;
							}
						}

					}else{
						echo $direction . " : Not Exists!";
					}						
				}else{
					echo "Watermark not exists";
				}
				
			
			}else{
				echo "Error Data!";
			}
			
		}else{
			echo "No article to operate!";
		}
	}
	
	public function watermark_image($target, $wtrmrk_file, $newcopy) {
		
		 $fileParts = pathinfo($target);

		$ext = $fileParts["extension"];
		$name = $fileParts["filename"];
		$basename = $fileParts["basename"];
		$dirname = $fileParts["dirname"];
		 
		 
		$watermark = imagecreatefrompng($wtrmrk_file);
		imagealphablending($watermark, false);
		imagesavealpha($watermark, true);
		 if($ext === "jpg" || $ext === "JPG"){
			 
			$img = imagecreatefromjpeg($target);
			 
			$img_w = imagesx($img);
			$img_h = imagesy($img);
			$wtrmrk_w = imagesx($watermark);
			$wtrmrk_h = imagesy($watermark);
			$dst_x = ($img_w / 2) - ($wtrmrk_w / 2); // For centering the watermark on any image
			$dst_y = ($img_h / 2) - ($wtrmrk_h / 2); // For centering the watermark on any image
			imagecopy($img, $watermark, $dst_x, $dst_y, 0, 0, $wtrmrk_w, $wtrmrk_h);
			imagejpeg($img, $newcopy, 100);
			imagedestroy($img);
			imagedestroy($watermark);
			 $img = $watermark = null;
			 
		 }elseif($ext === "png"){
			$img = imagecreatefrompng($target);
			 
			$img_w = imagesx($img);
			$img_h = imagesy($img);
			$wtrmrk_w = imagesx($watermark);
			$wtrmrk_h = imagesy($watermark);
			$dst_x = ($img_w / 2) - ($wtrmrk_w / 2); // For centering the watermark on any image
			$dst_y = ($img_h / 2) - ($wtrmrk_h / 2); // For centering the watermark on any image
			imagecopy($img, $watermark, $dst_x, $dst_y, 0, 0, $wtrmrk_w, $wtrmrk_h);
			imagepng($img, $newcopy, 9);
			imagedestroy($img);
			imagedestroy($watermark);
			 $img = $watermark = null;
		 }
		

		 
	}
	
	public function Get_Days_Of_Month($params = []){
		$month = isset($params["month"])? $params["month"]: date("m");
		$year = isset($params["year"])? $params["year"]: date("m");
		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
	}

	public function distroy_disponibilite($params){
		if($params["id"]){
			return $this->delete($params["id"], 'article_disponibilite');
		}
	}

	public function disponibilite($params){
		if($params["UID"]){
			$data = $this->find('', ['conditions'=>['UID='=>$params["UID"]]], 'article_disponibilite');
			$view = new View("article.disponibilite.list");
			$html = $view->render(['data'=>$data]);
			return $html;
		}
	}

	public function add_disponibilite($params){
		$view = new View("article.disponibilite.add");
		$UID = $params['UID'];
		$html = $view->render(['UID'=>$UID]);
		return $html;
	}

	public function save_disponibilite($params){
		if($params["UID"]){
			$data = $this->find('id', ['conditions'=>['UID='=>$params["UID"]]], '');
			$id_article = 0;
			if(count($data)){
				$id_article = $data[0]['id'];
			}
			$params['id_article'] = $id_article;
			return $this->save($params, 'article_disponibilite');

		}else{
			return 0;
		}
	}

	public function edit_disponibilite($params){
		$view = new View("article.disponibilite.edit");
		$disponibilite = $this->find('', ['conditions'=>['id='=>$params['id']]], 'article_disponibilite');
		$html = $view->render(['disponibilite'=>$disponibilite[0]]);
		return $html;
	}

	public function update_disponibilite($params){
		if($params["id"]){
			return $this->save($params, 'article_disponibilite');
		}else{
			return 0;
		}
	}

	public function check_article_disponibilite(){
		$articles = [];
		foreach($this->find('', ['conditions'=>['status='=>1], 'order'=>'date_debut'], 'article_disponibilite') as $d){
			$now = time();
			$date_debut = strtotime($d['date_debut']);
			$date_fin = strtotime($d['date_fin']);

			if($now >= $date_debut && $now <= $date_fin){
				$this->save([
					'is_new'				=>	1,
					'is_visible_on_web'		=>	1,
					'id'		=>	$d["id_article"]
				], 'article');
				$articles_ = [
					$d["id_article"] => [
						"status"		=>	'published',
						"date_debut"	=>	$date_debut . ' - ' . $now . ' - ' . floor( ($now-$date_debut) / (60 * 60 * 24) ),
						"date_fin"		=>	$date_fin . ' - ' . $now . ' - ' . floor( ($now-$date_fin) / (60 * 60 * 24) ),
					]
				];
			}else{
				$this->save([
					'is_new'	=>	0,
					'is_visible_on_web'		=>	0,
					'id'		=>	$d["id_article"]
				], 'article');
				$articles_ = [
					$d["id_article"] => [
						"status"		=>	'unpublished',
						"date_debut"	=>	$date_debut . ' - ' . $now . ' - ' . floor( ($now-$date_debut) / (60 * 60 * 24) ),
						"date_fin"		=>	$date_fin . ' - ' . $now . ' - ' . floor( ($now-$date_fin) / (60 * 60 * 24) ),
					]
				];
				$this->save([
					'status'	=>	0,
					'id'		=>	$d['id']
				], 'article_disponibilite');
			}
			array_push($articles, $articles_);
			
		}
		return count($articles);
	}

}

$article = new Article;
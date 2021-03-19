<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$core = $_SESSION["CORE"];
$table_name = "Services";
require_once($core.$table_name.".php");  
$ob = new $table_name();
$content = $ob->fetchAll();
?>

	<div class="row page_title">
		<div class="col_6-inline icon">
			<i class="fas fa-address-card"></i> <?= $table_name ?>(s)
		</div>
		<div class="col_6-inline actions <?= strtolower($table_name) ?>">
			<button class="btn btn-green save" value="<?= $table_name ?>"><i class="fas fa-save"></i> Enregistrer</button>
		</div>
		
	</div>
	<hr>
		
	<div class="debug_client"></div>


<div class="row">
	<div class="col_6 editor">
		
		<div class="panel">
			<div class="panel-header">
				<i class="fa fa-edit"></i> Article Editor
			</div>
			
			<div class="panel-content" style="padding: 0">
				<div class="panel-content-header" style="padding: 0; margin: 5px 0">
					<div class="row" style="padding: 7px 0">
						<div class="col_2-inline">
							<select id="header" style="padding: 5px 0">
								<option selected value="-1">Header</option>
								<option value="h1">H1 Header</option>
								<option value="h2">H2 Header</option>
								<option value="h3">H3 Header</option>
							</select>
						</div>	
						<div class="col_2-inline">
							<select id="style" style="padding: 5px 0">
								<option selected value="-1">Style</option>
								<option value="error">Error style</option>
								<option value="success">Success style</option>
								<option value="alert">Alert style</option>
							</select>							
						</div>
						<div class="col_2-inline">
							<select id="label" style="padding: 5px 0">
								<option selected value="-1">Label</option>
								<option value="label_red">Red</option>
								<option value="label_green">Green</option>
								<option value="label_blue">Blue</option>
								<option value="label_orange">Orange</option>
								<option value="label_default">Default</option>
							</select>							
						</div>
						<div class="col_2-inline">
							<select id="ad" style="padding: 5px 0">
								<option selected value="-1">Add Bloc</option>
								<option value="1">Responsive</option>
								<option value="2">Inline</option>
								<option value="3">Banner</option>
							</select>							
						</div>
					</div>
					
					<div class="row">
						<div class="col_12" style="padding: 0">
							<div class="btn-group" style="padding: 0">
								<button class="btn" value="bold"><i class="fa fa-bold"></i></button>
								<button class="btn" value="italic"><i class="fa fa-italic"></i></button>
								<button class="btn" value="underline"><i class="fa fa-underline"></i></button>
								<button class="btn" value="ul"><i class="fa fa-list-ul"></i></button>
								<button class="btn" value="ol"><i class="fa fa-list-ol"></i></button>
								<button class="btn" value="paragraph"><i class="fa fa-paragraph"></i></button>
								<button class="btn" value="link"><i class="fa fa-link"></i></button>
								<button class="btn" value="image"><i class="fa fa-image"></i></button>
								<button class="btn" value="br"><i class="fa fa-terminal"></i></button>
								<button class="btn" value="quotes"><i class="fa fa-quote-right"></i></button>
							</div>							
						</div>
					</div>
				</div>
				
				<textarea id="editorTextArea" style="border-radius: 0; font-size: 18px; max-width: 100%; height: 500px"><?= $content[0]["content"] ?></textarea>
			</div>
		</div>
		
	</div>
	<div class="col_6">
	
		<div class="panel">
			<div class="panel-header">
				<i class="fa fa-edit"></i> Apercu
			</div>
			<div class="panel-content">
				<article>
				<div class="apercu" style="height: 500px; width: auto; overflow: auto">
					<?= $content[0]["content"] ?>
				</div>					
				</article>

			</div>
		</div>
	
	</div>
</div>




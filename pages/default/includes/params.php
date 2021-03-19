<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$core = $_SESSION["CORE"];
$table_name = "Params";
require_once($core.$table_name.".php");  
$ob = new $table_name();
$content = $ob->fetchAll();
$data = $content[0];
//var_dump($data);
?>

<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-address-card"></i> Paramêtres
	</div>
	<div class="col_6-inline actions <?= strtolower($table_name) ?>">
		<button class="btn btn-green save" value="<?= $table_name ?>"><i class="fas fa-save"></i> Enregistrer</button>
	</div>

</div>
<hr>

<div class="row">
	<div class="col_6">
		<div class="panel">
			<div class="panel-content">
			<h3>General</h3>
				<div class="row">
					<div class="col_6">
						<label for="website_name">Nom Site Web</label>
						<input type="text" id="website_name" placeholder="Web site name" value="<?= $data["website_name"] ?>">
					</div>
					<div class="col_6">
						<span style="padding: 2px 0 0 0; display: block">Website Langue</span>
						<div class='btn-group-radio'>
							<button class='btn btn-default lang <?= ($data["website_language"] == "en")? "checked": "" ?>' value='en' style='padding:5px 7px'>English</button>
							<button class='btn btn-default lang <?= ($data["website_language"] == "ar")? "checked": "" ?>' value='ar' style='padding:5px 7px'>العربية</button>
							<button class='btn btn-default lang <?= ($data["website_language"] == "fr")? "checked": "" ?>' value='fr' style='padding:5px 7px'>Français</button>
						</div>

					</div>
				</div>
				<div class="row" style="margin-top: 11px">
					<div class="col_6">
						<label for="website_email">Email Support</label>
						<input type="email" id="website_email" placeholder="Email" value="<?= $data["support_email"] ?>">
					</div>
					<div class="col_6">
						<label for="website_phone">Téléphone Support</label>
						<input type="number" id="website_phone" placeholder="Téléphone" value="<?= $data["website_phone"] ?>">
					</div>
				</div>
				<div class="row" style="margin-top: 11px">
					<div class="col_12">
						<label for="website_description">Déscription</label>
						<input type="text" id="website_description" placeholder="Déscription" value="<?= $data["website_description"] ?>">
					</div>
				</div>

				<div class="row" style="margin-top: 11px">
					<div class="col_12">
						<label for="website_keywords">Key Words</label>
						<textarea id="website_keywords" placeholder="Keywords" style="max-width: 100%; height: 70px"><?= $data["website_keywords"] ?></textarea>
					</div>
				</div>					
			</div>
		</div>
	</div>
	<div class="col_6">
		<div class="panel">
			<div class="panel-content">
			<h3>Scripts</h3>
				<div class="row">
					<div class="col_12">
						<label for="website_google_analytics">Google Analytics</label>
						<textarea id="website_google_analytics" placeholder="Past Google Analytics Script" style="max-width: 100%; height: 120px"><?= $data["website_google_analytics"] ?></textarea>

					</div>
				</div>
				<div class="row" style="margin-top: 11px">
					<div class="col_12">
						<label for="website_facebook_pixel">Facebook Pixel</label>
						<textarea id="website_facebook_pixel" placeholder="Past Pacebook Pixel Script" style="max-width: 100%; height: 120px"><?= $data["website_facebook_pixel"] ?></textarea>

					</div>
				</div>				
			</div>
		</div>
			
	</div>
</div>

<div class="row">
	<div class="col_6">
		<div class="panel">
			<div class="panel-content">
			<h3>E-Mail Paramêtres</h3>
				<div class="row">
					<div class="col_12">
						<label for="smtp_username">Username</label>
						<input type="text" id="smtp_username" placeholder="Username" value="<?= $data["smtp_username"] ?>">
					</div>
				</div>
				<div class="row" style="margin-top: 11px">
					<div class="col_12">
						<label for="smtp_password">Mots de passe</label>
						<input type="text" id="smtp_password" placeholder="Password" value="<?= $data["smtp_password"] ?>">
					</div>
				</div>
				<div class="row" style="margin-top: 11px">
					<div class="col_12">
						<label for="smtp_host">Host</label>
						<input type="text" id="smtp_host" placeholder="host" value="<?= $data["smtp_host"] ?>">
					</div>
				</div>
				<div class="row" style="margin-top: 11px">
					<div class="col_12">
						<label for="imap">IMAP</label>
						<input type="text" id="imap" placeholder="IMAP" value="<?= $data["imap"] ?>">
					</div>
				</div>
				<div class="row" style="margin-top: 11px">
					<div class="col_12">
						<label for="port">PORT</label><br>
						<input style="width: 150px" type="number" id="port" placeholder="PORT" value="<?= $data["port"] ?>">
					</div>
				</div>
			</div>
		</div>
			
	</div>
	
	<div class="col_6">
		<div class="panel">
			<div class="panel-content">
			<h3>API(s)</h3>
				<div class="row">
					<div class="col_12">
						<label for="api_whatsapp">Whatsapp link</label>
						<textarea id="api_whatsapp" placeholder="Whatsapp api link" style="max-width: 100%; height: 70px"><?= $data["api_whatsapp"] ?></textarea>

					</div>
				</div>
				<div class="row" style="margin-top: 10px">
					<div class="col_4"><input id="api_number" value="212" type="number">  </div>
					<div class="col_6"><input id="api_msg" value="Hello World" type="text"></div>
					<div class="col_2"><button class="btn btn-default api_send">Envoyer</button></div>
				</div>
				<div class="row">
					<div class="col_12 api_result"></div>
				</div>
			</div>
		</div>
			
	</div>
</div>

<div class="debug_client"></div>





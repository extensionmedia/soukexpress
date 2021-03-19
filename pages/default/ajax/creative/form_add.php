<?php session_start(); $core = $_SESSION['CORE']; 

$formToken=uniqid();
$return_page = "Creative";
?>
<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-address-card"></i> Creative / رسالة
	</div>
	<div class="col_6-inline actions <?= strtolower($return_page) ?>">
		<button class="btn btn-green save" value="<?= $return_page ?>"><i class="fas fa-save"></i></button>
		<button class="btn btn-default close" value="<?= $return_page ?>"><i class="fas fa-times"></i></button>
	</div>
</div>
<hr>
<div class="row">
	<div class="panel">
		<div class="panel-content">
			<h3 style="margin-left: 6px"> Creative / الرسالة</h3>
			<div class="row" style="margin-bottom: 20px">
				<div class="col_6-inline">
					<label for="creative_title">Title </label>
					<input type="text" placeholder="Creative / عنوان" id="creative_title" value="">
				</div>				
			</div>	

			<div class="row" style="margin-bottom: 20px">
				<div class="col_12-inline">
					<label for="creative_body">Body / الرسالة </label>
					<textarea id="creative_body" style="max-width: 100%;height: 250px"></textarea>
				</div>				
			</div>
			
			<div class="row" style="margin-bottom: 20px">
				<div class="col_6-inline">
					<div class="" style="position: relative; width: 125px">
						<div class="on_off off" id="creative_status"></div>
						<span style="position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px">
							  Status
						</span>
					</div>
				</div>						
			</div>
		</div>
	</div>	
</div>
	


<div class="debug_client"></div>

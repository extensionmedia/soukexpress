<div class="foobar style1 hide">
	<div class="row actions">
		<div class="col_6-inline" style="margin: 0; padding: 0">
			<button class="add" value="Client">
				<i class="fas fa-user-plus"></i> Client
			</button>
		</div>	
		<div class="col_6-inline" style="margin: 0; padding: 0">
			<button>
				<i class="fas fa-plus-circle"></i> Location / Réservation
			</button>
		</div>

	</div>
</div>
<div class="support <?= ($show_support)? "": "hide" ?>">
	<div class="c hide">
		<div class="header">
			Support Technique <span class="close"><i class="fas fa-window-close"></i></span><span class="support_refresh"><i class="fas fa-sync-alt"></i></span>
		</div>
		
		<div class="display"></div>
		
		<div class="footer">
			<div class="input-group" style="overflow: hidden;">
				<input type="text" placeholder="Chercher" class="suf" name="" id="support_message">
				<div class="input-suf hide"><button title="Envoyer" id="support_send"><i class="fas fa-share-square"></i></button></div>
			</div>
		</div>		
	</div>

	<div class="icon">
		<span class="badge">0</span>
		<i class="fas fa-headset"></i>
	</div>
</div>
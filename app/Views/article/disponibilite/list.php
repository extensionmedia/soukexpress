<div class="col_12" style="padding: 0">
    <div class="panel" style="overflow: auto;">
        <div class="panel-content" style="padding: 0">
		    <table class="table">
		        <thead>
		            <tr>
                        <th class="text-center">Date Debut</th>
                        <th class="text-center">Date Fin</th>
                        <th class="text-center">Badget</th>
                        <th class="text-center">Auto</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Actions</th>
			        </tr>
		        </thead>
		        <tbody>
                    <?php foreach($data as $d): ?>
                    <tr class="border h-10">
                        <td class="text-center"><div class="font-bold text-green-400" style="font-size:16px"><?= $d['date_debut'] ?></div></td>
                        <td class="text-center"><div class="font-bold text-red-400" style="font-size:16px"><?= $d['date_fin'] ?></div></td>
                        <td class="text-center"><div class='on_off <?= $d['is_show_badge']? 'on': 'off' ?> is_show_badge mx-auto'></div></td>
                        <td class="text-center"><div class='on_off <?= $d['is_auto_live']? 'on': 'off' ?> is_auto_live mx-auto'></div></td>
                        <td class="text-center w-32">
                            <?php if($d['status']): ?> 
                                <div class="bg-green-200 rounded-lg py-1 px-3 text-green-800 border border-green-400 text-sm w-24 mx-auto">Activé</div>
                            <?php else: ?> 
                                <div class="bg-red-200 rounded-lg py-1 px-3 text-red-800 border border-red-400 text-sm w-24 mx-auto">Desactivé</div>
                            <?php endif ?>
                        </td>
                        <td class="text-right w-32">
                            <button value="<?= $d['id'] ?>" class="distroy_disponibilite bg-red-500 hover:bg-red-700 rounded px-2 py-1 text-red-100">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                            <button value="<?= $d['id'] ?>" class="edit_disponibilite bg-gray-300 hover:bg-gray-400 rounded px-2 py-1">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </td>
					</tr>
                    <?php endforeach ?>
		        </tbody>
		    </table>
		</div>
	</div">
</div>
<script>
    $(document).ready(function(){
        $('.distroy_disponibilite').on('click', function(){
            var that = $(this);

            swal({
			  title: "Vous êtes sûr?",
			  text: "Êtes vous sûr de vouloir supprimer cette ligne? ",
				type:"warning",
				showCancelButton:!0,
				confirmButtonColor:"#3085d6",
				cancelButtonColor:"#d33",
				confirmButtonText:"Oui, Supprimer!"
			}).then(function(t){
			  if (t.value) {
                var data = {
                    'method'		:	'distroy_disponibilite',
                    'controler'		:	'Article',
                    'params'		:	{
                        'id'	:	that.val()
                    }
                }
                
                $.ajax({
                    type		: 	"POST",
                    url			: 	"pages/default/ajax/Ajax.php",
                    data		:	data,
                    dataType	: 	"json",
                }).done(function(response){
                    $('.refresh_article_disponibilite').trigger('click');
                }).fail(function(xhr){
                    alert("Error");
                    console.log(xhr.responseText);
                });	
			  }
		});






        })
    });
</script>
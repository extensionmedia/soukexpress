<div class='panel p-0 m-0 container_article_disponibilite' style='overflow:auto; width:100%; z-index: 999999'>
    <div class='panel-header flex justify-between' style='padding-right:0'>
        Article Disponibilite
        <span class='pt-2 pr-2'>
            <button class='close_me py-1 px-2 bg-red-500 text-white rounded'><i class="fas fa-times"></i></button>
        </span>
    </div>
    <div class='panel-content pt-6'>
            
        <div class='flex'>
            <div class='col_6-inline'>
                <label for='date_debut'>Date Début</label>	
                <input style='text-align:center; font-size:14px; font-weight:bold' id='date_debut' type='date' value="<?= $disponibilite['date_debut'] ?>">
                <input type="hidden" value="<?= $disponibilite['id'] ?>" id="id">
            </div>	

            <div class='col_6-inline'>
                <label for='date_fin'>Date Fin</label>	
                <input style='text-align:center; font-size:14px; font-weight:bold' id='date_fin' type='date' value="<?= $disponibilite['date_fin'] ?>">
            </div>				
        </div>
            
        <div class='row px-3' style='margin-top: 20px'>
            <div class='col_12'>
                <div style='position: relative; width: 165px'>
                    <div class='on_off <?= $disponibilite['is_show_badge']? 'on': 'off' ?>' id='is_show_badge'></div>
                    <span style='position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px'>
                        Afficher Badge
                    </span>
                </div>
            </div>					
        </div>
            
        <div class='row px-3' style='margin-top: 20px'>
            <div class='col_12'>
                <div style='position: relative; width: 165px'>
                    <div class='on_off <?= $disponibilite['is_auto_live']? 'on': 'off' ?>' id='is_auto_live'></div>
                    <span style='position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px'>
                        Publier auto
                    </span>
                </div>
            </div>					
        </div>
            
        <div class='row px-3' style='margin-top: 20px'>
            <div class='col_12'>
                <div style='position: relative; width: 165px'>
                    <div class='on_off <?= $disponibilite['status']? 'on': 'off' ?>' id='status'></div>
                    <span style='position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px'>
                       Active
                    </span>
                </div>
            </div>					
        </div>
    
        <div class='row' style='margin-top:20px; padding:10px 0;background: #fafafa; border-top:#ccc 1px solid '>
            <div class='col_6-inline'>
                <button class='btn btn-green save_article_disponibilite'><i class='fas fa-save'></i> Enregistrer</button>
            </div>
        </div>
            
    </div>
</div>

<script>
    $(document).ready(function(){

        $('.close_me').on('click', function(){
            $('.container_article_disponibilite').remove();
            $('.modal').removeClass('show');
        })

        $('.save_article_disponibilite').on('click', function(){
            var _continue = true;
            $('.error').remove();
            if(!$("#date_debut").val()){
                _continue = false;
                $("#date_debut").parent().append('<div class="error text-red-500 text-xs">Valeur obligatoir</div>');
            }
            if(!$("#date_fin").val()){
                _continue = false;
                $("#date_fin").parent().append('<div class="error text-red-500 text-xs">Valeur obligatoir</div>');
            }
            if(_continue){
                var params = {
                    id              :   $("#id").val(),
                    date_debut      :   $("#date_debut").val(),
                    date_fin        :   $("#date_fin").val(),
                    is_show_badge   :   $("#is_show_badge").hasClass('on')? 1:0,
                    is_auto_live    :   $("#is_auto_live").hasClass('on')? 1:0,
                    status          :   $("#status").hasClass('on')? 1:0,
                }

                var data = {
                    'method'		:	'update_disponibilite',
                    'controler'		:	'Article',
                    'params'		:	params
                }
                var that = $(this);
                $.ajax({
                    type		: 	"POST",
                    url			: 	"pages/default/ajax/Ajax.php",
                    data		:	data,
                    dataType	: 	"json",
                }).done(function(response){
                    $('.refresh_article_disponibilite').eq(1).trigger('click');
                    $('.close_me').trigger('click');
                }).fail(function(xhr){
                    alert("Error");
                    console.log(xhr.responseText);
                });

            }
        })
    });
</script>
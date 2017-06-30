<?php
require_once dirname(__DIR__).'/tools/core.php';
sys_set_module(__DIR__);
sys_load_md('function');
$cidades = get_cidade_all();

?>
<div class="row">
	<div class="col-lg-12">
		<?php foreach($cidades as $cod => $cidade){ ?>
		<button type="button" class="btn btn-sm btn-default prev-clima" data-cidade="<?=$cod?>"><?=$cidade?></button> 
	    <?php } ?> 
    </div>
</div>
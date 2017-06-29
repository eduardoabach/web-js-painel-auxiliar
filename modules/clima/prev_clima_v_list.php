<?php 
	require_once dirname(__DIR__).'/tools/core.php';
	sys_set_module(__DIR__);

?>
<div class="row">
	<div class="col-lg-12">
	    <strong><?=$nome_cidade?></strong>
	    <small><?=(isset($previsao_data)) ? '(Atualização: '.date_to_user($previsao_data).')' : ''?></small>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <table class="table table-hover table-condensed">
	    	<thead>
	    		<tr>
	    			<td width="70px" align="center">Data</td>
	    			<td width="30px"></td>
	    			<td width="60px" align="center">Temp.</td>
	    			<td>Clima</td>
	    			<td></td>
	    			<td width="100px" align="center">UV</td>
	    			<td width="30px" align="center">Lua</td>
	    		</tr>
	    	</thead>
	    	<tbody>
	    		<?php
	    		if(isset($list_dias)){
		    		foreach($list_dias as $diaInf){
		    			sys_load_view_md('prev_clima_v_row', $diaInf);
		    		}
	    		}
	    		?>
	    	</tbody>
		</table>
    </div>
</div>


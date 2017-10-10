<?php
	require_once dirname(__DIR__).'/tools/core.php';
	sys_set_module(__DIR__);

	$dataUser = date_to_user($dia);
	$dataArr = data_to_array($dia);
	$nomeMes = get_nome_mes_ano($dataArr['mes']);
?>
<tr>
	<td align="center" title="<?=$dataUser?>">
		<button type="button" class="btn btn-sm btn-default info-dia" data-dia="<?=$dia?>">
		<?=$dataArr['dia']?><br>
		<?=$nomeMes?>	
		</button> 
	</td>
	<td><?=get_dia_da_semana($dia, 3)?></td>
	<td align="center">
		<strong style="color:<?=$minima_cor?>"><?=$minima?></strong>~
		<strong style="color:<?=$maxima_cor?>"><?=$maxima?></strong>
	</td>
	<td data-descricao="<?=$tempo_inf['descricao']?>">
		<?=$tempo_inf['nome']?>		
	</td>
	<td align="center">
		<img width="55" height="37" src='<?=$tempo_img?>'>
	</td>
	<td align="center">
		<strong title="RISCO <?=$iuv_info['risco']?>" style="color:<?=$iuv_info['cor']?>"><?=(int)$iuv?></strong>
		<?=round($lua['fase']*2,4)?>
	</td>
	<td align="center">
		<div class="lua-fase" data-fase="0.9" data-size="30" title="<?=$lua['descricao']?>"></div>
	</td>
</tr>
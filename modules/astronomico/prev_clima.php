<?php 
require_once dirname(__DIR__).'/tools/core.php';
sys_set_module(__DIR__);
sys_load_tool('tempo');
sys_load_md('function');

$idCidade = (isset($_POST['id_cidade'])) ? $_POST['id_cidade'] : false;
if(!($idCidade > 0)){
	echo 'Código da cidade incorreto.';
	return false;
}

$nomeCidade = get_nome_cidade($idCidade);
$dataRef = date('Y-m-d');

$qtdDiasVerif = 7;
$listDatas = list_days_add($dataRef, $qtdDiasVerif);
$listInfo = array();
foreach($listDatas as $dia){
	$listInfo[$dia]['dia'] = $dia;
}

/* PREVISÃO DO TEMPO ------------ */
sys_load_md_api('inpe_webservice');
$inpeServ = new inpe_webservice();
$previsaoTempo = $inpeServ->get_previsao_tempo_cidade($idCidade);
if(isset($previsaoTempo['dias'])){
	$listInfo = array_merge($listInfo, $previsaoTempo['dias']);
}
// pensar em usar a $previsaoTempo['atualizacao']
/* ------------------------------ */

?>

<div class="row">
	<div class="col-lg-12">
	    <strong><?=$nomeCidade?> aaaa</strong>
	    <small><?=(isset($previsaoTempo['atualizacao'])) ? '(Atualização: '.date_to_user($xmlOb->atualizacao).')' : ''?></small>
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
	    		foreach($listInfo as $diaInf){

					$dataUser = date_to_user($diaInf['dia']);
					$dataArr = data_to_array($diaInf['dia']);
					$nomeMes = get_nome_mes_ano($dataArr['mes']);

					//ajustar a lua para usar o astronomico apenas, func para monstar desc, conceitos de fases em ptbr tbm
					//passar a usar dados do astronomico

					// ASTRONOMICO, Lua / Sol
					$infoAstr = get_astronomico(trim($diaInf['dia']));
					$faseDaLuaAstr = round($infoAstr['lua']['fase'], 4);
					$descLuaAstr = $infoAstr['lua']['fase'];

					// IUV
	    			$infoUv = get_oms_indice_uv(trim($diaInf['iuv']));
					$corUv = $infoUv['cor'];

					// TEMPERATURA
					$corTempMin = get_cor_temperatura($diaInf['minima']);
					$corTempMax = get_cor_temperatura($diaInf['maxima']);
					?>
					<tr>
						<td align="center" title="<?=$dataUser?>">
							<button type="button" class="btn btn-sm btn-default info-dia" data-dia="<?=trim($diaInf['dia'])?>">
							<?=$dataArr['dia']?><br>
							<?=$nomeMes?>	
							</button> 
						</td>
						<td><?=get_dia_da_semana($diaInf['dia'], 3)?></td>
						<td align="center">
							<strong style="color:<?=$corTempMin?>"><?=$diaInf['minima']?></strong>~
							<strong style="color:<?=$corTempMax?>"><?=$diaInf['maxima']?></strong>
						</td>
						<td data-descricao="<?=$diaInf['tempo_inf']['descricao']?>">
							<?=$diaInf['tempo_inf']['nome']?>		
						</td>
						<td align="center">
							<img width="55" height="37" src='<?=get_inpe_img_clima_sigla(trim($diaInf['tempo']))?>'>
						</td>
						<td align="center">
							<strong title="RISCO <?=$infoUv['risco']?>" style="color:<?=$infoUv['cor']?>"><?=(int)$diaInf['iuv']?></strong>
						</td>
						<td align="center">
							<div class="lua-fase" data-fase="<?=$faseDaLuaAstr?>" data-size="30" title="<?=$descLuaAstr?>"></div>
						</td>
					</tr>
					<?php
	    		}
	    		?>
	    	</tbody>
		</table>
    </div>
</div>


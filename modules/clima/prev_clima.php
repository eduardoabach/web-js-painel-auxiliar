<?php 
require dirname(__DIR__).'/tools/core.php';
sys_set_module(__DIR__);
sys_load_tool('tempo');
sys_load_md('function');

$idCidade = (isset($_POST['id_cidade'])) ? $_POST['id_cidade'] : false;
if(!($idCidade > 0)){
	echo 'Código da cidade incorreto.';
	return false;
}

$dataRef = date('Y-m-d');
$qtdDiasVerif = 7;
$listDias = array();
for($i=0;$i<$qtdDiasVerif;$i++){
	if($i > 0)
		$dataRef = add_days($dataRef,1);
	$listDias[$dataRef]['dia'] = $dataRef;
}

sys_load_md_api('inpe_webservice');
$inpeServ = new inpe_webservice();
$previsaoTempo = $inpeServ->get_previsao_tempo_cidade($idCidade);

if(isset($previsaoTempo['dias'])){
	$listDias = array_merge($listDias, $previsaoTempo['dias']);
}

// pr($listDias);
// die('a');

// $infoUv = get_oms_indice_uv(trim($inf['iuv']));
// $corUv = $infoUv['cor'];
// $corTempMin = get_cor_temperatura($diaPrev->minima);
// $corTempMax = get_cor_temperatura($diaPrev->maxima);

//get_dia_da_semana($diaPrev->dia, 3)
//$infoUv['risco']
//$infoUv['cor']
//$diaPrev->iuv
//get_inpe_img_clima_sigla(trim($diaPrev->tempo))


//ver
// http://www.flextool.com.br/tabela_cores.html
// http://astropbi.blogspot.com.br/2009/09/fases-da-lua.html
// https://github.com/codebox/js-planet-phase/blob/master/planet_phase.js
// https://github.com/codebox/js-planet-phase/blob/master/planet_phase.html
// http://codebox.org.uk/pages/html-moon-planet-phases

// #webservice previsao do tempo
// http://servicos.cptec.inpe.br/XML/listaCidades?city=porto%20alegre // para buscar cods
// http://servicos.cptec.inpe.br/XML/listaCidades // 237 = poa, 5092 sapirang, 1929 estancia velha, 3591 nh, 4969 sao leo
// http://servicos.cptec.inpe.br/XML/cidade/3591/previsao.xml // previsao do tempo prox 4 dias
// http://servicos.cptec.inpe.br/XML/cidade/7dias/3591/previsao.xml // previsao do tempo prox 7 dias
// http://servicos.cptec.inpe.br/XML/cidade/7dias/-22.90/-47.06/previsaoLatLon.xml // 7 dias para latitudo e longitude, pegando a cidade mais proxima
// http://servicos.cptec.inpe.br/XML/cidade/3591/estendida.xml // 7 dias depois dos 7 normais, totalizando 14 dias de previsao
// http://servicos.cptec.inpe.br/XML/#estacoes-metar

$page = download_page('http://servicos.cptec.inpe.br/XML/cidade/7dias/'.$idCidade.'/previsao.xml');
$xmlOb = new SimpleXMLElement($page);

// criar array de datas autonomo, sistema ficar independente de webservice, internet

?>

<div class="row">
	<div class="col-lg-12">
	    <strong><?=$xmlOb->nome.', '.$xmlOb->uf?></strong> <small>(Atualização: <?=date_to_user($xmlOb->atualizacao)?>)</small>
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
	    		foreach($listDias as $diaInf){

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


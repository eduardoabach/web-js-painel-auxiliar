<?php 

include('./function.php');
include('../tools/utilidades.php');
include('../tools/tempo.php');

$idCidade = (isset($_POST['id_cidade'])) ? $_POST['id_cidade'] : false;
if(!($idCidade > 0)){
	echo 'Código da cidade incorreto.';
	return false;
}


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

?>

<div id="teste-lua"></div>

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
	    		if(isset($xmlOb->previsao)){
					foreach($xmlOb->previsao as $diaPrev){
						$siglaDesc = get_inpe_cond_tempo(trim($diaPrev->tempo));
						$clima = ($siglaDesc !== false) ? $siglaDesc : '';
						$infoUv = get_oms_indice_uv(trim($diaPrev->iuv));

						$dataUser = date_to_user($diaPrev->dia);
						$dataArr = data_to_array($diaPrev->dia);
						$nomeMes = get_nome_mes_ano($dataArr['mes']);

						$faseDaLua = fases_lua($diaPrev->dia);

						$corUv = $infoUv['cor'];
						$corTempMin = get_cor_temperatura($diaPrev->minima);
						$corTempMax = get_cor_temperatura($diaPrev->maxima);
						?>
						<tr>
							<td align="center" title="<?=$dataUser?>">
								<?=$dataArr['dia']?><br>
								<?=$nomeMes?>
							</td>
							<td><?=get_dia_da_semana($diaPrev->dia, 3)?></td>
							<td align="center">
								<strong style="color:<?=$corTempMin?>"><?=$diaPrev->minima?></strong>~
								<strong style="color:<?=$corTempMax?>"><?=$diaPrev->maxima?></strong>
							</td>
							<td data-descricao="<?=$clima['descricao']?>">
								<?=$clima['nome']?>		
							</td>
							<td align="center">
								<img width="55" height="37" src='<?=get_inpe_img_clima_sigla(trim($diaPrev->tempo))?>'>
							</td>
							<td align="center">
								<strong title="RISCO <?=$infoUv['risco']?>" style="color:<?=$infoUv['cor']?>"><?=(int)$diaPrev->iuv?></strong>
							</td>
							<td align="center">
								<script>
								</script>
							</td>
						</tr>
						<?php
					}
				}
	    		?>
	    	</tbody>
		</table>
    </div>
</div>


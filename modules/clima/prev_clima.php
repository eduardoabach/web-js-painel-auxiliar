<?php 

include('./function.php');
include('../tools/utilidades.php');
include('../tools/tempo.php');

$idCidade = (isset($_POST['id_cidade'])) ? $_POST['id_cidade'] : false;
if(!($idCidade > 0)){
	echo 'Código da cidade incorreto.';
	return false;
}

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
	    			<td width="100px" align="center">UV</td>
	    			<td></td>
	    		</tr>
	    	</thead>
	    	<tbody>
	    		<?php
	    		if(isset($xmlOb->previsao)){
					foreach($xmlOb->previsao as $diaPrev){
						$siglaDesc = get_inpe_cond_tempo(trim($diaPrev->tempo));
						$clima = ($siglaDesc !== false) ? $siglaDesc : '';
						$infoUv = get_oms_indice_uv(trim($diaPrev->iuv));
						$corUv = $infoUv['cor'];
						?>
						<tr>
							<td align="center"><?=date_to_user($diaPrev->dia)?></td>
							<td><?=get_dia_da_semana($diaPrev->dia, 3)?></td>
							<td align="center"><?=$diaPrev->minima?>~<?=$diaPrev->maxima?></td>
							<td data-descricao="<?=$clima['descricao']?>">
								<?=$clima['nome']?>		
							</td>
							<td align="center">
								<?=(int)$diaPrev->iuv?><br>
								<small><?=$infoUv['risco']?></small>
							</td>
							<td align="center">
								<img width="55" height="37" src='<?=get_inpe_img_clima_sigla(trim($diaPrev->tempo))?>'>
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


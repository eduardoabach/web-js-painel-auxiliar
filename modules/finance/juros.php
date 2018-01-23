<?php
ini_set("soap.wsdl_cache_enabled", "0"); // vamos evitar que o arquivo WSDL seja colocado no cache
$WsSOAP = new SoapClient("./web-service/bcb_FachadaWSSGS.wsdl");


function buscar_ws($WsSOAP, $cod){
	$respostWS = $WsSOAP->getUltimoValorXML($cod); 
	if ($respostWS){
		$loadWS = simplexml_load_string($respostWS);
		// $nome = str_replace('Taxa de câmbio - Livre - ','',utf8_decode($loadWS->SERIE->NOME));
		// $uniade = $loadWS->SERIE->UNIDADE;
		// $dataRef = $loadWS->SERIE->DATA->DIA.'/'.$loadWS->SERIE->DATA->MES.'/'.$loadWS->SERIE->DATA->ANO;
		return $loadWS->SERIE->VALOR;
	}
	return false;
}

$regList = array(
	'Taxa de juros - Meta Selic' => array('percent_m'=>'432'),
	'Selic acumulada no mês anualizada' => array('percent_m'=>'4189'),
	'Taxa de juros - Taxa Referencial (TR)' => array('percent_m'=>'7811'),
	'Dí­vida externa bruta/PIB (%) - anual' => array('percent_m'=>'11418'),

	'Salário mí­nimo' => array('c'=>'1619'),
	'Cesta básica' => array('c'=>'206'),
	'Cesta básica - São Paulo' => array('c'=>'7493'),
	'Cesta básica - Porto Alegre' => array('c'=>'7489'),

	'Meta para a inflação' => array('percent_m'=>'13521'),
	'Índice nacional de preços (IPCA)' => array('percent_m'=>'433'),
	
	'Inflação - Venezuela (2005=100)' => array('percent_m'=>'7733'),
	'Inflação - Alemanha (2005=100)' => array('percent_m'=>'3792'),
	'Inflação - Canadá (2005=100)' => array('percent_m'=>'3793'),
	'Inflação - Estados Unidos (2005=100)' => array('percent_m'=>'3794'),
	'Inflação - Japão (2005=100)' => array('percent_m'=>'3797'),
	'Inflação - Argentina (2005=100)' => array('percent_m'=>'3800'),
	'Inflação - Coréia do Sul (2005=100)' => array('percent_m'=>'3802'),

	'Taxa de desemprego - Por setor de atividade - Total (no mês)' => array('percent_m'=>'1629'),
	'Taxa de desemprego - Estados Unidos' => array('percent_m'=>'3787'),
	'Taxa de desemprego - Alemanha' => array('percent_m'=>'3785'),
	'Taxa de desemprego - Canadá' => array('percent_m'=>'3786'),
	'Taxa de desemprego - Japão' => array('percent_m'=>'3790')
);
?>

<div class="row">
	<div class="col-lg-12">
	    <table class="table table-hover table-condensed">
	    	<thead>
	    		<tr>
	    			<th>Nome</th>
	    			<th>Valor</th>
	    			<th>%</th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    	<?php 
				foreach($regList as $nome => $it){
					$compra = (isset($it['c']) && $it['c'] > 0) ? 'R$ '.buscar_ws($WsSOAP, $it['c']) : false;
					$percMensal = (isset($it['percent_m']) && $it['percent_m'] > 0) ? buscar_ws($WsSOAP, $it['percent_m']).'%' : false;
					?>
					<tr>
						<td><?=$nome?></td>
						<td><?=$compra?></td>
						<td><?=$percMensal?></td>
					</tr>
					<?php
				}
	    	?>
	    	</tbody>
		</table>
    </div>
</div>


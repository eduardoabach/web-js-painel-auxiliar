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

$moedList = array(
	'Dólar' => array('v'=>'1', 'c'=>'10813', 'percent_m'=>'7831'),
	'Dólar Australiano' => array('v'=>'21633', 'c'=>'21634'),

	'Dólar Canadense' => array('v'=>'21635', 'c'=>'21636'),
	'Euro' => array('v'=>'21619', 'c'=>'21620'),
	'Libra esterlina' => array('v'=>'21623', 'c'=>'21624'),
	'Iene' => array('v'=>'21621', 'c'=>'21622'),
	'Franco Suíço' => array('v'=>'21625', 'c'=>'21626'),
	'Coroa Dinamarquesa' => array('v'=>'21627', 'c'=>'21628'),
	'Coroa Norueguesa' => array('v'=>'21629', 'c'=>'21630'),
	'Coroa Sueca' => array('v'=>'21631', 'c'=>'21632'),

	'Ouro' => array('c'=>'4', 'percent_m'=>'7830'),
	'Ibovespa' => array('c'=>'7845', 'percent_m'=>'7832')

	// '7846' => 'Dow Jones NYSE - í­ndice mensal',
	// '7809' => 'Dow Jones NYSE - í­ndice',
	// '7847' => 'Nasdaq - í­ndice mensal',
	// '7810' => 'Nasdaq - í­ndice',
	//Código: 18438 => Cotação de moeda (fim de perí­odo) - Rublo russo
);
?>

<div class="row">
	<div class="col-lg-12">
	    <table class="table table-hover table-condensed">
	    	<thead>
	    		<tr>
	    			<th>Nome</th>
	    			<th>Compra</th>
	    			<th>Venda</th>
	    			<th>% mensal</th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    	<?php 
				foreach($moedList as $nome => $it){
					$compra = (isset($it['c']) && $it['c'] > 0) ? 'R$ '.buscar_ws($WsSOAP, $it['c']) : false;
					$venda = (isset($it['v']) && $it['v'] > 0) ? 'R$ '.buscar_ws($WsSOAP, $it['v']) : false;
					$percMensal = (isset($it['percent_m']) && $it['percent_m'] > 0) ? buscar_ws($WsSOAP, $it['percent_m']).'%' : false;
					?>
					<tr>
						<td><?=$nome?></td>
						<td><?=$compra?></td>
						<td><?=$venda?></td>
						<td><?=$percMensal?></td>
					</tr>
					<?php
				}
	    	?>
	    	</tbody>
		</table>
    </div>
</div>


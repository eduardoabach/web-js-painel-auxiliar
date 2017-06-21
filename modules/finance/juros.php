<?php
ini_set("soap.wsdl_cache_enabled", "0"); // vamos evitar que o arquivo WSDL seja colocado no cache
$WsSOAP = new SoapClient("./web-service/bcb_FachadaWSSGS.wsdl");
$ParametroPesquisa = "getUltimoValorXML";

$moedList = array(
	'1' => 'Dólar (v)',
	'10813' => 'Dólar (c)',
	'7831' => 'Dólar (c) (m.%)',
	'21633' => 'Dólar Australiano (v)',
	'21634' => 'Dólar Australiano (c)',
	'21635' => 'Dólar Canadense (v)',
	'21636' => 'Dólar Canadense (c)',
	'21619' => 'Euro (v)',
	'21620' => 'Euro (c)',
	'21623' => 'Libra esterlina (v)',
	'21624' => 'Libra esterlina (c)',
	'21621' => 'Iene (v)',
	'21622' => 'Iene (c)',
	'21625' => 'Franco Suíço (v)',
	'21626' => 'Franco Suíço (c)',
	'21627' => 'Coroa Dinamarquesa (v)',
	'21628' => 'Coroa Dinamarquesa (c)',
	'21629' => 'Coroa Norueguesa (v)',
	'21630' => 'Coroa Norueguesa (c)',
	'21631' => 'Coroa Sueca (v)',
	'21632' => 'Coroa Sueca (c)',
	'206' => 'Cesta básica',
	'1619' => 'Salário mí­nimo',
	'7830' => 'Ouro (m.%)'
);


/*

432 => Taxa de juros - Meta Selic definida pelo Copom
4189 => Taxa de juros - Selic acumulada no mês anualizada
4390 => Taxa de juros - Selic acumulada no mês

433 => Índice nacional de preços ao consumidor-amplo (IPCA)
4391 => Taxa de juros - CDI acumulada no mês
4393 => Índice de Confiança do Consumidor
4394 => Índice de Condições Econômicas Atuais
4395 => Índice de Expectativas Futuras
7348 => Cesta básica - São Paulo (diária)
7489 => Cesta básica - Porto Alegre
7733 => Índice de preços ao consumidor (2005=100) - Venezuela
7846 => Dow Jones NYSE - í­ndice mensal
7809 => Dow Jones NYSE - í­ndice
7847 => Nasdaq - í­ndice mensal
7810 => Nasdaq - í­ndice

7832 => Ibovespa - Variação percentual mensal
7845 => Bovespa - í­ndice mensal
13521 => Meta para a inflação
*/


// 21774 População

foreach($moedList as $cod => $it){
	$respostWS = $WsSOAP->$ParametroPesquisa($cod); 
	if ($respostWS){
		$loadWS = simplexml_load_string($respostWS);
		$valor = $loadWS->SERIE->VALOR;
		// $nome = str_replace('Taxa de câmbio - Livre - ','',utf8_decode($loadWS->SERIE->NOME));
		// $uniade = $loadWS->SERIE->UNIDADE;
		// $dataRef = $loadWS->SERIE->DATA->DIA.'/'.$loadWS->SERIE->DATA->MES.'/'.$loadWS->SERIE->DATA->ANO;
		?>
		<div class="row">
			<div class="col-lg-6"><?=$it?></div>
			<div class="col-lg-6 text-right">R$ <?=$valor?></div>
		</div>
		<?php
	}
}
?>


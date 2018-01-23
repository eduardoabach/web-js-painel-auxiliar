<?php
include('../tools/utilidades.php');
include('../tools/numeros.php');

//outras e fonte br, implementar no futuro
//https://www.mercadobitcoin.net/api/v2/ticker_litecoin/
$blockchainBitcoinUsd = download_page('https://blockchain.info/frombtc?currency=USD&value=100000000&format=json');
// $blockchainBitcoinBrl = download_page('https://blockchain.info/frombtc?currency=BRL&value=100000000&format=json');

$mercadoBitecoin = json_decode(download_page('https://www.mercadobitcoin.net/api/v2/ticker/'), true);
$mercadoLitecoin = json_decode(download_page('https://www.mercadobitcoin.net/api/v2/ticker_litecoin/'), true);
?>
<div class="row">
	<div class="col-lg-12">
	    <table class="table table-hover table-condensed">
	    	<thead>
	    		<tr>
	    			<th>Moeda</th>
	    			<th>Compra</th>
	    			<th>Venda</th>
	    			<th>Flutuação</th>
	    		</tr>
	    	</thead>
	    	<tbody>
				<tr>
					<td>Bitcoin (Dólar)<br>blockchain.info</td>
					<td>U$<?=$blockchainBitcoinUsd?></td>
					<td>U$<?=$blockchainBitcoinUsd?></td>
					<td></td>
				</tr>
				<tr>
					<td>Bitcoin (Real)<br>mercadobitcoin.net</td>
					<td>R$<?=$mercadoBitecoin['ticker']['buy']?> </td>
					<td>R$<?=$mercadoBitecoin['ticker']['sell']?> </td>
					<td>R$<?=$mercadoBitecoin['ticker']['low']?> ~ R$<?=$mercadoBitecoin['ticker']['high']?></td>
				</tr>
				<tr>
					<td>Litcoin (Real)<br>mercadobitcoin.net</td>
					<td>R$<?=$mercadoLitecoin['ticker']['buy']?> </td>
					<td>R$<?=$mercadoLitecoin['ticker']['sell']?> </td>
					<td>R$<?=$mercadoLitecoin['ticker']['low']?> ~ R$<?=$mercadoLitecoin['ticker']['high']?></td>
				</tr>
	    	</tbody>
		</table>
    </div>
</div>

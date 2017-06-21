<?php
include('../tools/utilidades.php');
include('../tools/numeros.php');

//outras e fonte br, implementar no futuro
//https://www.mercadobitcoin.net/api/v2/ticker_litecoin/
$bitcoinUsd = download_page('https://blockchain.info/frombtc?currency=USD&value=100000000&format=json');
$bitcoinBRL = download_page('https://blockchain.info/frombtc?currency=BRL&value=100000000&format=json');

?>

<div class="row">
	<div class="col-lg-6">1 bitcoin = U$<?=$bitcoinUsd?></div>
	<div class="col-lg-6">1 bitcoin = R$<?=$bitcoinBRL?></div>
</div>


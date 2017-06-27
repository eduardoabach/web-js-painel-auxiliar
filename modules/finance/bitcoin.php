<?php
include('../tools/utilidades.php');
include('../tools/numeros.php');

//outras e fonte br, implementar no futuro
//https://www.mercadobitcoin.net/api/v2/ticker_litecoin/
$bitcoinUsd = download_page('https://blockchain.info/frombtc?currency=USD&value=100000000&format=json');
$bitcoinBRL = download_page('https://blockchain.info/frombtc?currency=BRL&value=100000000&format=json');

$litecoinBRL = json_decode(download_page('https://www.mercadobitcoin.net/api/v2/ticker_litecoin/'),true); // true do json_decode para criar array

?>
<div class="row">
	<div class="col-lg-4">Bitcoin</div>
	<div class="col-lg-4">R$ <?=$bitcoinBRL?></div>
	<div class="col-lg-4">U$ <?=$bitcoinUsd?></div>
</div>
<div class="row">
	<div class="col-lg-4">Litecoin</div>
	<div class="col-lg-4">R$<?=(isset($litecoinBRL['ticker']['last'])) ? number_to_user($litecoinBRL['ticker']['last']) : ''?></div>
	<div class="col-lg-4"></div>
</div>


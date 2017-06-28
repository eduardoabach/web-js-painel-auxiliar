<?php
require dirname(__DIR__).'/tools/core.php';
sys_set_module(__DIR__);
sys_load_tool('tempo');

$dataDia = (isset($_POST['data_dia'])) ? $_POST['data_dia'] : false;
if($dataDia === false || !is_date_db($dataDia)){
	echo 'Data inválida.';
	return false;
}

$dataUser = date_to_user($dataDia);
$dataArr = data_to_array($dataDia);
$nomeMes = get_nome_mes_ano($dataArr['mes']);

// PREVISAO DO TEMPO
sys_load_api('clima','inpe_webservice');
$inpeServ = new inpe_webservice();
$previsaoTempo = $inpeServ->get_previsao_tempo_cidade(5092);

// ASTRONOMICO
// $infoAstr = get_astronomico(trim($dataDia));
// $faseDaLuaAstr = round($infoAstr['lua']['fase'], 4);
// $descLuaAstr = $infoAstr['lua']['fase'];

// $segDia = 86400; //24*60*60
// $segCivMadrug = round(hora_to_segundos($infoAstr['luz_dia_civ']['ini']) * 100 / 86400); // vai ir até esse momento
// $segCivDia = round($infoAstr['luz_dia_civ']['segundos'] * 100 / 86400);
// $segCivNoite = 100 - $segCivMadrug - $segCivDia;

/*
	<td>Civil</td>
	<td colspan="6">
		<div class="progress progress-slim">
		  <div class="progress-bar" style="width: <?=$segCivMadrug?>%; background-color: #9400D3">
		    <span class="sr-only">Madrugada</span>
		  </div>
		  <div class="progress-bar progress-bar-striped" style="width: <?=$segCivDia?>%; background-color: #DAA520">
		    <span class="sr-only">Dia</span>
		  </div>
		  <div class="progress-bar" style="width: <?=$segCivNoite?>%; background-color: #9400D3;">
		    <span class="sr-only">Noite</span>
		  </div>
		</div>
	</td>*/

?>
<div class="row">
	<div class="col-lg-12">
	    Data: <?=$dataUser?>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
    </div>
</div>

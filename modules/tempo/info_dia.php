<?php
require_once dirname(__DIR__).'/tools/core.php';
sys_set_module(__DIR__);

$dataDia = (isset($_POST['data_dia'])) ? $_POST['data_dia'] : false;
if($dataDia === false || !is_date_db($dataDia)){
	echo 'Data inválida.';
	return false;
}

$dataTime = new DateTime($dataDia);
$dataUser = date_to_user($dataDia);
$dataArr = data_to_array($dataDia);
$nomeMes = get_nome_mes_ano($dataArr['mes']);

// ANO *******************************************************************************************

$dataAnoIni = $dataArr['ano'].'-01-01';
$dataAnoFim = $dataArr['ano'].'-12-31';
$dTAnoIni = new DateTime($dataAnoIni);
$dTAnoFim = new DateTime($dataAnoFim);
$anoBissexto = $dataTime->format('L');
$diasAno = $anoBissexto ? 366 : 365;
$diasAnoPassado = dias_entre_datas($dataAnoIni, $dataDia);
$diasAnoPerc = $diasAnoPassado/$diasAno*100;

$diasAnoUteis = get_dias_uteis_entre_datas($dTAnoIni, $dTAnoFim);
$diasAnoPassadoUteis = get_dias_uteis_entre_datas($dTAnoIni, $dataTime);
$diasAnoUteisPerc = $diasAnoPassadoUteis/$diasAnoUteis*100;

// MES ******************************************************************************************

$dataMesIni = $dataArr['ano'].'-'.$dataArr['mes'].'-01';
$dataMesFim = data_ultimo_dia_mes($dataDia, true); // retorna a data do ultimo dia
$dTMesIni = new DateTime($dataMesIni);
$dTMesFim = new DateTime($dataMesFim);

$diasMes = dias_entre_datas($dataMesIni, $dataMesFim);
$diasMesPassados = dias_entre_datas($dataMesIni, $dataDia)+1; // soma dia atual
$diasMesPerc = $diasMesPassados/$diasMes*100;

$diasMesUteis = get_dias_uteis_entre_datas($dTMesIni, $dTMesFim);
$diasMesPassadosUteis = get_dias_uteis_entre_datas($dTMesIni, $dataTime);
$diasMesUteisPerc = $diasMesPassadosUteis/$diasMesUteis*100;

// mes
//dias: $diasMesPassados(x%) / $diasMes
//dias uteis: $diasMesPassadosUteis(x%) / $diasMesUteis

// ano
//dias: $diasAnoPassado(x%) / $diasAno ($anoBissexto)");
//dias uteis: $diasAnoPassadoUteis(x%) / $diasAnoUteis");

// PREVISAO DO TEMPO *****************************************************************************

// PREVISAO DO TEMPO
// sys_load_api('astronomico', 'inpe');
// $inpeServ = new Inpe();
// $prevTempGeral = $inpeServ->get_previsao_tempo_cidade(5092);
// $prevTempDia = (isset($previsaoTempo['dias'][$dataDia])) ? $previsaoTempo['dias'][$dataDia] : array();

// ASTRONOMICO *************************************************************************************
sys_load_api('astronomico', 'planetas');
$planetasServ = new Planetas(); // pode mandar posĩcao geografica customizada
$infoPlanet = $planetasServ->getInfo($dataTime); // ASTRONOMICO, Lua / Sol

//pr($infoPlanet);



?>
<div class="row">
	<div class="col-lg-12 text-center">
	    <h1>
		    <button type="button" class="btn btn-sm btn-default">
			    <?=$dataArr['dia']?><br>
			    <?=$nomeMes?>
		    </button>
	    	<span id="tm-h"><?=date('H')?></span>:<span id="tm-m"><?=date('i')?></span>:<span id="tm-s"><?=date('s')?></span>
    	</h1>
    </div>
</div>

<div class="row">
	<div class="col-lg-2 text-right">Mês</div>
	<div class="col-lg-5 text-center">
		<?=$diasMesPassados.'('.round($diasMesPerc).'%) / '.$diasMes?>
    </div>
	<div class="col-lg-5 text-center">
		<?=$diasMesPassadosUteis.'('.round($diasMesUteisPerc).'%) / '.$diasMesUteis?>
    </div>
</div>
<div class="row">
	<div class="col-lg-4 text-rigth">Ano</div>
	<div class="col-lg-4 text-center">
		<?=$diasAnoPassado.'('.round($diasAnoPerc).'%) / '.$diasAno?>
    </div>
	<div class="col-lg-4 text-center">
		<?=$diasAnoPassadoUteis.'('.round($diasAnoUteisPerc).'%) / '.$diasAnoUteis?>
    </div>
</div>

<hr>
<div class="row">
	<div class="col-lg-12">
		<?php sys_load_view_md('info_dia_luz', array('nome'=>'Sol pleno','periodo'=>$infoPlanet['luz_dia_plena'])); ?>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php sys_load_view_md('info_dia_luz', array('nome'=>'Civíl','periodo'=>$infoPlanet['luz_dia_civ'])); ?>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php sys_load_view_md('info_dia_luz', array('nome'=>'Náutico','periodo'=>$infoPlanet['luz_dia_naut'])); ?>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php sys_load_view_md('info_dia_luz', array('nome'=>'Astronômico','periodo'=>$infoPlanet['luz_dia_astr'])); ?>
    </div>
</div>
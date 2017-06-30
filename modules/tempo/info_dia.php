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

// PREVISAO DO TEMPO
// sys_load_api('astronomico', 'inpe');
// $inpeServ = new Inpe();
// $prevTempGeral = $inpeServ->get_previsao_tempo_cidade(5092);
// $prevTempDia = (isset($previsaoTempo['dias'][$dataDia])) ? $previsaoTempo['dias'][$dataDia] : array();

// ASTRONOMICO
sys_load_api('astronomico', 'planetas');
$planetasServ = new Planetas(); // pode mandar posĩcao geografica customizada
$infoPlanet = $planetasServ->getInfo($dataTime); // ASTRONOMICO, Lua / Sol

?>
<div class="row">
	<div class="col-lg-12">
	    Data: <?=$dataUser?>
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
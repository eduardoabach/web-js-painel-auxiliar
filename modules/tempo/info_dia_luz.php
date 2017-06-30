<?php
require_once dirname(__DIR__).'/tools/core.php';
sys_set_module(__DIR__);

$diaCivInfo = dia_periodo_info($periodo['ini'], $periodo['fim']);
$percMadrug = round($diaCivInfo['antes']['percent_dia']);
$percDia = round($diaCivInfo['durante']['percent_dia']);
$percNoite = 100-$percMadrug-$percDia; // não usa o round do seu valor para garantir valor 100 no final, caso mais o ultimo nao aparece

?>
<div class="row">
	<div class="col-lg-3"><?=$nome?></div>
	<div class="col-lg-6 text-center">
		<?=$periodo['ini']?> ~ <?=$periodo['fim']?>
    </div>
	<div class="col-lg-3"></div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="progress progress-slim">
			<div class="progress-bar" style="width: <?=$percMadrug?>%; background-color: #9400D3">
				<span class="sr-only"><?=$diaCivInfo['antes']['tempo']?> (<?=$percMadrug?>%)</span>
			</div>
			<div class="progress-bar progress-bar-striped" style="width: <?=$percDia?>%; background-color: #DAA520">
				<span class="sr-only"><?=$diaCivInfo['durante']['tempo']?> (<?=$percDia?>%)</span>
			</div>
			<div class="progress-bar" style="width: <?=$percNoite?>%; background-color: #9400D3;">
				<span class="sr-only"><?=$diaCivInfo['depois']['tempo']?> (<?=$percNoite?>%)</span>
			</div>
		</div>
    </div>
</div>
<?php 
	require_once dirname(__DIR__).'/tools/core.php';
	sys_set_module(__DIR__);
	sys_load_md('function');

	$idCidade = (isset($_POST['id_cidade'])) ? $_POST['id_cidade'] : false;
	if(!($idCidade > 0)){
		echo 'Código da cidade incorreto.';
		return false;
	}

	$dataRef = date('Y-m-d');

	$qtdDiasVerif = 7;
	$listDatas = list_days_add($dataRef, $qtdDiasVerif);
	$listInfo = array();
	foreach($listDatas as $dia){
		$listInfo[$dia]['dia'] = $dia;
	}

	/* PREVISÃO DO TEMPO ------------ */
	sys_load_md_api('inpe');
	$inpeServ = new Inpe();
	$previsaoTempo = $inpeServ->get_previsao_tempo_cidade($idCidade);
	if(isset($previsaoTempo['dias'])){
		$listInfo = array_merge($listInfo, $previsaoTempo['dias']);
	}
	// pensar em usar a $previsaoTempo['atualizacao']
	/* ------------------------------ */

	/* Astros terrestres ------------ */
	sys_load_md_api('planetas');
	$planetasServ = new Planetas(); // pode mandar posĩcao geografica customizada
	/* ------------------------------ */

	//ajustar a lua para usar o astronomico apenas, func para monstar desc, conceitos de fases em ptbr tbm
	//passar a usar dados do astronomico
	foreach($listInfo as $key => $diaInf){
		$dtUsar = new DateTime(trim($diaInf['dia']));
		$infoAstr = $planetasServ->getInfo($dtUsar); // ASTRONOMICO, Lua / Sol
		$listInfo[$key]['lua'] = $infoAstr['lua'];

		$listInfo[$key]['dia'] = trim($diaInf['dia']);
		$listInfo[$key]['iuv_info'] = get_oms_indice_uv(trim($diaInf['iuv'])); // IUV
		$listInfo[$key]['minima_cor'] = get_cor_temperatura($diaInf['minima']); // TEMPERATURA
		$listInfo[$key]['maxima_cor'] = get_cor_temperatura($diaInf['maxima']);
		$listInfo[$key]['tempo_img'] = $inpeServ->get_clima_img(trim($diaInf['tempo']));
	}

	$infPrevC = array(
		'nome_cidade' => get_nome_cidade($idCidade),
		'previsao_data' => $previsaoTempo['atualizacao'],
		'list_dias' => $listInfo);
	sys_load_view_md('prev_clima_v_list', $infPrevC);

	?>
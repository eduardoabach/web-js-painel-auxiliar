<?php 

// Siglas das condições do tempo do INPE
function get_inpe_cond_tempo($sigla){
	$list = array(
		'ec'=>array('nome'=>'Encoberto com Chuvas Isoladas', 'descricao'=>'Céu totalmente encoberto com chuvas em algumas regiões, sem aberturas de sol.'),
		'ci'=>array('nome'=>'Chuvas Isoladas', 'descricao'=>'Muitas nuvens com curtos períodos de sol e chuvas em algumas áreas.'),
		'c'=>array('nome'=>'Chuva', 'descricao'=>'Muitas nuvens e chuvas periódicas.'),
		'in'=>array('nome'=>'Instável', 'descricao'=>'Nebulosidade variável com chuva a qualquer hora do dia.'),
		'pp'=>array('nome'=>'Poss. de Pancadas de Chuva', 'descricao'=>'Nebulosidade variável com pequena chance (inferior a 30%) de pancada de chuva.'),
		'cm'=>array('nome'=>'Chuva pela Manhã', 'descricao'=>'Chuva pela manhã melhorando ao longo do dia.'),
		'cn'=>array('nome'=>'Chuva a Noite', 'descricao'=>'Nebulosidade em aumento e chuvas durante a noite.'),
		'pt'=>array('nome'=>'Pancadas de Chuva a Tarde', 'descricao'=>'Predomínio de sol pela manhã. À tarde chove com trovoada.'),
		'pm'=>array('nome'=>'Pancadas de Chuva pela Manhã', 'descricao'=>'Chuva com trovoada pela manhã. À tarde o tempo abre e não chove.'),
		'np'=>array('nome'=>'Nublado e Pancadas de Chuva', 'descricao'=>'Muitas nuvens com curtos períodos de sol e pancadas de chuva com trovoadas.'),
		'pc'=>array('nome'=>'Pancadas de Chuva', 'descricao'=>'Chuva de curta duração e pode ser acompanhada de trovoadas a qualquer hora do dia.'),
		'pn'=>array('nome'=>'Parcialmente Nublado', 'descricao'=>'Sol entre poucas nuvens.'),
		'cv'=>array('nome'=>'Chuvisco', 'descricao'=>'Muitas nuvens e chuva fraca composta de pequenas gotas d´ água.'),
		'ch'=>array('nome'=>'Chuvoso', 'descricao'=>'Nublado com chuvas contínuas ao longo do dia.'),
		't'=>array('nome'=>'Tempestade', 'descricao'=>'Chuva forte capaz de gerar granizo e ou rajada de vento, com força destrutiva (Veloc. aprox. de 90 Km/h) e ou tornados.'),
		'ps'=>array('nome'=>'Predomínio de Sol', 'descricao'=>'Sol na maior parte do período.'),
		'e'=>array('nome'=>'Encoberto', 'descricao'=>'Céu totalmente encoberto, sem aberturas de sol.'),
		'n'=>array('nome'=>'Nublado', 'descricao'=>'Muitas nuvens com curtos períodos de sol.'),
		'cl'=>array('nome'=>'Céu Claro', 'descricao'=>'Sol durante todo o período. Ausência de nuvens.'),
		'nv'=>array('nome'=>'Nevoeiro', 'descricao'=>'Gotículas de água em suspensão que reduzem a visibilidade.'),
		'g'=>array('nome'=>'Geada', 'descricao'=>'Cobertura de cristais de gelo que se formam por sublimação direta sobre superfícies expostas cuja temperatura está abaixo do ponto de congelamento.'),
		'ne'=>array('nome'=>'Neve', 'descricao'=>'Vapor de água congelado na nuvem, que cai em forma de cristais e flocos.'),
		'nd'=>array('nome'=>'Não Definido', 'descricao'=>'Não definido.'),
		'pnt'=>array('nome'=>'Pancadas de Chuva a Noite', 'descricao'=>'Chuva de curta duração podendo ser acompanhada de trovoadas à noite.'),
		'psc'=>array('nome'=>'Possibilidade de Chuva', 'descricao'=>'Nebulosidade variável com pequena chance (inferior a 30%) de chuva.'),
		'pcm'=>array('nome'=>'Possibilidade de Chuva pela Manhã', 'descricao'=>'Nebulosidade variável com pequena chance (inferior a 30%) de chuva pela manhã.'),
		'pct'=>array('nome'=>'Possibilidade de Chuva a Tarde', 'descricao'=>'Nebulosidade variável com pequena chance (inferior a 30%) de chuva pela tarde.'),
		'pcn'=>array('nome'=>'Possibilidade de Chuva a Noite', 'descricao'=>'Nebulosidade variável com pequena chance (inferior a 30%) de chuva à noite.'),
		'npt'=>array('nome'=>'Nublado com Pancadas a Tarde', 'descricao'=>'Muitas nuvens com curtos períodos de sol e pancadas de chuva com trovoadas à tarde.'),
		'npn'=>array('nome'=>'Nublado com Pancadas a Noite', 'descricao'=>'Muitas nuvens com curtos períodos de sol e pancadas de chuva com trovoadas à noite.'),
		'ncn'=>array('nome'=>'Nublado com Poss. de Chuva a Noite', 'descricao'=>'Muitas nuvens com curtos períodos de sol com pequena chance (inferior a 30%) de chuva à noite.'),
		'nct'=>array('nome'=>'Nublado com Poss. de Chuva a Tarde', 'descricao'=>'Muitas nuvens com curtos períodos de sol com pequena chance (inferior a 30%) de chuva à tarde.'),
		'ncm'=>array('nome'=>'Nubl. c/ Poss. de Chuva pela Manhã', 'descricao'=>'Muitas nuvens com curtos períodos de sol com pequena chance (inferior a 30%) de chuva pela manhã.'),
		'npm'=>array('nome'=>'Nublado com Pancadas pela Manhã', 'descricao'=>'Muitas nuvens com curtos períodos de sol e chuva com trovoadas pela manhã.'),
		'npp'=>array('nome'=>'Nublado com Possibilidade de Chuva', 'descricao'=>'Muitas nuvens com curtos períodos de sol com pequena chance (inferior a 30%) de chuva a qualquer hora do dia.'),
		'vn'=>array('nome'=>'Variação de Nebulosidade', 'descricao'=>'Períodos curtos de sol intercalados com períodos de nuvens.'),
		'ct'=>array('nome'=>'Chuva a Tarde', 'descricao'=>'Nebulosidade em aumento e chuvas a partir da tarde.'),
		'ppn'=>array('nome'=>'Poss. de Panc. de Chuva a Noite', 'descricao'=>'Nebulosidade variável com pequena chance (inferior a 30%) de chuva à noite.'),
		'ppt'=>array('nome'=>'Poss. de Panc. de Chuva a Tarde', 'descricao'=>'Nebulosidade variável com pequena chance (inferior a 30%) de chuva pela tarde.'),
		'ppm'=>array('nome'=>'Poss. de Panc. de Chuva pela Manhã', 'descricao'=>'Nebulosidade variável com pequena chance (inferior a 30%) de chuva pela manhã.'));

	return (isset($list[$sigla])) ? $list[$sigla] : false;
}

function get_inpe_img_clima_sigla($sigla){
	return 'modules/clima/img/'.$sigla.'.png';
}

// Escala de tons de pele por fitzpatrick.
// Pigmentacao imediata = 6h~8h
// Pigmentacao retardada = 10h~14h
function get_nome_tipo_pele($tipo = false){
	if(!isset($list[$tipo]))
		return false;

	$list = array();
	$list['I'] = array(
		'nome'=>'Pele muito clara',
		'descricao'=>'Pele muito branca, cabelo loiro ou ruivo, olhos claros e frequentemente sardas.',
		'fps_uv'=>array(1=>25, 3=>40, 9=>50), 
		'reacao_exposicao_solar'=>'Queima facilmente, nunca bronzeia.',
		'pigmentacao_imediata'=>'Nenhuma',
		'pigmentacao_retardada'=>'Nenhuma');
	$list['II'] = array(
		'nome'=>'Pele clara',
		'descricao'=>'Pele branca, cabelo claro, olhos claros.',
		'reacao_exposicao_solar'=>'Queima facilmente, bronzeia muito pouco.',
		'fps_uv'=>array(1=>25, 5=>40), 
		'pigmentacao_imediata'=>'Fraca',
		'pigmentacao_retardada'=>'Mínima a fraca');
	$list['III'] = array(
		'nome'=>'Pele menos clara',
		'descricao'=>'Pele clara, olhos e cabelas de cor variável.',
		'reacao_exposicao_solar'=>'Queima um pouco e bronzeia gradualmente.',
		'fps_uv'=>array(1=>15, 5=>25, 9=>40), 
		'pigmentacao_imediata'=>'Pouca',
		'pigmentacao_retardada'=>'Baixa');
	$list['IV'] = array(
		'nome'=>'Pele morena clara',
		'descricao'=>'Pele moderadamente pigmentada a muito pigmentada.',
		'reacao_exposicao_solar'=>'Raramente queima e bronzeia com facilidade.',
		'fps_uv'=>array(1=>15, 7=>25), 
		'pigmentacao_imediata'=>'Moderada',
		'pigmentacao_retardada'=>'Moderada');
	$list['V'] = array(
		'nome'=>'Pele morena escura',
		'descricao'=>'Pele escura ou do sudoeste asiático.',
		'reacao_exposicao_solar'=>'Não queima, bronzeia com facilidade.',
		'fps_uv'=>array(1=>15), 
		'pigmentacao_imediata'=>'Intensa',
		'pigmentacao_retardada'=>'Intensa');
	$list['VI'] = array(
		'nome'=>'Pele negra',
		'descricao'=>'',
		'reacao_exposicao_solar'=>'Não queima, bronzeia com facilidade.',
		'fps_uv'=>array(1=>15), 
		'pigmentacao_imediata'=>'Muito intensa',
		'pigmentacao_retardada'=>'Intensa');

	if($tipo === false)
		return $list;
}

// Tratar número de Índice Ultra Violeta conforme Organização Mundial da Saúde
// Retornos possíveis: risco, medidas, cor, false = completo
function get_oms_indice_uv($indiceOms, $tipoRetorno = false){
	// Para os baixos = 1, 2
	$risco = 'BAIXO';
	$medidas = 'Não são necessárias medidas adicionais.';
	$cor = '#32CD32'; //verde
	$tempoMaxExposicao = 60; // ou até mais, aqui está em minutos

	// 3, 4, 5
	if($indiceOms >= 3 && $indiceOms <= 5){
		$risco = 'MODERADO';
		$medidas = 'Protetor solar e óculos de sol. Procurar sombra durante as 10h e as 16h.';
		$cor = '#CCAA00'; //amarelo
		$tempoMaxExposicao = 45;
	} else if($indiceOms >= 6 && $indiceOms <= 7){
		$risco = 'ALTO';
		$medidas = 'Protetor solar, óculos de sol com filtro UV e chapéu. Procurar sombra durante as 10h e as 16h.';
		$cor = '#FF7F00'; //laranja
		$tempoMaxExposicao = 30;
	} else if($indiceOms >= 8 && $indiceOms <= 10){
		$risco = 'MUITO ALTO';
		$medidas = 'Protetor solar, óculos de sol com filtro UV, chapéu e guarda-sol. Evite a exposição solar entre as 10h e as 16h. As crianças devem evitar a exposição solar durante todo o dia.';
		$cor = '#B22222'; //vermelho
		$tempoMaxExposicao = 25;
	} else if($indiceOms >= 11){ // Pode ir até 14
		$risco = 'EXTREMO';
		$medidas = 'Evitar a exposição solar.';
		$cor = '#9400D3'; //roxo
		$tempoMaxExposicao = 10;
	}

	if($tipoRetorno === 'risco')
		return $risco;
	if($tipoRetorno === 'medidas')
		return $medidas;
	if($tipoRetorno === 'cor')
		return $cor;

	return array(
		'risco' => $risco,
		'medidas' => $medidas,
		'cor' => $cor,
		'tempo_exposicao' => $tempoMaxExposicao
	);
}

function get_cor_temperatura($temp){
	$cor = '#0000CD'; //muito frio, azul forte
	if($temp >= 0 && $temp < 6)
		$cor = '#0000FF'; //azul -forte
	if($temp < 10)
		$cor = '#1E90FF'; //azul --forte
	else if($temp < 17)
		$cor = '#4876FF'; //azul claro
	else if($temp < 25)
		$cor = '#DAA520'; //bege
	else if($temp < 30)
		$cor = '#FF8C00'; //laranja
	else if($temp < 35)
		$cor = '#CD3333'; //vermelho
	else
		$cor = '#B22222'; //bordo

	return $cor; 
}

// $dataTest = '2017-06-19';
// echo fases_lua($dataTest);
function fases_lua($dataRef=false){
    if($dataRef == false)
        $timestamp = time();
    else
        $timestamp = strtotime($dataRef);
    
    $year = date('Y', $timestamp);
    $month = date('n', $timestamp);
    $day = date('j', $timestamp);
    
    //modified from http://www.voidware.com/moon_phase.htm
    $c = $e = $jd = $b = 0;

    if ($month < 3){
        $year--;
        $month += 12;
    }

    ++$month;
    $c = 365.25 * $year;
    $e = 30.6 * $month;
    $jd = $c + $e + $day - 694039.09;	//jd is total days elapsed
    $jd /= 29.5305882;					//divide by the moon cycle
    $b = (int) $jd;						//int(jd) -> b, take integer part of jd
    $jd -= $b;							//subtract integer part to leave fractional part of original jd
    $b = round($jd * 8);				//scale fraction from 0-8 and round

    if ($b >= 8 ){
        $b = 0;//0 and 8 are the same so turn 8 into 0
    }

    switch ($b)	{
        case 0:
            return 'Nova'; //New Moon
            break;
        case 1:
            return 'Crescente Côncava';
            //return 'Emergente'; //Waxing Crescent Moon
            break;
        case 2:
            return 'Crescente'; //Quarter Moon
            break;
        case 3:
            return 'Crescente Convexa'; //Waxing Gibbous Moon
            break;
        case 4:
            return 'Cheia'; //Full Moon
            break;
        case 5:
            return 'Minguante Convexa'; //Waning Gibbous Moon
            //return 'Disseminadora'; //Waning Gibbous Moon
            break;
        case 6:
            return 'Minguante'; //Last Quarter Moon
            break;
        case 7:
            return 'Minguante Côncava'; //Waning Crescent Moon
            //return 'Balsâmica'; //Waning Crescent Moon
            break;
        default:
            return 'Erro'; //Error
    }
}

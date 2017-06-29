<?php 

//ver
// http://www.flextool.com.br/tabela_cores.html
// http://astropbi.blogspot.com.br/2009/09/fases-da-lua.html
// https://github.com/codebox/js-planet-phase/blob/master/planet_phase.js
// https://github.com/codebox/js-planet-phase/blob/master/planet_phase.html
// http://codebox.org.uk/pages/html-moon-planet-phases

// #webservice previsao do tempo
// http://servicos.cptec.inpe.br/XML/listaCidades?city=porto%20alegre // para buscar cods
// http://servicos.cptec.inpe.br/XML/listaCidades // 237 = poa, 5092 sapirang, 1929 estancia velha, 3591 nh, 4969 sao leo
// http://servicos.cptec.inpe.br/XML/cidade/3591/previsao.xml // previsao do tempo prox 4 dias
// http://servicos.cptec.inpe.br/XML/cidade/7dias/3591/previsao.xml // previsao do tempo prox 7 dias
// http://servicos.cptec.inpe.br/XML/cidade/7dias/-22.90/-47.06/previsaoLatLon.xml // 7 dias para latitudo e longitude, pegando a cidade mais proxima
// http://servicos.cptec.inpe.br/XML/cidade/3591/estendida.xml // 7 dias depois dos 7 normais, totalizando 14 dias de previsao
// http://servicos.cptec.inpe.br/XML/#estacoes-metar


function get_cidade_all(){
	return array(
		'3591' => 'Novo Hamburgo',
		'5092' => 'Sapiranga',
		'1929' => 'Estância Velha',
		'237' => 'Porto Alegre',
		'3994' => 'Pinherinho do Vale',
		'3511' => 'Nova Esperança do Sul',
	);
}

function get_nome_cidade($id){
	$list = get_cidade_all();
	return (isset($list[$id])) ? $list[$id] : false;
}

function get_inpe_img_clima_sigla($sigla){
	return 'modules/clima/img/inpe/'.$sigla.'.png';
}

function get_img_fase_lua($fase){
	return 'modules/clima/img/lua_fase/'.$fase.'.png';
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
// fases_lua(); // retorna array com dados do dia atual
// modificado de http://www.voidware.com/moon_phase.htm
// tipos de retorno: fracional, descricao, completo
// NÃO É GEOGRAFICAMENTE PRECISA
function fases_lua($dataRef=false, $tipoRetorno=false){
	$tempoCicloLua = 29.5305882;
    if($dataRef == false)
        $timestamp = time();
    else
        $timestamp = strtotime($dataRef);
    
    $ano = date('Y', $timestamp);
    $mes = date('n', $timestamp);
    $dia = date('j', $timestamp);
    
    if($mes < 3){
        $ano--;
        $mes += 12;
    }

    ++$mes;
    $anoDias = 365.25 * $ano;
    $mesDias = 30.6 * $mes;
    $tempoTotal = $anoDias + $mesDias + $dia - 694039.09; // total de dias passados
    $tempoTotal /= $tempoCicloLua; //dividido pelo ciclo da lua
    $ciclosCompletos = (int) $tempoTotal; //int(jd) -> formata ciclos completos
    $fracaoCicloAt = $tempoTotal - $ciclosCompletos; //subtrai os ciclos completo para ficar com fracao em andamento

    if($tipoRetorno == 'fracional')
    	return $fracaoCicloAt;

    $faseSimplif = round($fracaoCicloAt * 8); // criar escala fracional de 0-8
    if($faseSimplif >= 8 ){
        $faseSimplif = 0; // 0 e 8 são o mesmo, fechando ciclo
    }

    $desc = '';
    switch($faseSimplif){
        case 0:
            $desc = 'Nova'; //New Moon
            break;
        case 1:
            $desc = 'Crescente Côncava'; //'Emergente'; //Waxing Crescent Moon
            break;
        case 2:
            $desc = 'Crescente'; //Quarter Moon
            break;
        case 3:
            $desc = 'Crescente Convexa'; //Waxing Gibbous Moon
            break;
        case 4:
            $desc = 'Cheia'; //Full Moon
            break;
        case 5:
            $desc = 'Minguante Convexa'; //Waning Gibbous Moon, 'Disseminadora'; //Waning Gibbous Moon
            break;
        case 6:
            $desc = 'Minguante'; //Last Quarter Moon
            break;
        case 7:
            $desc = 'Minguante Côncava'; //Waning Crescent Moon, 'Balsâmica'; //Waning Crescent Moon
            break;
        default:
            $desc = 'Erro'; //Error
    }

    if($tipoRetorno == 'descricao'){
    	return $desc;
    } else if($tipoRetorno === false || $tipoRetorno == 'completo'){

    	// Dias para Lua Cheia
    	$distCheia = $fracaoCicloAt - 0.55; // lua cheia seria 0.5, mas nos testes parece ficar mais preciso em .55, talvez alterar no futuro.
    	if($distCheia < 0)
    		$distCheia *= -1;
    	$diasParaCheia = (int)($distCheia * $tempoCicloLua);

    	// Descricao completa
    	$luzPercent = round($fracaoCicloAt*100);
		$descIlumin = 'Luz '.$luzPercent.'%';
		$prevLuaCheia = 'Cheia em '.$diasParaCheia.' dia(s)';
		$descCompleta = $desc.', '.$descIlumin.', '.$prevLuaCheia;

		return array(
			'fracional'=>$fracaoCicloAt, 
			'descricao'=>$desc, 
			'dias_para_cheia'=>$diasParaCheia, 
			'luz_percent'=>$luzPercent, 
			'descricao_completa'=>$descCompleta);
    }
    return false;
}

function get_astronomico($dataDia){
	require_once('./lib/astrotool.php');

	$dtUsar = new DateTime($dataDia);
	$sc = new AstroTool($dtUsar, -29.76, -51.14);

	$momentos = array();
	$hSol = $sc->getSunTimes($dtUsar);
	if(is_array($hSol) && count($hSol) > 0){
		$momentos['meio_dia_solar'] = $hSol['solMeioDia']->format('H:i:s');

		$segDiaPleno = segundos_entre_datas($hSol['horaDourada']->format('Y-m-d H:i:s'), $hSol['horaDouradaFim']->format('Y-m-d H:i:s'));
		$momentos['luz_dia_plena']['ini'] = $hSol['horaDouradaFim']->format('H:i:s');
		$momentos['luz_dia_plena']['fim'] = $hSol['horaDourada']->format('H:i:s');
		$momentos['luz_dia_plena']['tempo'] = segundos_to_hora($segDiaPleno);
		$momentos['luz_dia_plena']['segundos'] = $segDiaPleno;

		$segDiaCiv = segundos_entre_datas($hSol['crepusculo']->format('Y-m-d H:i:s'), $hSol['amanhecer']->format('Y-m-d H:i:s'));
		$momentos['luz_dia_civ']['ini'] = $hSol['amanhecer']->format('H:i:s');
		$momentos['luz_dia_civ']['fim'] = $hSol['crepusculo']->format('H:i:s');
		$momentos['luz_dia_civ']['tempo'] = segundos_to_hora($segDiaCiv);
		$momentos['luz_dia_civ']['segundos'] = $segDiaCiv;

		$segDiaNaut = segundos_entre_datas($hSol['nauticoFim']->format('Y-m-d H:i:s'), $hSol['nauticoIni']->format('Y-m-d H:i:s'));
		$momentos['luz_dia_naut']['ini'] = $hSol['nauticoIni']->format('H:i:s');
		$momentos['luz_dia_naut']['fim'] = $hSol['nauticoFim']->format('H:i:s');
		$momentos['luz_dia_naut']['tempo'] = segundos_to_hora($segDiaNaut);
		$momentos['luz_dia_naut']['segundos'] = $segDiaNaut;

		$segDiaAstr = segundos_entre_datas($hSol['noite']->format('Y-m-d H:i:s'), $hSol['noiteFim']->format('Y-m-d H:i:s'));
		$momentos['luz_dia_astr']['ini'] = $hSol['noiteFim']->format('H:i:s');
		$momentos['luz_dia_astr']['fim'] = $hSol['noite']->format('H:i:s');
		$momentos['luz_dia_astr']['tempo'] = segundos_to_hora($segDiaAstr);
		$momentos['luz_dia_astr']['segundos'] = $segDiaAstr;
		
		$momentos['nascer_sol']['ini'] = $hSol['nascerSol']->format('H:i:s');
		$momentos['nascer_sol']['fim'] = $hSol['nascerSolFim']->format('H:i:s');

		$momentos['por_sol']['ini'] = $hSol['porSolIni']->format('H:i:s');
		$momentos['por_sol']['fim'] = $hSol['porSol']->format('H:i:s');
	}

	$luaLuz = $sc->getMoonIllumination($dtUsar);
	if(is_array($luaLuz) && count($luaLuz) > 0){
		$momentos['lua']['fase'] = $luaLuz['phase'];
		$momentos['lua']['luz'] = $luaLuz['fraction'];
		$momentos['lua']['angulo'] = $luaLuz['angle'];
	}

	$luaPresenca = $sc->getMoonTimes(false,$dtUsar);
	if(is_array($luaPresenca) && count($luaPresenca) > 0){

		// não existe saida quando o ciclo for completo
		if(!isset($luaPresenca['lua_sair']))
			$luaPresenca['lua_sair'] = new DateTime($dataDia.' 23:59:59');	
		
		$segLuaPresent = segundos_entre_datas($luaPresenca['lua_sair']->format('Y-m-d H:i:s'), $luaPresenca['lua_nascer']->format('Y-m-d H:i:s'));
		$momentos['lua']['presenca']['nascer'] = $luaPresenca['lua_nascer']->format('H:i:s');
		$momentos['lua']['presenca']['sair'] = $luaPresenca['lua_sair']->format('H:i:s');
		$momentos['lua']['presenca']['tempo'] = segundos_to_hora($segDiaAstr);
		$momentos['lua']['presenca']['segundos'] = $segLuaPresent;

		// Para o visível vou ter que verificar quais dos eventos de exibicao acontece por ultimo, e qual dos de saida acontece primeiro
		$luaAparece = $momentos['lua']['presenca']['nascer'];
		$luaVisivel = $momentos['luz_dia_naut']['fim'];
		$luaPresencaAntesEstarVisivel = segundos_entre_horas($luaAparece, $luaVisivel); // valor negativo significa antes
		$horaUltiEventVisivel = ($luaPresencaAntesEstarVisivel < 0) ? $luaVisivel : $luaAparece;
		$luaDtVisIni = new DateTime($dataDia.' '.$horaUltiEventVisivel);

		$luaSair = $momentos['lua']['presenca']['sair'];
		$luaNaoVisivel = $momentos['luz_dia_naut']['ini'];
		$luaSairAntesNaoVisivel = segundos_entre_horas($luaSair, $luaNaoVisivel);
		$horaPrimeiroEventInvisivel = ($luaSairAntesNaoVisivel > 0) ? $luaSair : $luaNaoVisivel;
		$luaDtVisFim = new DateTime($dataDia.' '.$horaPrimeiroEventInvisivel);

		$segLuaVisivel = segundos_entre_datas($luaDtVisFim->format('Y-m-d H:i:s'), $luaDtVisIni->format('Y-m-d H:i:s'));
		$momentos['lua']['presen_visivel_noite']['visivel'] = $horaUltiEventVisivel;
		$momentos['lua']['presen_visivel_noite']['fora'] = $horaPrimeiroEventInvisivel;
		$momentos['lua']['presen_visivel_noite']['tempo'] = segundos_to_hora($segLuaVisivel);
		$momentos['lua']['presen_visivel_noite']['segundos'] = $segLuaVisivel;		
	}

	// print_r('c1<pre>');
	// print_r($sc->getMoonPosition($dtUsar));
	// print_r('</pre>');
	return $momentos;
}
<?php 
require_once strstr(__DIR__, '/modules/', true).'/modules/tools/core.php';
sys_set_module(__DIR__);

// Instituto Nacional de Pesquisas Espaciais
class Inpe{
	private $urlBase = 'http://servicos.cptec.inpe.br/XML/';
	private $nome_api = 'inpe';

    public function __construct() {
        
    }

    // pendente, tratar para caso o serviço não esteja disponível, ou simplemente sem internet
    public function get($url){
    	$page = download_page($this->urlBase.$url);
		return new SimpleXMLElement($page);
    }

    public function get_previsao_tempo_cidade($idCidade){
		$xmlOb = $this->get('cidade/7dias/'.$idCidade.'/previsao.xml');
		$previsao = array();

		if(isset($xmlOb->previsao)){
			foreach($xmlOb->previsao as $diaPrev){
				$inf = (array)$diaPrev;
				$inf['tempo_inf'] = $this->get_cond_tempo(trim($inf['tempo']));

				$diaAt = trim($diaPrev->dia);
				$previsao[$diaAt] = $inf;
			}
		}

		return array('nome'=>$xmlOb->nome, 'uf'=>$xmlOb->uf, 'atualizacao'=>$xmlOb->atualizacao, 'dias'=>$previsao);
	}

	public function get_clima_img($sigla){
		if($sigla == '') 
			$sigla = 'nd';
		return sys_url_md_api($this->nome_api,'img_clima/'.$sigla.'.png');
	}

	// Siglas das condições do tempo do INPE
	public function get_cond_tempo($sigla){
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
}

//sys_load_tool('tempo');
//sys_load_md('function');

//$idCidade = (isset($_POST['id_cidade'])) ? $_POST['id_cidade'] : false;

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

// criar array de datas autonomo, sistema ficar independente de webservice, internet




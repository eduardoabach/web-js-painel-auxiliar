<?php 
require_once strstr(__DIR__, '/modules/', true).'/modules/tools/core.php';
sys_set_module(__DIR__);

class inpe_webservice{
	private $urlBase = 'http://servicos.cptec.inpe.br/XML/';

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
		//$xmlOb->nome.', '.$xmlOb->uf
		//$xmlOb->atualizacao

		if(isset($xmlOb->previsao)){
			foreach($xmlOb->previsao as $diaPrev){
				$diaAt = trim($diaPrev->iuv);

				$previsao[$diaAt] = '';

				// $siglaDesc = get_inpe_cond_tempo(trim($diaPrev->tempo));
				// $clima = ($siglaDesc !== false) ? $siglaDesc : '';
				// $infoUv = get_oms_indice_uv(trim($diaPrev->iuv));

				// $dataUser = date_to_user($diaPrev->dia);
				// $dataArr = data_to_array($diaPrev->dia);
				// $nomeMes = get_nome_mes_ano($dataArr['mes']);

				// $corUv = $infoUv['cor'];
				// $corTempMin = get_cor_temperatura($diaPrev->minima);
				// $corTempMax = get_cor_temperatura($diaPrev->maxima);

				//get_dia_da_semana($diaPrev->dia, 3)
				//$infoUv['risco']
				//$infoUv['cor']
				//$diaPrev->iuv
				//get_inpe_img_clima_sigla(trim($diaPrev->tempo))
			}
		}

		return $previsao;
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




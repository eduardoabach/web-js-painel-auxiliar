<?php

	function menuConstruir($listItens, $nomeTopo=null){
		$html = '';

		if($nomeTopo){
			$html .= '<li>'.menuItem($nomeTopo);
			$html .= '<ul>';
		}

		foreach($listItens as $appNome => $descricao){
			if(is_array($descricao)){
				if(isset($descricao['menu'])){
					$html .= menuConstruir($descricao['menu'], $descricao['desc']);
				} else {

					//item customizado
					$appNomeUsar = (isset($descricao['app'])) ? $descricao['app'] : $appNome;
					$descricaoUsar = (isset($descricao['desc'])) ? $descricao['desc'] : '';
					$funcUsar = (isset($descricao['func'])) ? $descricao['func'] : null;

					$html .= '<li>'.menuItem($descricaoUsar, $appNomeUsar, $funcUsar).'</li>';
				}
			} else {
				$html .= '<li>'.menuItem($descricao, $appNome).'</li>';
			}
		}

		if($nomeTopo){
			$html .= '</ul>';
			$html .= '<li>';
		}

		return $html;				
	}

	function menuItem($descricao, $appNome=null, $func=null){
		$keyChamadaDesc = '';
		$keyFunc = '';

		if($appNome != null){
			$keyChamadaDesc = "class='get-module' data-option='{$appNome}'";

			if($func != null){
				$keyFunc = "data-func='{$func}'";
			}
		}

		return "<a href='javascript:;' {$keyChamadaDesc} {$keyFunc}>{$descricao}</a>";
	}

?>

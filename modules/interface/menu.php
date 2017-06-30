<?php
	$menuList = array(
		// 'login' => 'Login',
		'prog' => array(
			'desc'=>'Prog. Info',
			'menu'=> array(
				'bootstrap_help' => 'Bootstrap',
				'cores' => 'Cores'
			)
		),
		'infos' => array(
			'desc'=>'Informação',
			'menu'=> array(
				'search' => 'Busca',
				'finance' => 'Financeiro',
				'links' => 'Links',
				'history' => 'História'
			)
		),
		'ferramentas' => array(
			'desc'=>'Ferramentas',
			'menu'=> array(
				'gerador_docs' => 'CPF CNPJ',
				'cript' => 'Criptografia',
				'calc' => 'Calculadora',
				'astronomico' => 'Clima',
				'webcam' => 'Webcam',
				'player' => 'Player',
			)
		)
	);
?>

<nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
	<a class="navbar-brand" href="index.html">Painel Multifunção</a>
	<nav id="menu-nav">
		<ul>
			<?php
				foreach($menuList as $keyChamada => $descricao){
					if(is_array($descricao)){
						// add class="current-menu-item" no li para marcar ele
			?>
				<li> 
					<a href="javascript:;"><?=$descricao['desc']?></a>
					<ul>
						<?php foreach($descricao['menu'] as $subKeyChamada => $subDescricao){ ?>
						<li>
							<a href="javascript:;" class="get-module" data-option="<?=$subKeyChamada?>"><?=$subDescricao?></a>
						</li>
						<?php } ?>
					</ul>
				</li>
			<?php
					} else {
			?>
				<li>
					<a href="javascript:;" class="get-module" data-option="<?=$keyChamada?>"><?=$descricao?></a>
				</li>
			<?php 
					} 
				}
			?>
		</ul>
	</nav>
</nav>

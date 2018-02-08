<?php
	$menuList = array(
		// 'login' => 'Login',
		't_prog' => array(
			'desc'=>'Prog. Info',
			'menu'=> array(
				'bootstrap_help' => 'Bootstrap',
				'cores' => 'Cores'
			)
		),
		't_infos' => array(
			'desc'=>'Informação',
			'menu'=> array(
				'search' => 'Busca',
				'finance' => 'Financeiro',
				'links' => 'Links',
				'history' => 'História',
				'painel_dia' => array('desc'=>'Painel Dia', 'app'=>'tempo', 'func'=>'InfoDiaAtual'),
				'tempo' => 'Relógio',
					/*abrir painel com outros paises: 
					londres. inglaterra
					berlin, alemanha
					moscou, russia
					washington, eua
					pequim, china
					toquio, japao

					*/
				't_clima' => array(
					'desc'=>'Clima',
					'menu'=> array(
						'astronomico' => 'Lista'
					)
				)
			)
		),
		't_ferramentas' => array(
			'desc'=>'Ferramentas',
			'menu'=> array(
				'gerador_docs' => 'CPF CNPJ',
				'texto' => 'Texto',
				'conv_unidades' => 'Conv. Unid. Medid.',
				'calc' => 'Calculadora',
				'webcam' => 'Webcam',
				'player' => 'Player'
			)
		)
	);

	$menuNovo = menuConstruir($menuList);
?>

<nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
	<a class="navbar-brand" href="index.html">Painel Multifunção</a>
	<nav id="menu-nav">
		<ul>
			<?=$menuNovo?>
		</ul>
	</nav>
</nav>

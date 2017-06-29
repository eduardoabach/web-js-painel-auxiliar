<?php

/* LOAD BÁSICO DE FUNCIONALIDADES  */
define('ROOT', dirname(__DIR__));
sys_load_tool('utilidades');
sys_load_tool('tempo');
/* ############################### */

function sys_set_module($moduleName=null){
	// pode ser mandada variavel local __DIR__, deve rastrear o item depois da pasta module
	if(strstr($moduleName, '/') !== false){
		$depoisModules = substr(strstr(strstr($moduleName, 'modules/'),'/'), 1);
		$moduleName = (strpos($depoisModules, '/') === false)  ? $depoisModules : strstr($depoisModules, '/', true);
		//$moduleName = array_pop(explode('/', $moduleName));
	}
	define('MODULE', $moduleName);
}

// na view ele adiciona independente de já existir
// para os loads normais ele não repete, impedindo duplicate function
// padrão é include_once, verificando
function sys_load($url, $naoVerificar = false, $vars=array()){
	// o extract deve ser feito aqui no mesmo contexto do include
	if($vars && is_array($vars))
		extract($vars);

	return ($naoVerificar) ? include(ROOT.'/'.$url) : @include_once(ROOT.'/'.$url);
}

function sys_load_tool($tool){
	return sys_load('/tools/'.$tool.'.php');
}

function sys_load_api($modulo, $api){
	return sys_load($modulo.'/api/'.$api.'/api.php');
}

function sys_load_md_api($api){
	return sys_load(MODULE.'/api/'.$api.'/api.php');
}

function sys_load_md($item, $vars=array()){
	return sys_load(MODULE.'/'.$item.'.php', false, $vars);
}

function sys_load_view_md($item, $vars=array()){
	return sys_load(MODULE.'/'.$item.'.php', true, $vars);
}

// Retornar conteudo
function sys_render_md($item, $vars=array()){
	ob_start();
	sys_load_view_md($item, $vars);
	
	$buffer = ob_get_contents();
	@ob_end_clean();
	return $buffer;
}
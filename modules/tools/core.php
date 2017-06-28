<?php

/* LOAD BÁSICO DE FUNCIONALIDADES  */
define('ROOT', dirname(__DIR__));
sys_load_tool('utilidades');
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

function sys_load($url){
	return @include_once(ROOT.'/'.$url);
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

function sys_load_md($item){
	return sys_load(MODULE.'/'.$item.'.php');
}

function sys_render_md($item){
	//return sys_load(MODULE.'/'.$item.'.php');
}
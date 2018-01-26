<?php

/* Tipagem */
// header('Content-Type: text/html; charset=iso-8859-1');
mb_internal_encoding("UTF-8");

/* Configurações globais */
set_base_url();
set_sys_dir();
set_version(time());
set_cache_version(get_version());
session_start();

/* LOAD BÁSICO DE FUNCIONALIDADES  */
sys_load_tool('utilidades');
sys_load_tool('tempo');

/* ############################### */

function sys_pos_geo(){
	// latitude, longitude
	return array('lat'=> -29.69, 'lng'=> -51.12); // novo hamburgo / Brasil
}

function sys_url_md_api($api,$complemento=null){
	//MODULE.'/api/'.$api.'/api.php'
	return 'modules/'.MODULE.'/api/'.$api.'/'.$complemento;
}

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

	// echo SYS_DIR.'/'.$url.'<br>';
	// echo realpath(SYS_DIR.'/'.$url).'<br><br><br>';
	//die('r');
	return ($naoVerificar) ? include(realpath(SYS_DIR.'/'.$url)) : @include_once(realpath(SYS_DIR.'/'.$url));
}

function sys_load_tool($tool){
	return sys_load('tools/'.$tool.'.php');
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

function set_base_url(){
	if(defined('BASE_URL') === false){
		if(isset($_SERVER['HTTP_HOST'])){
			$baseUrl = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
			$baseUrl .= '://'. $_SERVER['HTTP_HOST'];
			$baseUrl .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
		} else {
			$baseUrl = 'http://localhost/';
		}

		define('BASE_URL', $baseUrl);
	}
}

function get_base_url(){
	if(defined('BASE_URL') === false){
		set_base_url();
	}
	return BASE_URL;
}

function set_cache_version($codCache=null){
	if(!$codCache)
		$codCache = time();
	define('COD_CACHE', '?v'.$codCache);
}

function get_cache_version(){
	if(defined('COD_CACHE'))
		return COD_CACHE;
	return false;
}

function set_version($version){
	define('SYS_VERSION', $v);
}

function get_version(){
	if(defined('SYS_VERSION'))
		return SYS_VERSION;
	return false;
}

function set_sys_dir(){
	define('SYS_DIR', dirname(__DIR__));
}

function get_sys_dir(){
	if(defined('SYS_DIR'))
		return SYS_DIR;
	return false;
}




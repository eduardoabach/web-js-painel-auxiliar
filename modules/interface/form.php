<?php
echo realpath(dirname(__DIR__).'/tools/core.php');
die('a');
require_once realpath(dirname(__DIR__).'/tools/core.php');
sys_set_module('interface');
sys_load_md('function');

?>
<div id="wrapper">
	<?php include("menu.php"); ?>
	<div id="page-wrapper">
		<div class="container-fluid min-padding" id="module-list"></div>
	</div>
</div>
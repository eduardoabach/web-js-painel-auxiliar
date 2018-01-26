<?php
	@require_once 'modules/tools/core.php';
?>

<html xml:lang="pt-br" lang="pt-br">
	<head>
		<title>Painel</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Eduardo Bach">

		<meta http-equiv='cache-control' content='no-cache'>
		<meta http-equiv='expires' content='0'>
		<meta http-equiv='pragma' content='no-cache'>

		<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="assets/css/page_estruture.css" rel="stylesheet" type="text/css">
		<link href="assets/css/custom.css" rel="stylesheet" type="text/css">
		<link href="assets/css/menu.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="painel-content"></div>
		<script type="text/javascript">
			window._System = {
				user: {
					id: <?php echo '1'//$userid;?>,
					login: '<?php echo 'Ed'//$username;?>'
				},
				nocache: '<?php echo COD_CACHE; ?>',
		      	url: '<?php echo BASE_URL; ?>'
		   }
		</script>
		<script src="assets/js/jquery-2.2.4.min.js"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/js/func.js"></script>
		<script src="assets/js/app.js"></script>
		<script src="assets/js/require.js" data-main="boot"></script>
	</body>
</html>

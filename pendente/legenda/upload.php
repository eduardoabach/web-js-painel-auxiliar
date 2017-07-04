<?php 
	if( isset( $_POST['enviar'])){
		$erro = '';
		$pathToSave = '/var/www/EditorTraducao/uploads/';
		$tamanho = 2097152; // 1024 * 1024 * 2 = 2mb
		$ext = array('srt','txt','ogv','mp4');
		//$ext_vid = array('ogv','mp4');
		$i = 0;
		$msg = array();
		
		$arquivos = array(array());
		foreach( $_FILES as $key=>$info){
			foreach($info as $key=>$dados){
				for( $i = 0; $i < sizeof( $dados ); $i++ ){
					$arquivos[$i][$key] = $info[$key][$i];
				}
			}
		}
		$i = 1;
		
		foreach($arquivos as $file){
						
			if($file['name'] != ''){
				
				$extensao = strtolower(end(explode('.', $file['name'])));			
				
				if(array_search($extensao, $ext) === false){
					echo "Por favor, envie arquivos com as seguintes extensões:se legenda, srt ou txt senão ogv ou mp4";			
				} else if($arquivos['size'] > $tamanho){
					echo "Um dos arquivos enviados é muito grande, envie arquivos de até 2mb";
				} else {			
					$arquivoTmp = $file['tmp_name'];
					$arquivo = $pathToSave . $file['name'];
							
					if(!move_uploaded_file($arquivoTmp, $arquivo)){
						echo "Erro no upload. Verifique as permissões do diretório";
					} else {
						echo "<script>alert('Arquivo enviado com sucesso!')</script>";					
						$_SESSION["nomeArquivo{$i}"] = $file['name'];
						$i++;
					}
				}
			} else {
				echo 'É necessário escolher um arquivo para enviar!';
			}
		}
	}
	header("Location:pagina.html"); 	
?>	
<?php
function getDirContents($dir, &$results = array()){
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
            $results[$dir][] = $value;
        } else if($value != "." && $value != "..") {
            getDirContents($path, $results);
        }
    }

    return $results;
}

$urlArquivos = $_SERVER['DOCUMENT_ROOT'].'/painel/modules/player/audio/';
$listArquivos = getDirContents($urlArquivos);
?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	<?php 
		$cont = 0;
		foreach($listArquivos as $urlCompleta => $subLista){ 
			$cont++;
			$urlAjust = str_replace($urlArquivos, '', $urlCompleta); 
	?>
	  <div class="panel panel-default">
	    <div class="panel-heading" role="tab" id="heading<?php echo $cont?>">
	      <h4 class="panel-title">
	        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $cont?>" aria-expanded="false" aria-controls="collapse<?php echo $cont?>">
	          <?php echo $urlAjust; ?>
	        </a>
	      </h4>
	    </div>
	    <div id="collapse<?php echo $cont?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $cont?>">
	      <div class="panel-body">
			<?php
			foreach($subLista as $nomeArquivo){
				// pegar somente a url depois da ultima pasta pedida
				$urlAjustArq = $urlAjust.DIRECTORY_SEPARATOR.$nomeArquivo;
				?>
				<div class="row">
					<div class="col-lg-12">
						<button class="btn btn-sm btn-default p-ini-audio" data-url-audio="<?=$urlAjustArq?>"><?=$nomeArquivo?></button>
					</div>
				</div>
			<?php } ?>
	      </div>
	    </div>
	  </div>
	<?php } ?>

</div>
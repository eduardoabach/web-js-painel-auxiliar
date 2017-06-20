<?php 
	$audioTest = "modules/player/audio/chuva-media-algus trovoes fortes.mp3";

?>
<div class="row">
	<div class="col-lg-12">

		<audio src="<?=$audioTest?>" controls autoplay loop></audio>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<audio id='player-demo-test' src="<?=$audioTest?>"></audio>
		<button onclick="document.getElementById('player-demo-test').play()">Reproduzir o áudio</button>
		<button onclick="document.getElementById('player-demo-test').pause()">Pausar o áudio</button>
		<button onclick="document.getElementById('player-demo-test').volume+=0.1">Aumentar o volume</button>
		<button onclick="document.getElementById('player-demo-test').volume-=0.1">Diminuir o volume</button>
	</div>
</div>
<?php 
  $urlAudio = isset($_POST['url_audio']) ? $_POST['url_audio'] : '';
	$audioTest = "modules/player/audio/$urlAudio";
?>
<div class="row">
  <div class="col-lg-6">
    <audio id='pa-file' src="<?=$audioTest?>"></audio>
    <button class="btn btn-sm btn-info" id="pa-play"><i class="fa fa-play"></i></button>
    <button class="btn btn-sm btn-info" id="pa-stop"><i class="fa fa-stop"></i></button>
    <button class="btn btn-sm btn-default" id="pa-repeat"><i class="fa fa-repeat"></i></button>
    <button class="btn btn-sm btn-default" id="pa-vol-mute"><i class="fa fa-volume-up"></i></button>

    <!-- <button class="btn btn-sm btn-default"><i class="fa fa-backward"></i></button> -->
    <!-- <button class="btn btn-sm btn-default"><i class="fa fa-forward"></i></button> -->
    <!-- <button class="btn btn-sm btn-default"><i class="fa fa-random"></i></button> -->
  </div>
  <div class="col-lg-6 text-right">
    <i id="pa-l-time-atual">00:00:00</i> / <i id="pa-l-time-total">00:00:00</i>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <input type="range" min="1" max="100" value="0" class="slider" id="pa-bar-time">
  </div>
</div>
<div class="row">
	<div class="col-lg-8">
    <button class="btn btn-sm btn-default pa-play-custom" duration="3"><i class="fa fa-play"></i> 3s</button>
    <button class="btn btn-sm btn-default pa-play-custom" duration="10"><i class="fa fa-play"></i> 10s</button>
    <button class="btn btn-sm btn-default pa-vol-down" duration="3" end-pause="1"><i class="fa fa-pause"></i> 3s</button>
  	<button class="btn btn-sm btn-default pa-vol-down" duration="10" end-pause="1"><i class="fa fa-pause"></i> 10s</button>
	</div>
	<div class="col-lg-4">
		<input type="range" min="1" max="100" value="100" class="slider" id="pa-bar-volume">
	</div>
</div>

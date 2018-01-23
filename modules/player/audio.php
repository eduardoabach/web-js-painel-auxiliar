<?php 
  $urlAudio = isset($_POST['url_audio']) ? $_POST['url_audio'] : '';
	$audioTest = "modules/player/audio/$urlAudio";
?>
<div class="row">
  <div class="col-lg-8">
    <audio id='pa-file' src="<?=$audioTest?>"></audio>
    <button class="btn btn-sm btn-info" id="pa-play"><i class="fa fa-play"></i></button>
    <button class="btn btn-sm btn-info" id="pa-stop"><i class="fa fa-stop"></i></button>
    <button class="btn btn-sm btn-default pa-play-custom" duration="3"><i class="fa fa-play"></i> 3s</button>
    <button class="btn btn-sm btn-default pa-play-custom" duration="10"><i class="fa fa-play"></i> 10s</button>
    <button class="btn btn-sm btn-default" id="pa-repeat"><i class="fa fa-repeat"></i></button>

    <!-- <button class="btn btn-sm btn-default"><i class="fa fa-backward"></i></button> -->
    <!-- <button class="btn btn-sm btn-default"><i class="fa fa-forward"></i></button> -->
    <!-- <button class="btn btn-sm btn-default"><i class="fa fa-random"></i></button> -->
  </div>
  <div class="col-lg-4">
    <i id="pa-l-time-atual">00:00</i> / <i id="pa-l-time-total">00:00</i>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <input type="range" min="1" max="100" value="0" class="slider" id="pa-bar-time">
  </div>
</div>
<div class="row">
	<div class="col-lg-8">
    <button class="btn btn-sm btn-default pa-vol-down" duration="3" end-pause="1"><i class="fa fa-volume-down"></i> 3s</button>
		<button class="btn btn-sm btn-default pa-vol-down" duration="10" end-pause="1"><i class="fa fa-volume-down"></i> 10s</button>
		<button class="btn btn-sm btn-default" id="pa-vol-mute"><i class="fa fa-volume-up"></i></button>
	</div>
	<div class="col-lg-4">
		<input type="range" min="1" max="100" value="100" class="slider" id="pa-bar-volume">
	</div>
</div>



<style>

input[type=range] {
  -webkit-appearance: none;
  width: 100%;
  margin: 5.5px 0;
}
input[type=range]:focus {
  outline: none;
}
input[type=range]::-webkit-slider-runnable-track {
  width: 100%;
  height: 12px;
  cursor: pointer;
  background: #b6b6b6;
  border-radius: 6px;
  border: 0px;
}
input[type=range]::-webkit-slider-thumb {
  border: 0px solid;
  height: 23px;
  width: 23px;
  border-radius: 12px;
  background: #505050;
  cursor: pointer;
  -webkit-appearance: none;
  margin-top: -5.5px;
}
input[type=range]:focus::-webkit-slider-runnable-track {
  background: #c3c3c3;
}
input[type=range]::-moz-range-track {
  width: 100%;
  height: 12px;
  cursor: pointer;
  background: #b6b6b6;
  border-radius: 6px;
  border: 0px;
}
input[type=range]::-moz-range-thumb {
  border: 0px;
  height: 23px;
  width: 23px;
  border-radius: 12px;
  background: #505050;
  cursor: pointer;
}
input[type=range]::-ms-track {
  width: 100%;
  height: 12px;
  cursor: pointer;
  background: transparent;
  border-color: transparent;
  color: transparent;
}
input[type=range]::-ms-fill-lower {
  background: #a9a9a9;
  border: 0px;
  border-radius: 12px;
}
input[type=range]::-ms-fill-upper {
  background: #b6b6b6;
  border: 0px;
  border-radius: 12px;
}
input[type=range]::-ms-thumb {
  border: 0px;
  height: 23px;
  width: 23px;
  border-radius: 12px;
  background: #505050;
  cursor: pointer;
  height: 12px;
}
input[type=range]:focus::-ms-fill-lower {
  background: #b6b6b6;
}
input[type=range]:focus::-ms-fill-upper {
  background: #c3c3c3;
}

</style>

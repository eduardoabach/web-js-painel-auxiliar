define(
	["jquery", "app", "func", "bootstrap"],
	function ($, App) {
		return function() {
			return {
				Url: function(view){
					return url_view('player',view);
				},
				Init: function(){
					var self = this;
					App.Modal({
						title: 'Player',
						url: self.Url('form'),
						size_class: 'col-lg-4',
						callback: function(div){
							self.Render(div);
						}
					});
				},
				Render: function(el_content){
					var self = this;

					el_content.find('.p-ini-audio').on('click',function(){
						self.Audio('', 'Audio - Teste');
					});
				},
				Audio: function(urlAudio, modalTitulo){
					var self = this;

					//https://developer.mozilla.org/pt-BR/docs/Web/HTML/Using_HTML5_audio_and_video
					//https://github.com/iainhouston/bootstrap3_player olhar e pegar algumas coisas uteis

					// document.getElementById('player-demo-test').volume+=0.1
					// document.getElementById('player-demo-test').volume-=0.1

					// var mediaElement = document.getElementById('mediaElementID');
					// mediaElement.seekable.start();  // Retorna o tempo em que o arquivo começa (em segundos)
					// mediaElement.seekable.end();    // Retorna o tempo em que o arquivo termina (em segundos)
					// mediaElement.currentTime = 122; // Ir para 122 segundos
					// mediaElement.played.end();      // Retorna o numero de segundos que o navegador reproduziu


					// para parar o download das mídias basta pausar e remover o src, pode ser util para barrar o consumo de banda em um certo momento
					// var mediaElement = document.getElementById("myMediaElementID");
					// mediaElement.pause();
					// mediaElement.src = "";


					App.Modal({
						title: modalTitulo,
						url: self.Url('audio'),
						size_class: 'col-lg-4',
						callback: function(div){
							var playerAudio = div.find('#pa-file');

							div.find('#pa-play').on('click', function(){
								var el = playerAudio.get(0);
								if (el.paused == false) {
									el.pause();
								} else {
									el.play();
								}
							});
						}
					});
				}
			}
		}
	}
);
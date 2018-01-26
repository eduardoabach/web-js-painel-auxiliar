define(
	[],
	function () {
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
						self.Audio($(this).data('url-audio'), $(this).html());
					});
				},
				Audio: function(urlAudio, modalTitulo){
					var self = this;

					//https://www.w3schools.com/tags/ref_av_dom.asp
					//https://developer.mozilla.org/pt-BR/docs/Web/HTML/Using_HTML5_audio_and_video
					//https://github.com/iainhouston/bootstrap3_player olhar e pegar algumas coisas uteis
					// para parar o download das mídias basta pausar e remover o src, pode ser util para barrar o consumo de banda em um certo momento
					// var mediaElement = document.getElementById("myMediaElementID");
					// mediaElement.src = "";

					App.Modal({
						title: modalTitulo,
						url: self.Url('audio'),
						size_class: 'col-lg-4',
						data: {url_audio : urlAudio},
						callback: function(div){
							var playerAudio = div.find('#pa-file');
							var elP = playerAudio.get(0);
							var bPlay = div.find('#pa-play');
							var barTime = div.find('#pa-bar-time');
							var barVolume = div.find('#pa-bar-volume');
							var labelTimeTotal = div.find('#pa-l-time-total');
							var labelTimeAtual = div.find('#pa-l-time-atual');

							elP.onloadedmetadata = function() {
								barTime.attr('max', elP.duration.toFixed(2));
								labelTimeTotal.html(seconds_to_time(elP.duration));
							}; 

							elP.ontimeupdate = function() {
							    barTime.val(elP.currentTime);
							    labelTimeAtual.html(seconds_to_time(elP.currentTime));
							};

							barTime.on('change', function(){
								elP.currentTime = barTime.val();	
							});

							elP.onended = function() {
							    bPlay.find('i').attr('class', 'fa fa-play');
							};

							bPlay.on('click', function(){
								if (elP.paused == false) {
									elP.pause();
									bPlay.find('i').attr('class', 'fa fa-play');
								} else {
									elP.play();
									bPlay.find('i').attr('class', 'fa fa-pause');
								}
							});

							var bPlayCustom = div.find('.pa-play-custom');
							bPlayCustom.on('click', function(){
								var bPlayAt = $(this);
								if(bPlayAt.attr('duration') > 0){
									var volumeFinal = 1; // padrão usa o maximo
									var tempoOperacao = bPlayAt.attr('duration') * 1000; // attrib em segundos, converte para milisegundos
									var intervaloDef = 100; // milisegundos, quanto menor mais suave a transicao, mas gasta mais processamento
									var fracaoVolume = volumeFinal / (tempoOperacao / intervaloDef);
									fracaoVolume = fracaoVolume.toFixed(6); // reduzir casas para reduzir demanda de processamento

									// evitar algum erro que poderia geraria um loop infinito
									if(!(fracaoVolume > 0))
										fracaoVolume = 0.1;

									// mutar o audio antes de iniciar
									elP.volume = 0;
									if(elP.paused == true) // garantir que o áudio está em andamento
										bPlay.click();
									
									var timeEventPlay = setInterval( function request(){
										var novoVolume = elP.volume + Number(fracaoVolume);
										if(novoVolume <= volumeFinal)
											elP.volume = novoVolume;
										else 
											elP.volume = volumeFinal;

										if(elP.volume == volumeFinal){
											clearInterval(timeEventPlay);
										}
									}, intervaloDef); //milisegundos
								} else {
									bPlay.click();
								}
							});

							div.find('#pa-stop').on('click', function(){
								elP.currentTime = 0;
								elP.pause();
								bPlay.find('i').attr('class', 'fa fa-play');
							});

							elP.onvolumechange = function() {
							    barVolume.val(elP.volume * 100);
							}; 
							barVolume.on('change', function(){
								elP.volume = barVolume.val() / 100;	
							});

							div.find('.pa-vol-up').on('click', function(){
								if(elP.volume <= 0.9)
									elP.volume += 0.1;
								else 
									elP.volume = 1;
							});

							var bVolDown = div.find('.pa-vol-down');
							bVolDown.on('click', function(){
								var bVolAt = $(this);
								if(bVolAt.attr('duration') > 0){
									var tempoOperacao = bVolAt.attr('duration') * 1000; // attrib em segundos, converte para milisegundos
									var intervaloDef = 100; // milisegundos, quanto menor mais suave a transicao, mas gasta mais processamento
									var fracaoVolume = elP.volume / (tempoOperacao / intervaloDef);
									fracaoVolume = fracaoVolume.toFixed(6); // reduzir casas para reduzir demanda de processamento

									// evitar algum erro que poderia geraria um loop infinito
									if(!(fracaoVolume > 0))
										fracaoVolume = 0.1;

									var timeEvent = setInterval( function request(){
										if(elP.volume >= fracaoVolume)
											elP.volume -= fracaoVolume;
										else 
											elP.volume = 0;

										if(elP.volume == 0){
											clearInterval(timeEvent);
											if(bVolAt.attr('end-pause') > 0)
												bPlay.click();
										}
									}, intervaloDef); //milisegundos
								} else {
									if(elP.volume >= 0.1)
										elP.volume -= 0.1;
									else 
										elP.volume = 0;
								}
							});

							var bMute = div.find('#pa-vol-mute');
							bMute.on('click', function(){
								if(elP.muted){
									elP.muted = false;
									bMute.removeClass('btn-info').addClass('btn-default');
								} else {
									elP.muted = true;
									bMute.removeClass('btn-default').addClass('btn-info');
								}
							});

							var bRepat = div.find('#pa-repeat');
							bRepat.on('click', function(){
								if(elP.loop){
									elP.loop = false;
									bRepat.removeClass('btn-info').addClass('btn-default');
								} else {
									elP.loop = true;
									bRepat.removeClass('btn-default').addClass('btn-info');
								}
							});
							
						}
					});
				}
			}
		}
	}
);
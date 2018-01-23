define(
	["jquery", "app", "func", "bootstrap"],
	function ($, App) {
		return function() {
			return {
				Url: function(view){
					return url_view('webcam',view);
				},
				Init: function(){
					var self = this;
					App.Modal({
						title: 'Webcam',
						url: self.Url('form'),
						size_class: 'col-lg-3',
						callback: function(div){
							self.Render(div);
						}
					});
				},
				Render: function(el_content){
					var self = this;
					navigator.getUserMedia = navigator.webkitGetUserMedia || navigator.getUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
					window.URL = window.URL || window.webkitURL;

					var camera = el_content.find('#camera').get(0);
					var foto_preview = el_content.find('#foto_preview').get(0);
					var foto_tirada = el_content.find('#foto_tirada').get(0);

					el_content.find('#inicio').on('click', function (e) {
				        if (!navigator.getUserMedia) {
			                alert('É preciso autorizar o navegador para acessar o device.');
			                return false;
				        }
				        
				        navigator.getUserMedia({audio: false, video: true}, function (stream) {
			                foto_ativo = true;
			                el_content.find('#salvar').removeAttr('disabled');
			                
			                if (window.URL) {
		                        camera.src = window.URL.createObjectURL(stream);
			                } else {
		                        camera.src = stream; // Opera.
			                }

			                camera.onerror = function (e) {
		                       stream.stop();
			                };
			                setTimeout(function () {
		                        foto_preview.width = camera.width;
		                        foto_preview.height = camera.height;
			                }, 50);
				        }, function (e) {
			                var msg = 'Nenhuma câmera conectada.';
			                if (e.code == 1) {
			                   msg = 'Acesso à câmera negado pelo usuário.';
			                }
			                App.alerta(msg);
				        });
					});

					var bImgDownload = el_content.find('#img-download');
					bImgDownload.hide();
					bImgDownload.on('click', function(){
						file_download(foto_tirada.src, 'img.png');
					});

					el_content.find('#salvar').on('click',function (e) {
					        e.preventDefault();
					        bImgDownload.show();

					        //tirar foto
					        foto_preview.getContext('2d').drawImage(camera, 0, 0, 235, 175);
					        foto_tirada.src = foto_preview.toDataURL('image/webp');
					        
					        //salvar ela
					        //el_content.find('#foto_salvar').val(foto_tirada.src);
					        //var formImg = el_content.find('#form-imagem');
					        //formImg.submit();
					});
				}
			}
		}
	}
);
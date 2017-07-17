define(
	["jquery", "app", "tempo/relogio_tool", "func", "func_number", "bootstrap"],
	function ($, App) {
		return {
			Url: function(view){
				return url_view('tempo',view);
			},
			Init: function(){
				var self = this;
				App.Modal({
					title: 'Tempo',
					url: self.Url('form'),
					size_class: 'col-lg-4',
					callback: function(div){
						
					}
				});
			},
			InfoDia: function(data_dia){
				var self = this;
				App.Modal({
					title: 'Informações do dia',
					url: self.Url('info_dia'),
					size_class: 'col-lg-4',
					data: {data_dia : data_dia},
					callback: function(div){
						self.InitRelogio(div);
					}
				});
			},
			InitRelogio: function(content){
				var elHora = content.find('#tm-h');
				var elMin = content.find('#tm-m');
				var elSeg = content.find('#tm-s');

				var relogioObj = new RelogioTool;
				relogioObj.Init( parseFloat(elHora.html()), parseFloat(elMin.html()), parseFloat(elSeg.html()));
				this.AtualizaRelogio(elHora, elMin, elSeg, relogioObj);
			},
			AtualizaRelogio: function(elHora, elMin, elSeg, relogioObj){
				var self = this;

				setTimeout( function request(){
					elHora.html(number_pad_zero(relogioObj.hora));
					elMin.html(number_pad_zero(relogioObj.minuto));
					elSeg.html(number_pad_zero(relogioObj.segundo));
					self.AtualizaRelogio(elHora, elMin, elSeg, relogioObj);
				}, 1000); //milisegundos
			}
		}
	}
);
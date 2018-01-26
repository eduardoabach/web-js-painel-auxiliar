define(
	["modules/tempo/relogio_tool", "assets/js/func_number"],
	function () {
		return function(){
			return {			
				relogioTimeDom: null,
				relogioElApi: null,
				elHora: null,
				elMin: null,
				elSeg: null,

				Url: function(view){
					return url_view('tempo',view);
				},

				Init: function(){
					var self = this;
					App.Modal({
						title: 'Tempo',
						url: this.Url('form'),
						size_class: 'col-lg-4',
						callback: function(div){
							self.InitRelogio(div);
						}
					});
				},

				InfoDia: function(data_dia, exibir_relogio){
					var self = this;
					if(exibir_relogio == undefined)
						exibir_relogio = false;

					App.Modal({
						title: 'Informações do dia',
						url: self.Url('info_dia'),
						size_class: 'col-lg-4',
						data: {data_dia : data_dia, exibir_relogio: exibir_relogio},
						callback: function(div){
							if(exibir_relogio)
								self.InitRelogio(div);
						}
					});
				},

				InfoDiaAtual: function(){
					var self = this;
					self.InfoDia('', true); // data ele pega por padrão depois o dia atual
				},
			
				InitRelogio: function(content){
					this.elHora = content.find('#tm-h');
					this.elMin = content.find('#tm-m');
					this.elSeg = content.find('#tm-s');

					this.relogioElApi = new RelogioTool;
					this.relogioElApi.Init( parseFloat(this.elHora.html()), parseFloat(this.elMin.html()), parseFloat(this.elSeg.html()));
					this.RelogioDom();
				},
				
				RelogioDom: function(){
					var self = this;
					if(self.relogioElApi.status == true){
						self.relogioTimeDom = setTimeout( function request(){
							self.elHora.html(number_pad_zero(self.relogioElApi.hora));
							self.elMin.html(number_pad_zero(self.relogioElApi.minuto));
							self.elSeg.html(number_pad_zero(self.relogioElApi.segundo));
							self.RelogioDom();
						}, 1000); //milisegundos
					}
				},
				
				PauseRelogio: function(){
					clearTimeout(relogioTimeDom);
					relogioElApi.Pause();
				}

			}
		}
	}
);
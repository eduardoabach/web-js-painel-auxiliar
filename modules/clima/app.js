define(
	["jquery", "app", "clima/drawPlanetPhase", "func", "bootstrap"],
	function ($, App) {
		return {
			Url: function(view){
				return url_view('clima',view);
			},
			Init: function(){
				var self = this;
				App.Modal({
					title: 'Clima',
					url: self.Url('form'),
					size_class: 'col-lg-2',
					callback: function(div){
						self.Render(div);
					}
				});
			},
			Render: function(el_content){
				var self = this;
				
				el_content.find('.prev-clima').on('click',function(){
					var idCidade = $(this).data('cidade');
					if(idCidade > 0){
						self.PrevClima(idCidade);
					} else {
						alert('Código da cidade incorreto.');
					}
				});
			},
			PrevClima: function(idCidade){
				var self = this;
				App.Modal({
					title: 'Clima - Cidade',
					url: self.Url('prev_clima'),
					size_class: 'col-lg-4',
					data: {id_cidade : idCidade},
					callback: function(div){

						div.find('.lua-fase').each(function(){
							var fase = $(this).data('fase'); // 0.1 ~ 1
							var tamanho = $(this).data('size'); // 10, 30, 50. Em px
							drawPlanetPhase(this, fase, false, {diameter: tamanho, blur:0});
						});

						div.find('.info-dia').on('click',function(){
							var dataDia = $(this).data('dia');
							if(dataDia != undefined && dataDia != ''){
								require([('tempo/app')], function(mod_name){
									mod_name.InfoDia(dataDia);
								});	
							}
						});
					}
				});
			}
		}
	}
);
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
						// drawPlanetPhase(div.find('#teste-lua').get(0), 0.15, true, {diameter:50, earthshine:0.1, blur:10, lightColour: '#9bf'});
						drawPlanetPhase(div.find('#teste-lua').get(0), 0.3, false, {diameter:30, blur:0, shadowColour: '#666666', lightColour:  '#cccccc'});
						//self.Render(div);
					}
				});
			}
		}
	}
);
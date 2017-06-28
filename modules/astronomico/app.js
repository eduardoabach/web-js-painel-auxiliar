define(
	["jquery", "app", "func", "bootstrap"],
	function ($, App) {
		return {
			Url: function(view){
				return url_view('astronomico',view);
			},
			Init: function(){
				var self = this;
				App.Modal({
					title: 'Astronomico',
					url: self.Url('form'),
					size_class: 'col-lg-4',
					callback: function(div){
						
					}
				});
			},
			Calendario: function(el_text){
				var self = this;
				// fases da lua
				// eventos solares, solticios, equinocios
				// trocas de estações
			}
		}
	}
);
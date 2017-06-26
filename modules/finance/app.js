define(
	["jquery", "app", "func", "bootstrap"],
	function ($, App) {
		return {
			Url: function(view){
				return url_view('finance',view);
			},
			Init: function(){
				var self = this;
				App.Modal({
					title: 'Indicadores Financeiros',
					url: self.Url('form'),
					size_class: 'col-lg-4',
					callback: function(div){
						self.Render(div);
					}
				});
			},
			Render: function(el_content){
				var self = this;

				el_content.find('.f-opt').click(function(){
					var s_option = $(this).data('option');
					self.PainelFinan(s_option);
				});
			},
			PainelFinan: function(comand, titulo){
				var self = this;

				if(titulo == undefined)
					titulo = 'Painel Financeiro';

				App.Modal({
					title: titulo,
					url: self.Url(comand),
					size_class: 'col-lg-6',
					callback: function(div){
					}
				});
			}
		}
	}
);
define(
	[],
	function () {
		return function() {
			return {
				Url: function(view){
					return url_view('finance',view);
				},
				Init: function(){
					var self = this;
					App.Modal({
						title: 'Indicadores Financeiros',
						url: self.Url('form'),
						size_class: 'col-lg-3',
						callback: function(div){
							self.Render(div);
						}
					});
				},
				Render: function(el_content){
					var self = this;
					el_content.find('.f-opt').click(function(){
						var s_option = $(this).data('option');
						var titulo = $(this).html();
						self.PainelFinan(s_option, titulo);
					});
				},
				PainelFinan: function(comand, titulo){
					var self = this;

					if(titulo == undefined)
						titulo = 'Painel Financeiro';

					var tamanho = 'col-lg-5';
					if(comand == 'moedas')
						tamanho = 'col-lg-4';

					App.Modal({
						title: titulo,
						url: self.Url(comand),
						size_class: tamanho,
						callback: function(div){
						}
					});
				}
			}
		}
	}
);
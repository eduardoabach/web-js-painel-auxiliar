define(
	["jquery", "func", "func_number", "bootstrap"],
	function ($, func, func_number) {
		return {
			Title: 'Gerador Docs',
			Url: function(view){
				return url_view('gerador_docs',view);
			},
			Init: function(el_local){
				var self = this;
				var url = this.Url('form');

				$.post(url, {}, function (html_view) {
					el_local.html(html_view);
					self.Render(el_local);
				});
			},
			Render: function(el_content){
				var self = this;

				el_content.find('#btn-gerar-cpf').click(function(){
					var campo = el_content.find('#result-doc');
					self.GerarCPF(campo, true);
				});

				el_content.find('#btn-gerar-cnpj').click(function(){
					var campo = el_content.find('#result-doc');
					self.GerarCNPJ(campo, true);
				});
			},
			GerarCPF: function(el_result, comPontos){
				el_result.val(mk_cpf(comPontos));
			},
			GerarCNPJ: function(el_result, comPontos){
				el_result.val(mk_cnpj(comPontos));
			}
		}
	}
);
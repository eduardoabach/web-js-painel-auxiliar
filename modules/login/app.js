define(
	[],
	function () {
		return function() {
			return {
				Url: function(view){
					return url_view('login',view);
				},
				Init: function(){
					var self = this;
					App.Modal({
						title: 'Acesso Restrito',
						url: self.Url('form'),
						size_class: 'col-lg-12',
						callback: function(div){
							self.Render(div);
						}
					});
				},
				Render: function(el_content){
					var self = this;

					//el_content.find('#btn-gerar-cnpj').click(function(){
					//	var campo = el_content.find('#result-doc');
					//	self.GerarCNPJ(campo, true);
					//});
				}
				//GerarCPF: function(el_result, comPontos){
				//	el_result.val(mk_cpf(comPontos));
				//}
			}
		}
	}
);
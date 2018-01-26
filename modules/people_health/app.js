define(
	["assets/js/func_number"],
	function () {
		return function() {
			return {
				Url: function(view){
					return url_view('calculadora',view);
				},
				Init: function(){
					var self = this;
					App.Modal({
						title: 'Saúde',
						url: self.Url('form'),
						size_class: 'col-lg-4',
						callback: function(div){
							self.Render(div);
						}
					});
				},
				Render: function(el_content){
					var self = this;
					self.RenderIMC(el_content.find('#estrutura-imc'));
				},
				RenderIMC: function(el_content){
					var self = this;
					el_content.find('#btn-calc-imc').click(function(){
						var peso_imc = el_content.find('#peso-imc').val();
						var altura_imc = el_content.find('#altura-imc').val();
						var resultado_imc = peso_imc / (altura_imc * altura_imc);
						el_content.find('#result-imc').val(resultado_imc);
					});
				}
			}
		}
	}
);
define(
	["assets/js/func_number"],
	function () {
		return function() {
			return {
				Url: function(view){
					return url_view('calc',view);
				},
				Init: function(){
					var self = this;
					App.Modal({
						title: 'Calculadora',
						url: self.Url('form'),
						size_class: 'col-lg-3',
						callback: function(div){
							self.Render(div);
						}
					});
				},
				Render: function(el_content){
					var self = this;
					el_content.find('.btn-num-calc').click(function(){
						var comando = $(this).data('comando');
						self.EventoComandoCalc(comando,el_content);
					});

					el_content.find('#result-calc').keyup(function( event ){
						if ( event.which == 13 ) {
							event.preventDefault();
							self.EventoComandoCalc('=',el_content);
						}
					});
				},
				EventoComandoCalc: function(comando,el_content){
					var result_calc = el_content.find('#result-calc');
					if(comando == 'c'){
						result_calc.val('').focus();
					} else if(comando == '='){
						result_calc.val(eval(result_calc.val())).focus();
						//Calc.Input.value = eval(Calc.Input.value)
					} else {
						result_calc.val(result_calc.val()+comando).focus();
					}
				}
			}
		}
	}
);
define(
	["jquery", "app", "func", "func_cript", "bootstrap"],
	function ($, App) {
		return function() {
			return {
				Url: function(view){
					return url_view('avaliador',view);
				},
				Init: function(){
					var self = this;
					self.AvaliarCarro();
					// App.Modal({
					// 	title: 'Avaliador',
					// 	url: self.Url('form'),
					// 	size_class: 'col-lg-4',
					// 	callback: function(div){
					// 		self.Render(div);
					// 	}
					// });
				},
				Render: function(el_content){
					var self = this;
					var elString = el_content.find('#cript-text');

					el_content.find('#cript-act-e').click(function(){
						self.EventE(elString);
					});
					el_content.find('#cript-act-d').click(function(){
						self.EventD(elString);
					});
				},
				AvaliarCarro: function(){
					var self = this;
					App.Modal({
						title: 'Avaliar Carro',
						url: self.Url('form'),
						size_class: 'col-lg-5',
						callback: function(div){
							div.find('#execAval').on('click',function(){
								var infoAval = self.ExecutarAval(div.find('#form-aval').serielize());
								console.log(infoAval);
							});
						}
					});
				},
				ExecutarAval: function(jData){
					
				},
			}
		}
	}
);
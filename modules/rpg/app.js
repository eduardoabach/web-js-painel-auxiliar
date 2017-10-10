define(
	["jquery", "app", "func", "bootstrap"],
	function ($, App) {
		return function() {
			return {
				Url: function(view){
					return url_view('rpg',view);
				},
				Init: function(){
					var self = this;
					App.Modal({
						title: 'Rpg',
						url: self.Url('form'),
						size_class: 'col-lg-4',
						callback: function(div){
							self.Render(div);
						}
					});
				},
				Render: function(el_content){
					var self = this;
					var elString = el_content.find('#cript-text');

					el_content.find('#cript-act-e').click(function(){
						self.EventE(elString);
					});
				},
				EventE: function(el_text){
					var result = base_64_encode(el_text.val());
					el_text.val(result);
				},
				CriarPersonagem: function(){
					var forSerial = $('#formDadosPerson').serialize();
					$.post('function.php',forSerial,
					function(response) {
						$("#personagemGerado").html(unescape(response));
					});
				}
			}
		}
	}
);
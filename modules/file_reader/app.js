define(
	["jquery", "app", "func", "bootstrap"],
	function ($, App) {
		return function() {
			return {
				Url: function(view){
					return url_view('file_reader',view);
				},
				Init: function(){
					var self = this;
					App.Modal({
						title: 'Leitor de Arquivos',
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
						self.EventRead(elString);
					});
				},
				EventRead: function(el_text){
					//pendente
				}
			}
		}
	}
);
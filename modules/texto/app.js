define(
	["assets/js/func_cript"],
	function () {
		return function() {
			return {
				Url: function(view){
					return url_view('texto',view);
				},
				Init: function(){
					var self = this;
					App.Modal({
						title: 'Texto',
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
					el_content.find('#cript-act-d').click(function(){
						self.EventD(elString);
					});
				},
				EventE: function(el_text){
					var result = base_64_encode(el_text.val());
					el_text.val(result);
				},
				EventD: function(el_text){
					var result = base_64_decode(el_text.val()); 
					el_text.val(result);
				}
			}
		}
	}
);
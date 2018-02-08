define(
	[],
	function () {
		return function() {
			return {
				Url: function(view){
					return url_view('conv_unidades',view);
				},
				Init: function(){
					var self = this;
					App.Modal({
						title: 'Conversor de Unidades de Medida',
						url: self.Url('form'),
						size_class: 'col-lg-5',
						callback: function(div){
							self.Render(div);
						}
					});
				},
				Render: function(el_content){
					var self = this;
					var elString = el_content.find('#cript-text');

					el_content.find('#cript-act-e').click(function(){
						elString.val(base_64_encode(elString.val()));
					});

					el_content.find('#cript-act-d').click(function(){
						elString.val(base_64_decode(elString.val()));
					});

					el_content.find('#string-reverse').click(function(){
						elString.val(string_reverse(elString.val()));
					});

					el_content.find('#string-random').click(function(){
						elString.val(get_random_caracteres(20));
					});

					el_content.find('#string-lower').click(function(){
						var str = elString.val();
						elString.val(str.toLowerCase());
					});

					el_content.find('#string-upper').click(function(){
						var str = elString.val();
						elString.val(str.toUpperCase());
					});

				}
			}
		}
	}
);
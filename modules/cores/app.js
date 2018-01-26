define(
	[],
	function () {
		return function() {
			return {
				Url: function(view){
					return url_view('cores',view);
				},
				Init: function(){
					var self = this;
					App.Modal({
						title: 'Cores',
						url: self.Url('form'),
						size_class: 'col-lg-8',
						callback: function(div){
							self.Render(div);
						}
					});
				},
				Render: function(el_content){
					var self = this;
					//el_content.find('#estrutura');
				}
			}
		}
	}
);
define(
	[],
	function () {
		return function() {
			return {
				ListLink: {
					'Bootstrap': 'http://getbootstrap.com/css/',
					'Alexanmtz git io': 'http://alexanmtz.github.io/bootstrap/components.html'},
				Url: function(view){
					return url_view('bootstrap_help',view);
				},
				Init: function(){
					var self = this;
					App.Modal({
						title: 'Bootstrap Help',
						url: self.Url('form'),
						size_class: 'col-lg-12',
						callback: function(div){
							self.Render(div);
						}
					});
				},
				Render: function(el_content){
					var self = this;
					var help_content = el_content.find('#help-content');

					el_content.find('.help-opt').click(function(){
						var help_option = $(this).data('help');
						self.InitHelp(help_content,help_option);
					});
				},
				InitHelp: function(el_help_content,help_option){
					var self = this;
					var url = this.Url('help_' + help_option);
					$.post(url, {}, function (help_view) {
						el_help_content.html(help_view);
					});
				}
			}
		}
	}
);

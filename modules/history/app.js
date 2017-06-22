define(
	["jquery", "app", "func", "bootstrap"],
	function ($, App) {
		return {
			Url: function(view){
				return url_view('history',view);
			},
			Init: function(){
				var self = this;
				App.Modal({
					title: 'História',
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
			}
		}
	}
);
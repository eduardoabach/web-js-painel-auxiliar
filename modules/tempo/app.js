define(
	["jquery", "app", "func", "bootstrap"],
	function ($, App) {
		return {
			Url: function(view){
				return url_view('tempo',view);
			},
			Init: function(){
				var self = this;
				App.Modal({
					title: 'Tempo',
					url: self.Url('form'),
					size_class: 'col-lg-4',
					callback: function(div){
						
					}
				});
			},
			InfoDia: function(data_dia){
				var self = this;
				App.Modal({
					title: 'Informações do dia',
					url: self.Url('info_dia'),
					size_class: 'col-lg-4',
					data: {data_dia : data_dia},
					callback: function(div){
									
					}
				});
			}
		}
	}
);
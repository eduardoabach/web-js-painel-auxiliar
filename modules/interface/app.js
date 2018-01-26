define(
	["assets/js/func_number"],
	function () {
		return function() {
			return {
				Url: function(view){
					return url_view('interface',view);
				},
				Init: function(el_local){
					var self = this;
					var url = this.Url('form');
					$.post(url, {}, function (html_view) {
						el_local.html(html_view);
						self.Render(el_local);
					});
				},
				Render: function(el_content){
					var self = this;

					el_content.find('.get-module').click(function(){
						var mod_name = $(this).data('option');
						var func_name = $(this).data('func');
						if(func_name == undefined)
							func_name = 'Init';

						require([('modules/'+mod_name+'/app')], function(mod_name){
							var ObjAtual = new mod_name();
							ObjAtual[func_name]();
						});
					});
				}
			}
		}
    }
);
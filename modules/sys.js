var Sys = new function () {

	var _var = {
	};

	el_content.find('.get-module').click(function(){
		var m_list = el_content.find('#module-list');
		var m_option = $(this).data('option');

		require(['module_panel'], function(module_panel){
			module_panel.Init(m_list,m_option);
		});
	});

	this.callModule = function (module, callback) {
	  var split = trim(module, '/').split('/');
	  var module = 'js/' + split[0] + '/objetos/' + split[1];

	  requirejs([module], function (Module) {
	     if (_.isFunction(callback)) {
	        callback(Module);
	     }
	  });
	}

	/*this.callModule = function (module, callback) {
	  var split = trim(module, '/').split('/');
	  var module = 'js/' + split[0] + '/objetos/' + split[1];

	  requirejs([module], function (Module) {
	     if (_.isFunction(callback)) {
	        callback(Module);
	     }
	  });
	}*/

	this.show_loading = function (status) {
	  _variables.loading.active = _.isUndefined(status) ? false : (_.isBoolean(status) ? status : false);
	  return this;
	};
}
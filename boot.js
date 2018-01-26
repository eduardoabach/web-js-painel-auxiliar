;(function( undefined ) {
	'use strict';

	require.config({  
		name: 'Painel',
   		urlArgs: "nocache=" + (new Date()).getTime(),
   		catchError: true,
		baseUrl: _System.url,
		paths: {
			func_date : 'assets/js/func_date',
			func_number : 'assets/js/func_number',
			func_cript : 'assets/js/func_cript',
			func_search : 'assets/js/func_search'
		},
		// shim: {
  //       	bootstrap: {
  //           	deps: ['jquery']
  //       	}
  //   	}
	});

	require(['modules/interface/app'], function(Interface){
		var el_local = $('#painel-content');
		var InterfaceAtual = new Interface();
		InterfaceAtual.Init(el_local);
	});
})();

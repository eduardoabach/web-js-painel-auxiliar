;(function( undefined ) {
	'use strict';

	require.config({  
		name: 'Painel',
		baseUrl: "modules",
		paths: {
			jquery : '../assets/js/jquery-2.2.4.min',
			bootstrap : '../assets/bootstrap/js/bootstrap.min',
			app : '../assets/js/app',
			func : '../assets/js/func',
			func_date : '../assets/js/func_date',
			func_number : '../assets/js/func_number',
			func_cript : '../assets/js/func_cript',
			func_search : '../assets/js/func_search'
		},
		shim: {
        	bootstrap: {
            	deps: ['jquery']
        	}
    	}
	});

	require(['jquery', 'interface/app'], function($, Interface){
		var el_local = $('#painel-content');
		var InterfaceAtual = new Interface();
		InterfaceAtual.Init(el_local);
	});
})();

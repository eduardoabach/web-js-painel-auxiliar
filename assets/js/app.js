App = {
	Modal: function(options){
		var self = this;
		var title = (typeof options.title != 'undefined') ? options.title : 'Painel';
		var sizePanel = (typeof options.size_class != 'undefined') ? options.size_class : 'col-lg-4';
		var dataModal = (typeof options.data != 'undefined') ? options.data : {};
		var objPanelJq = $(mk_panel(obj_serial(), title, sizePanel)); // criar painel básico

		// config details panel
		objPanelJq.find('#btn-item-fechar').click(function(){
			if(typeof options.onClose != 'undefined'){
				options.onClose();
			}

			objPanelJq.remove(); // limpar jquery, remover elementos e eventos observados
			objPanelJq = null; //limpar variaveis para coletor de memória do navegador descartar
			options = null;
			objConteudo = null;
		});

		set_modal_zindex_top(objPanelJq.get(0));
		draggable(objPanelJq.get(0));

		// antes de post cria carregando
		var objConteudo = objPanelJq.find('#item-content');
		objConteudo.html('<div class="loader"></div>');

		// adicionar no dom nova tela
		$('#painel-content').find('#module-list').append(objPanelJq); 

		// chamada do conteudo da modal requisitado
		$.ajax({
			type: "POST",
			url: options.url,
			data: dataModal,
			//dataType: dataType
			success: function (modal_html) {
				objConteudo.html(modal_html);
				options.callback(objConteudo);
				objPanelJq.show();

			},
			error: function(elErr) { //XMLHttpRequest, textStatus, errorThrown
				objConteudo.html('<div class="alert alert-warning"><strong>Indisponível!</strong> Tente novamente mais tarde.</div>');
				console.log('Erro, ('+elErr.status+') '+elErr.statusText+' = '+elErr.responseText);
			}
		});
	}
};
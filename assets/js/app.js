define(
	["jquery", "func", "bootstrap"],
	function ($) {
		return {
			Modal: function(options){
				var self = this;
				var el_list = $('#painel-content').find('#module-list'); // el da lista de modulos da tela
				var objSerial = obj_serial(); // criar id unico na tela do futuro objeto
				var objDiv = mk_panel(objSerial); // criar painel básico
				el_list.append(objDiv); // adicionar no dom nova tela
				
				var title = 'Painel';
				if(typeof options.title != 'undefined'){
					title = options.title;
				}

				var sizePanel = 'col-lg-4';
				if(typeof options.size_class != 'undefined'){
					sizePanel = options.size_class;
				}

				var dataModal = {};
				if(typeof options.data != 'undefined'){
					dataModal = options.data;
				}

				// chamada da estrutura padrao do model
				var url = url_view('interface','module_panel');
				$.post(url, {}, function (html_view) {
					var objPanelJq = el_list.find('#'+objSerial);
					//objPanelJq.hide();
					objPanelJq.html(html_view);

					// ao criar modal ela fica no topo do zindex
					set_modal_zindex_top(objPanelJq.get(0)); 
					draggable(objSerial);

					//montando css do panel
					objPanelJq.addClass(sizePanel);
					objPanelJq.addClass('nopadding');

					// config details panel
					objPanelJq.find('#item-titulo').html(title);
					objPanelJq.find('#btn-item-fechar').click(function(){
						objDiv.parentNode.removeChild(objDiv);
					});

					// antes de post cria carregando
					var objConteudo = objPanelJq.find('#item-content');
					objConteudo.html('<div class="loader"></div>');

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
				});
			}
		}
	}
);
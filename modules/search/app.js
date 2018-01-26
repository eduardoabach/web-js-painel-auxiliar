define(
	["assets/js/func_search"],
	function () {
		return function() {
			return {
				Url: function(view){
					return url_view('search',view);
				},
				Init: function(){
					var self = this;
					App.Modal({
						title: 'Buscar',
						url: self.Url('form'),
						size_class: 'col-lg-4',
						callback: function(div){
							self.Render(div);
						}
					});
				},
				Render: function(el_content){
					var self = this;

					el_content.find('.search-opt').click(function(){
						var s_option = $(this).data('option');
						var el_active_search = el_content.find('#search-content');

						var url = self.Url('search-'+s_option);
						$.post(url, {}, function (html_view) {
							el_active_search.html(html_view);
							self.RenderSearch(el_active_search, s_option);
						});
					});
				},
				RenderSearch: function(el_content, s_option){
					var self = this;

					el_content.find('#busc-gerar').click(function(){
						self.ExecutarBusca(el_content, s_option);
					});

					el_content.find('#busc-texto').keyup(function(event){
						if(event.which == 13) {
							self.ExecutarBusca(el_content, s_option);
						}
					});
				},
				ExecutarBusca: function(el_content, s_option){
					var self = this;
					var str_busca = el_content.find('#busc-texto').val();

					if(s_option == 'all'){
						self.BuscarGeral(str_busca);

					} else if(s_option == 'whois'){
						self.BuscarWhois(str_busca);

					} else if(s_option == 'map'){
						self.BuscarMapa(str_busca);

					} else if(s_option == 'translate'){
						var optDe = el_content.find('select[id=opt-de]').val();
						var optPara = el_content.find('select[id=opt-para]').val();
						search_translate(str_busca, optDe, optPara);
					}
				},
				BuscarGeral: function(str_busca){
					search_all(str_busca);
				},
				BuscarWhois: function(str_busca){
					search_whois(str_busca);
				},
				BuscarMapa: function(str_busca){
					search_map(str_busca);
				}
			}
		}
	}
);
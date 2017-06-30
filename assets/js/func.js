
function url_view(tela, view){
   return location+'modules/'+tela+'/'+view+'.php';
}

function obj_serial(){
   var numS = '';
   //while($('id-'+numS).length > 0){ // testar novamente e implementar
      numS = Math.floor((Math.random() * 1000) + 1);
   //}
   return 'id-'+numS;
}

function mk_panel(id){
   if(id != undefined){
      var objDiv = document.createElement('div');
      objDiv.className = 'app-painel';
      objDiv.id = id;
      return objDiv;
   }
   return false;
}

// objeto recebido deve ser $
function set_modal_zindex_top(elModal){
   $(elModal).css('z-index', get_modal_max_zindex()+1);
}

function get_modal_max_zindex(){
   var objsModel = document.getElementsByClassName("app-painel");
   return get_max_zindex(objsModel);
}

function get_max_zindex(elementsList){
   var zIndexMax = 0;
   for(var i = 0; i < elementsList.length; i++){
      var zindex=parseFloat(document.defaultView.getComputedStyle(elementsList[i],null).getPropertyValue("z-index"));
      if (zindex > zIndexMax && zindex != 'auto'){
         zIndexMax = zindex;
      }
   }
   return zIndexMax;
}

function draggable(id, desativ){
   var obj = document.getElementById(id);
   obj.style.position = "absolute";

   var objsMove = obj.getElementsByClassName("sys-move");
   Object.keys(objsMove).map(function(objectKey, index) {
      if(desativ === true){
         objsMove[objectKey].onmousedown = null;
      } else {
         objsMove[objectKey].onmousedown = function(){
            // subir modal para o topo ao selecionar
            set_modal_zindex_top(obj);

            window.drag_obj = obj;
            window.drag_obj_x = window.drag_x_pos - obj.offsetLeft;
            window.drag_obj_y = window.drag_y_pos - obj.offsetTop;
         }
      }
   });
}
 
document.onmouseup = function(e){
   window.drag_obj = null;
};

document.onmousemove = function(e){
   window.drag_x_pos = document.all ? window.event.clientX : e.pageX;
   window.drag_y_pos = document.all ? window.event.clientY : e.pageY;

   if(window.drag_obj == null || window.drag_obj == undefined)
      return;

   window.drag_obj.style.left = (window.drag_x_pos - window.drag_obj_x) + 'px';
   window.drag_obj.style.top = (window.drag_y_pos - window.drag_obj_y) + 'px';
};
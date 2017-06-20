
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

function draggable(id){
   var obj = document.getElementById(id);
   obj.style.position = "absolute";

   var objsMove = obj.getElementsByClassName("sys-move");
   Object.keys(objsMove).map(function(objectKey, index) {
      objsMove[objectKey].onmousedown = function(){
         window.drag_obj = obj;
         window.drag_obj_x = window.drag_x_pos - obj.offsetLeft;
         window.drag_obj_y = window.drag_y_pos - obj.offsetTop;
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
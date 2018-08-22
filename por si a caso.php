
<script type="text/javascript">
	//Traigo consulta en JSON
	var json_array=eval(<?php echo $obJSON;?>);//Esta linea trae el arreglo antes convertido a formato JSON desde el servidor, para poder manipularlo dentro de javascript

	//Funciones
	function multipleEventsListeners(elem, events, func) {
 		var event = events.split(' ');
  		for (var i = 0; i < event.length; i++) {
    		elem.addEventListener(event[i], func);
  		}
	}
	function agregarProducto(){
		var valu=document.getElementById("codigo").value;
		for(i=0;i<json_array.length;i++){
			if(json_array[i][i]==valu){

			}
		}
	}
	function existe(string){
		retorno=0;
		var x=document.getElementById("t_cuenta").rows.length;
		if(x>1)
			for(i=1;i<x;i++){
				var elemento=document.getElementById("t_cuenta").rows[i].cells;
				if(elemento[0].innerHTML==string)
					retorno=1;
			}
		return retorno;
	}
	var cantidades=[];
	var btn_agregar=document.getElementById("agregar");
	var datalist=document.getElementById("codigos");
	var index=datalist.selectedIndex;
	var input_codigos=document.getElementById("codigo");
	var agregados=document.getElementById("t_cuenta");
	var btn_total=document.getElementById("guardar");
	multipleEventsListeners(input_codigos,"change keyup keydown",function(){
		index=(document.getElementById("codigo").value)-1;
		//alert(index);
	});
	btn_agregar.addEventListener("click",function(){
		var tblBody=document.createElement("tbody");
		var val_codigo=document.getElementById("codigo").value;
		if(val_codigo!=""||val_codigo!=0&&cantidades[index]<json_array[index][3]){
			cantidades[index]++;		
			if(existe(json_array[index][1])==0){
				//Se crea una nueva fila
				var fila=document.createElement("tr");
				//Se agrega la columna de codigo
				var celda=document.createElement("td");
				var textoCelda=document.createTextNode(json_array[index][1]);
				celda.appendChild(textoCelda);
				celda.setAttribute("id","codigo_"+json_array[index][1]);
				fila.appendChild(celda);
				//Se agrega la columna de nombre producto
				celda=document.createElement("td");
				textoCelda=document.createTextNode(json_array[index][2]);
				celda.appendChild(textoCelda);
				celda.setAttribute("id","nombre_"+json_array[index][1]);
				fila.appendChild(celda);
				//Se agrega la columna de cantidad del producto
				celda=document.createElement("td");
				//textoCelda=document.createTextNode(cantidades[index]);
				var num_cantidad=document.createElement("input");
				num_cantidad.setAttribute("type","text");
				num_cantidad.setAttribute("class","btn_tbl");
				num_cantidad.setAttribute("id","num_"+json_array[index][1]);
				num_cantidad.readOnly=false;
				num_cantidad.setAttribute("value",cantidades[index]);
				celda.appendChild(num_cantidad);
				celda.setAttribute("id","cantidad_"+json_array[index][1]);
				fila.appendChild(celda);
				//Se agrega la columna de precio del producto
				celda=document.createElement("td");
				textoCelda=document.createTextNode("$ "+json_array[index][4]);
				celda.appendChild(textoCelda);
				celda.setAttribute("id","precio_"+json_array[index][1]);
				fila.appendChild(celda);
				//Se agrega la columna de precio del producto
				celda=document.createElement("td");
				btn_modify=document.createElement("button");
				btn_modify.setAttribute("id","button_"+json_array[index][1]);
				btn_modify.setAttribute("value","Modificar");
				btn_modify.innerText="Modificar";
				btn_modify.setAttribute("class","btn_tbl");
				celda.appendChild(btn_modify);
				celda.setAttribute("id","button_"+json_array[index][1]);
				fila.appendChild(celda);
				//Se acumula la fila en un elemento para al final agergar todas las nuevas filas a la tabla
				tblBody.appendChild(fila);
				//agregados.appendChild(fila);
				agregados.appendChild(tblBody);
				agregados.setAttribute("border","1");
				//unidades.value="#"+(array_productos[index].units-cantidades[index]);
			}
			if(existe(json_array[index][1])==1&&(json_array[index][3]-cantidades[index])>=0){
				var x=document.getElementById("t_cuenta").rows.length;
				for(j=1;j<x;j++){
					var elemento=document.getElementById("t_cuenta").rows[j].cells;
					if(elemento[0].innerHTML==json_array[index][1]){
						elemento[2].innerHTML=cantidades[index];
					}
				}
			}
		}
	});
	for(i=0;i<json_array.length;i++)
		cantidades.push(0);
	var txt_codigo=document.getElementById("codigo");
	var txt_cantidad=document.getElementById("cantidad");
	/*multipleEventsListeners(txt_codigo,"change keyup",function(){
		
	});*/
	btn_total.addEventListener("click",function(){
		var x=document.getElementById("t_cuenta").rows.length;
		var str_send="";
		for(j=1;j<x;j++){
			var elemento=document.getElementById("t_cuenta").rows[j].cells;
			str_send+=elemento[0].innerHTML+","+elemento[1].innerHTML+","+elemento[2].innerHTML+",";
			for(i=0;i<json_array.length;i++){
				if(elemento[0].innerHTML==json_array[i][1]){
					str_send+=elemento[3]+"|";
					break;
				}
			}
		}
		window.location="";
	});
</script>
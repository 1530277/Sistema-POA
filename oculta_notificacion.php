<script>
	function ocultar_elementos(){
		var recibe_elemntos=document.getElementsByName('notify');
		for(i=0;i<recibe_elemntos.length;i++){
			recibe_elemntos[i].style.display='none';
		}
	}
	setTimeout("ocultar_elementos()",10000);
</script>
// Formatando a Data
var data = new Date();
var dataFormatada = ("0" + data.getDate()).substr(-2) + "/" + ("0" + (data.getMonth() + 1)).substr(-2) + "/" + data.getFullYear();
//console.log(dataFormatada); 
document.getElementById("data").value = dataFormatada;

function carrega_varas(){
	var cidade = document.getElementById("cidade");			
	var item_cidade = cidade.selectedIndex;	
	//console.log(item_cidade);
	var varas = document.getElementById("vara_qtd");	
	varas.selectedIndex = item_cidade;	
	//console.log('->' + vara.value);
	var vara = document.getElementById("vara");
	vara.options.length=0;
	for (i = 0; i < varas.value; i++) {
		//console.log(i+1);
		var opt = document.createElement("option");
		opt.text = i+1;
		vara.add(opt);
	}
}


// Ao clicar no combo check_data
document.getElementById("check_data").onclick = function() {    
	var objeto = document.getElementById("data").disabled;
	if (objeto) {
		document.getElementById("data").disabled = false;
		document.getElementById("data").focus();		
	}else{
		document.getElementById("data").disabled = true;
	}	
};	

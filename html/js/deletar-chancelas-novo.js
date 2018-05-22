// Formatando a Data
var data = new Date();
var dataFormatada = ("0" + data.getDate()).substr(-2) + "/" + ("0" + (data.getMonth() + 1)).substr(-2) + "/" + data.getFullYear();
document.getElementById("data").value = dataFormatada;
buscaUtimaChancela();
document.getElementById("data").focus();		

// desativo mensagem de erro
document.getElementById("erroChancelaFinal").style.display = 'none';

//Teclar Enter no input chancela_Inicial
function Total() {	
		limpaMsg();
		
		let chancelaInicial = document.getElementById("chancelaInicial");	
		let chancelaFinal = document.getElementById("chancelaFinal");	
		let totalDia = document.getElementById("total");	
		
		
		//console.log(isNaN(parseInt(chancelaFinal.value)));			

		//verificação de dados
		if (isNaN(parseInt(chancelaFinal.value))){
			chancelaFinal.value="";
			totalDia = "0";
			chancelaFinal.focus();
			return;

		}else{

			let total = (parseInt(chancelaFinal.value) - parseInt(chancelaInicial.value))+1;
			
			if (total > 0){	
				document.getElementById("erroChancelaFinal").style.display = 'none';
				totalDia.value = total;
				document.getElementById("submit").disabled=false;

			}else{
				document.getElementById("erroChancelaFinal").style.display = 'inline';
				chancelaFinal.value="";
				totalDia.value = "0";
				chancelaFinal.focus();
				document.getElementById("submit").disabled=true;

			}
		}			
		
};

// Informa a ultima chancela
function buscaUtimaChancela(){		

	let maquinaNome = document.getElementById("maquinaId");
	let ultimaChancela = document.getElementById("ultimaChancela");	
	let chancelaInicial = document.getElementById("chancelaInicial");	
	
	ultimaChancela.selectedIndex = maquinaNome.selectedIndex;
	
	let valor = Number(ultimaChancela.value) + 1;
	chancelaInicial.value = valor;	

	document.getElementById("chancelaFinal").focus();

};

function limpaMsg(){                       
    if (document.getElementById("msg")!=null){               
        document.getElementById("msg").style.display = "none";
    }    
};

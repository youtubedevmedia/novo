<?php 
function formataTexto($texto){
	return nl2br(stripslashes($texto));
}

function formataMoeda($valor, $tipo = null){
	if ($tipo == null) {
		return number_format($valor, 2, ',', '');
	} else {
		return number_format($valor, 2, '.', '');
	}
}

function formataData($data) {
	return date("d/m/Y", strtotime($data)); 
}

function retornaNomeMes($mes){

	switch ($mes) {
		case '01':	return "Janeiro";	break;
		case '02':	return "Fevereiro";	break;
		case '03':	return "Março";		break;
		case '04':	return "Abril";		break;
		case '05':	return "Maio";		break;
		case '06':	return "Junho";		break;
		case '07':	return "Julho";		break;
		case '08':	return "Agosto";	break;
		case '09':	return "Setembro";	break;
		case '10':	return "Outubro";	break;
		case '11':	return "Novembro";	break;
		case '12':	return "Dezembro";	break;
		default:	return "atual";		break;
	}
}
?>
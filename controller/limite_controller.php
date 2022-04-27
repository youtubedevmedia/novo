<?php 
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/limite_model.php");

switch ($_SERVER['REQUEST_METHOD']) {
	case 'POST': $funcao = $_POST['acao']; break;
	default: 
		$funcao = "";
		break;
}

switch ($funcao) {
	case 'ajustarLimite': ajustarLimite($_POST); break;
	case 'adicionarGasto': adicionarGasto($_POST); break;
}

function ajustarLimite($dados){

	$id_usuario = $_SESSION['id_usuario'];
	$valor_limite = addslashes($dados['limite']);

	$limite = new Limite();
	$rs_limite = $limite->limiteAtualizar($id_usuario, $valor_limite);
	
	if ($rs_limite) {
		$_SESSION['msg_retorno'] = "Limite atualizado com sucesso!";
		header("Location: https://fernandogaspar.dev.br/controle-diario/configuracao.php");
		exit;
	} else {
		$_SESSION['msg_retorno'] = "Erro ao atualizar limite.";
		header("Location: https://fernandogaspar.dev.br/controle-diario/configuracao.php");
		exit;
	}
}

function adicionarGasto($dados){

	$id_usuario_logado = $_SESSION['id_usuario'];

	$id_usuario = addslashes($dados['id_usuario']);
	$titulo = addslashes($dados['titulo']);
	$id_categoria = addslashes($dados['categoria']);
	$valor = addslashes($dados['valor']);
	$data = addslashes($dados['data']);
	$descricao = addslashes($dados['descricao']);

	if ($id_usuario_logado != $id_usuario) {
		$_SESSION['msg_retorno'] = "Erro não foi possivel adiconar o registro, usuario invalido.";
		header("Location: Location: https://fernandogaspar.dev.br/controle-diario/registro/novo-registro.php");
		exit;
	}

	$limite = new Limite();
	$rs_limite = $limite->logAdicionarGasto($id_usuario, $titulo, $id_categoria, $valor, $data, $descricao);

	if ($rs_limite) {
		header("Location: https://fernandogaspar.dev.br/controle-diario/");
		exit;
	} else {
		$_SESSION['msg_retorno'] = "Erro não foi possivel adiconar o registro.";
		header("Location: https://fernandogaspar.dev.br/controle-diario/registro/novo-registro.php");
		exit;
	}
}
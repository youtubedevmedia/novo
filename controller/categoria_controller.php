<?php 
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/categoria_model.php");

switch ($_SERVER['REQUEST_METHOD']) {
	case 'POST': $funcao = $_POST['acao']; break;
	default: 
		$funcao = "";
		break;
}

switch ($funcao) {
	case 'categoriaCadastrar': cadastrarCategoria($_POST); break;
}

function cadastrarCategoria($dados){

	$id_usuario = $_SESSION['id_usuario'];
	$descricao = addslashes($dados['descricao']);

	$categoria = new Categoria();
	$rs_categoria = $categoria->categoriaAdicionar($id_usuario, $descricao);

	if ($rs_categoria) {
		$_SESSION['msg_retorno'] = "Categoria adicionada com sucesso!";
		header("Location: https://fernandogaspar.dev.br/controle-diario/configuracao.php");
		exit;
	} else {
		$_SESSION['msg_retorno'] = "Erro ao adicionar categoria.";
		header("Location: https://fernandogaspar.dev.br/controle-diario/configuracao.php");
		exit;
	}
}
?>
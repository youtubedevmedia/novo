<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/usuario_model.php");
require_once($servidor."/model/categoria_model.php");

$usuario = new Usuario();
$id_usuario = $usuario->usuarioVerificaLogado();

$id_categoria = addslashes($_GET['id']);
$url_retorno = $_SERVER["HTTP_REFERER"];

$categoria = new Categoria();

$temAssociacao = $categoria->categoriaAssociadaLog($id_usuario, $id_categoria);

if (!$temAssociacao) {
	$deletar = $categoria->categoriaDeletar($id_usuario, $id_categoria);

	if ($deletar) {
		$_SESSION['msg_retorno'] = "Categoria deletado com sucesso!";
		header("Location: $url_retorno ");
		exit;
	} else {
		$_SESSION['msg_retorno'] = "Erro ao deletar.";
		header("Location: $url_retorno ");
		exit;
	}
} else {
	$_SESSION['msg_retorno'] = "Não foi possivel deletar. Existem registros associados a essa categoria, para deletar é preciso remover os custos associados a essa categoria.";
	header("Location: $url_retorno ");
	exit;
}
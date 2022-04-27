<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/usuario_model.php");
require_once($servidor."/model/limite_model.php");

$usuario = new Usuario();
$id_usuario = $usuario->usuarioVerificaLogado();

$id_registo = addslashes($_GET['id']);
$url_retorno = $_SERVER["HTTP_REFERER"];

$limite = new Limite();
$deletar = $limite->logRegistroDeletar($id_usuario, $id_registo);

if ($deletar) {
	$_SESSION['msg_retorno'] = "Registro deletado com sucesso!";
	header("Location: $url_retorno ");
	exit;
} else {
	$_SESSION['msg_retorno'] = "Erro ao deletar.";
	header("Location: $url_retorno ");
	exit;
}
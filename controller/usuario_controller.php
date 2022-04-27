<?php 
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/usuario_model.php");

switch ($_SERVER['REQUEST_METHOD']) {
	case 'POST': $funcao = $_POST['acao']; break;
	default: 
		$funcao = "";
		break;
}

switch ($funcao) {
	case 'autenticarUsuario': autenticarUsuario($_POST); break;
}

function autenticarUsuario($dados){

	$email = addslashes($dados['email']);
	$senha = addslashes($dados['senha']);

	$usuario = new Usuario();
	$autenticado = $usuario->usuarioLogin($email, $senha);

	if ($autenticado) {
		header("Location: https://fernandogaspar.dev.br/controle-diario/");
		exit;
	} else {
		$_SESSION['erro_autenticacao'] = "Erro ao realizar login, verifique os dados informados.";
		header("Location: https://fernandogaspar.dev.br/controle-diario/login.php");
		exit;
	}
}
?>
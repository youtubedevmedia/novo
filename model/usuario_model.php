<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/conexao.php");
class Usuario
{	
	public function usuarioLogin(string $email, string $senha) : bool{
		$con = new Conexao();
		
		$autenticado = false;

		$sql = "SELECT id, nome FROM usuario WHERE email = '". $email ."' AND senha = '". $senha ."'";
		$rs = $con->select($sql);

		if (count($rs) > 0) {
			$autenticado = true;
			$id_usuario = $rs[0]->id;
			$nome_usuario = $rs[0]->nome;

			$_SESSION['autenticado'] = $autenticado;
			$_SESSION['id_usuario'] = $id_usuario;
			$_SESSION['nome_usuario'] = $nome_usuario;
		}
		return $autenticado;
	}

	public function usuarioLogout(){
		unset($_SESSION['autenticado']);
		unset($_SESSION['id_usuario']);
  		unset($_SESSION['nome_usuario']);
  		header("Location: https://fernandogaspar.dev.br/controle-diario/login.php");
		exit;
	}

	public function usuarioVerificaLogado() {
		if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] === false) {
			header("Location: https://fernandogaspar.dev.br/controle-diario/login.php");
			exit;
		} else {
			return $_SESSION['id_usuario'];
		}
	} 
}
?>
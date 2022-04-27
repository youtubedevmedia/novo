<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/conexao.php");
class Categoria
{	
	private $tabela = "categoria";
	private $tabela_log = "valor_log";

	public function categoriaAdicionar(int $id_usuario, string $descricao) {
		$con = new Conexao();

		$param = array(
			':id_usuario' => $id_usuario,
			':descricao' => $descricao
		);
		$sql = "INSERT INTO $this->tabela (id_usuario, descricao, status) VALUES (:id_usuario, :descricao, 1)";
		$rs = $con->insert($sql, $param);

		if ($rs > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function categoriaDeletar(int $id_usuario, int $id_categoria) : float{
		$con = new Conexao();
		
		$param = array(
			':id' => $id_categoria,
			':id_usuario' => $id_usuario
		);
		$sql = "DELETE FROM $this->tabela WHERE id_usuario = :id_usuario AND id = :id";
		$rs = $con->delete($sql, $param);

		if ($rs > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function categoriaRetornaNome(int $id_usuario, int $id_categoria) {
		$con = new Conexao();
		
		$sql = "SELECT descricao FROM $this->tabela WHERE status = 1 AND (id_usuario =  $id_usuario OR id_usuario = -1) AND id = $id_categoria";
		$rs = $con->select($sql);

		if (count($rs) > 0) {
			return $rs[0]->descricao;
		} else {
			return false;
		}
	}

	public function categoriaLista(int $id_usuario) {
		$con = new Conexao();
		
		$sql = "SELECT id, descricao FROM $this->tabela WHERE status = 1 AND (id_usuario =  $id_usuario OR id_usuario = -1) ORDER BY descricao";
		$rs = $con->select($sql);

		if (count($rs) > 0) {
			return $rs;
		} else {
			return false;
		}
	}

	public function categoriaListaUsuario(int $id_usuario) {
		$con = new Conexao();
		
		$sql = "SELECT id, descricao FROM $this->tabela WHERE status = 1 AND id_usuario =  $id_usuario";
		$rs = $con->select($sql);

		if (count($rs) > 0) {
			return $rs;
		} else {
			return false;
		}
	}

	public function categoriaAssociadaLog(int $id_usuario, $id_categoria) {
		$con = new Conexao();
		
		$sql = "SELECT id  FROM $this->tabela_log WHERE status = 1 AND id_usuario =  $id_usuario AND id_categoria = $id_categoria";
		$rs = $con->select($sql);

		if (count($rs) > 0) {
			return true;
		} else {
			return false;
		}
	}
}